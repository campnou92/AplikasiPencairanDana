<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use App\Services\AuditService;
use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getUsernameFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
            ])
            ->statePath('data');
    }

    protected function getUsernameFormComponent(): Component
    {
        return TextInput::make('username')
            ->label('Username')
            ->required()
            ->autocomplete('username')
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'username' => $data['username'],
            'password' => $data['password'],
        ];
    }

    public function authenticate(): ?LoginResponse
    {
        try {
            $data = $this->form->getState();

            $user = User::where('username', $data['username'])->first();

            if ($user && $user->status !== 'aktif') {
                AuditService::log(
                    action: 'login_blocked_inactive',
                    entity: 'User',
                    entityId: (string) $user->user_id,
                    before: null,
                    after: ['username' => $data['username']],
                    reason: 'Login ditolak karena akun nonaktif',
                    actor: $data['username']
                );

                throw ValidationException::withMessages([
                    'data.username' => 'Akun Anda berstatus nonaktif. Silakan hubungi Admin IT.',
                ]);
            }

            $response = parent::authenticate();

            AuditService::log(
                action: 'login',
                entity: 'User',
                entityId: (string) auth()->id(),
                before: null,
                after: ['username' => $data['username']],
                reason: 'Login berhasil via panel Filament',
                actor: $data['username']
            );

            return $response;
        } catch (ValidationException $e) {
            AuditService::log(
                action: 'login_failed',
                entity: 'User',
                entityId: null,
                before: null,
                after: ['username' => $this->data['username'] ?? 'unknown'],
                reason: 'Percobaan login gagal: kredensial salah atau akun nonaktif',
                actor: $this->data['username'] ?? 'guest'
            );

            throw $e;
        }
    }
}

