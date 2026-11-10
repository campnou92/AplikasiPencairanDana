<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
        $this->seed(UserSeeder::class);
    }

    public function test_all_eight_roles_are_seeded(): void
    {
        $expectedRoles = [
            'admin_pencairan',
            'approver',
            'kepala_biro',
            'penerima',
            'pembukuan',
            'keuangan_arsip',
            'yayasan_arsip',
            'admin_it',
        ];

        foreach ($expectedRoles as $role) {
            $user = User::where('username', $role)->first();
            $this->assertNotNull($user, "User for role {$role} should exist.");
            $this->assertTrue($user->hasRole($role), "User {$role} should have role {$role}.");
            $this->assertEquals('aktif', $user->status);
        }
    }

    public function test_user_can_authenticate_with_valid_username_and_password(): void
    {
        $attempt = Auth::attempt([
            'username' => 'admin_it',
            'password' => 'Password123!',
        ]);

        $this->assertTrue($attempt);
        $this->assertAuthenticated();
    }

    public function test_user_cannot_authenticate_with_invalid_password(): void
    {
        $attempt = Auth::attempt([
            'username' => 'admin_it',
            'password' => 'WrongPassword',
        ]);

        $this->assertFalse($attempt);
        $this->assertGuest();
    }

    public function test_inactive_user_cannot_access_panel(): void
    {
        $user = User::where('username', 'penerima')->first();
        $user->update(['status' => 'nonaktif']);

        $panel = \Filament\Facades\Filament::getPanel('admin');
        $this->assertFalse($user->canAccessPanel($panel));
    }
}

