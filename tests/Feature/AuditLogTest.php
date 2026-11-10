<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\Unit;
use App\Models\User;
use Database\Seeders\MasterDataSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class AuditLogTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
        $this->seed(UserSeeder::class);
        $this->seed(MasterDataSeeder::class);
    }

    public function test_creating_master_data_records_audit_log(): void
    {
        $admin = User::where('username', 'admin_it')->first();
        Auth::login($admin);

        $initialCount = AuditLog::count();

        $unit = Unit::create([
            'nama_unit' => 'Unit Riset & Inovasi',
            'status' => 'aktif',
        ]);

        $this->assertGreaterThan($initialCount, AuditLog::count());

        $latestLog = AuditLog::latest('log_id')->first();
        $this->assertEquals('admin_it', $latestLog->actor);
        $this->assertEquals('created', $latestLog->action);
        $this->assertEquals('Unit', $latestLog->entity);
        $this->assertEquals((string) $unit->unit_id, $latestLog->entity_id);
        $this->assertEquals('Unit Riset & Inovasi', $latestLog->before_after['after']['nama_unit']);
    }

    public function test_updating_master_data_records_before_and_after_audit_log(): void
    {
        $admin = User::where('username', 'admin_it')->first();
        Auth::login($admin);

        $unit = Unit::first();
        $oldName = $unit->nama_unit;
        $newName = 'Biro Administrasi Umum dan Kepegawaian';

        $unit->update([
            'nama_unit' => $newName,
        ]);

        $latestLog = AuditLog::latest('log_id')->first();
        $this->assertEquals('admin_it', $latestLog->actor);
        $this->assertEquals('updated', $latestLog->action);
        $this->assertEquals('Unit', $latestLog->entity);
        $this->assertEquals($oldName, $latestLog->before_after['before']['nama_unit']);
        $this->assertEquals($newName, $latestLog->before_after['after']['nama_unit']);
    }

    public function test_audit_logs_are_immutable(): void
    {
        $admin = User::where('username', 'admin_it')->first();
        $log = AuditLog::first();

        $this->assertNotNull($log);
        $this->assertFalse(Gate::forUser($admin)->allows('create', AuditLog::class));
        $this->assertFalse(Gate::forUser($admin)->allows('update', $log));
        $this->assertFalse(Gate::forUser($admin)->allows('delete', $log));
    }
}

