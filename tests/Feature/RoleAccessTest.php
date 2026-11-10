<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
        $this->seed(UserSeeder::class);
    }

    public function test_admin_it_can_manage_master_data_and_users(): void
    {
        $adminIt = User::where('username', 'admin_it')->first();

        $this->assertTrue(Gate::forUser($adminIt)->allows('manage-master-data'));
        $this->assertTrue(Gate::forUser($adminIt)->allows('manage-users'));
    }

    public function test_admin_it_is_strictly_forbidden_from_approval_payment_and_confirmation(): void
    {
        $adminIt = User::where('username', 'admin_it')->first();

        $this->assertFalse(Gate::forUser($adminIt)->allows('approve-request'));
        $this->assertFalse(Gate::forUser($adminIt)->allows('process-payment'));
        $this->assertFalse(Gate::forUser($adminIt)->allows('confirm-receipt'));
    }

    public function test_approver_can_approve_but_cannot_manage_users(): void
    {
        $approver = User::where('username', 'approver')->first();

        $this->assertTrue(Gate::forUser($approver)->allows('approve-request'));
        $this->assertFalse(Gate::forUser($approver)->allows('manage-users'));
        $this->assertFalse(Gate::forUser($approver)->allows('process-payment'));
    }

    public function test_admin_pencairan_can_process_payment_but_cannot_approve(): void
    {
        $adminPencairan = User::where('username', 'admin_pencairan')->first();

        $this->assertTrue(Gate::forUser($adminPencairan)->allows('process-payment'));
        $this->assertFalse(Gate::forUser($adminPencairan)->allows('approve-request'));
        $this->assertFalse(Gate::forUser($adminPencairan)->allows('confirm-receipt'));
    }

    public function test_penerima_can_confirm_receipt_only(): void
    {
        $penerima = User::where('username', 'penerima')->first();

        $this->assertTrue(Gate::forUser($penerima)->allows('confirm-receipt'));
        $this->assertFalse(Gate::forUser($penerima)->allows('approve-request'));
        $this->assertFalse(Gate::forUser($penerima)->allows('process-payment'));
        $this->assertFalse(Gate::forUser($penerima)->allows('manage-master-data'));
    }
}

