<?php

namespace Tests\Feature;

use App\Models\AppSetting;
use App\Models\ExpenseType;
use App\Models\FiscalYear;
use App\Models\Np;
use App\Models\PaymentMethod;
use App\Models\Unit;
use App\Models\User;
use Database\Seeders\MasterDataSeeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Gate;
use Tests\TestCase;

class MasterDataTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(RoleSeeder::class);
        $this->seed(UserSeeder::class);
        $this->seed(MasterDataSeeder::class);
    }

    public function test_master_data_seeded_correctly(): void
    {
        $this->assertGreaterThanOrEqual(3, Unit::count());
        $this->assertGreaterThanOrEqual(3, Np::count());
        $this->assertEquals(2026, FiscalYear::getActiveYear());
        $this->assertNotNull(PaymentMethod::where('nama', 'Tunai')->first());
        $this->assertNotNull(PaymentMethod::where('nama', 'Transfer')->first());
        $this->assertNotNull(ExpenseType::where('nama', 'Biaya')->first());
        $this->assertNotNull(ExpenseType::where('nama', 'UM')->first());
        $this->assertNotNull(ExpenseType::where('nama', 'Lainnya')->first());
        $this->assertEquals('REQ/{tahun}/{urut}', AppSetting::getValue('format_nomor_req'));
        $this->assertEquals('BKK/{tahun_anggaran}/{urut}', AppSetting::getValue('format_nomor_bkk'));
    }

    public function test_only_admin_it_can_create_update_delete_unit(): void
    {
        $adminIt = User::where('username', 'admin_it')->first();
        $penerima = User::where('username', 'penerima')->first();
        $approver = User::where('username', 'approver')->first();

        $unit = Unit::first();

        // admin_it can create and update
        $this->assertTrue(Gate::forUser($adminIt)->allows('create', Unit::class));
        $this->assertTrue(Gate::forUser($adminIt)->allows('update', $unit));
        $this->assertTrue(Gate::forUser($adminIt)->allows('delete', $unit));

        // non-admin_it cannot create, update, or delete
        $this->assertFalse(Gate::forUser($penerima)->allows('create', Unit::class));
        $this->assertFalse(Gate::forUser($penerima)->allows('update', $unit));
        $this->assertFalse(Gate::forUser($penerima)->allows('delete', $unit));

        $this->assertFalse(Gate::forUser($approver)->allows('create', Unit::class));
        $this->assertFalse(Gate::forUser($approver)->allows('update', $unit));
        $this->assertFalse(Gate::forUser($approver)->allows('delete', $unit));
    }

    public function test_non_admin_can_view_master_data_for_reference(): void
    {
        $penerima = User::where('username', 'penerima')->first();
        $unit = Unit::first();

        $this->assertTrue(Gate::forUser($penerima)->allows('viewAny', Unit::class));
        $this->assertTrue(Gate::forUser($penerima)->allows('view', $unit));
    }
}

