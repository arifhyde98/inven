<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class ReportAndExportTest extends TestCase
{
    public function test_daily_sales_report_renders_successfully(): void
    {
        $admin = User::where('role_id', 1)->first();

        $response = $this->actingAs($admin)->get(route('laporan.penjualan_harian'));
        $response->assertStatus(200);
        $response->assertSee('Laporan Penjualan Harian');
    }

    public function test_monthly_sales_report_renders_successfully(): void
    {
        $admin = User::where('role_id', 1)->first();

        $response = $this->actingAs($admin)->get(route('laporan.penjualan_bulanan'));
        $response->assertStatus(200);
        $response->assertSee('Laporan Penjualan Bulanan');
    }

    public function test_stock_report_renders_successfully(): void
    {
        $admin = User::where('role_id', 1)->first();

        $response = $this->actingAs($admin)->get(route('laporan.stok'));
        $response->assertStatus(200);
        $response->assertSee('Laporan Stok Barang');
    }

    public function test_excel_export_daily_sales_returns_valid_spreadsheet(): void
    {
        $admin = User::where('role_id', 1)->first();

        $response = $this->actingAs($admin)->get(route('export.penjualan'));
        $response->assertStatus(200);
        $this->assertStringContainsString('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', $response->headers->get('content-type'));
        $this->assertStringContainsString('attachment;', $response->headers->get('content-disposition'));
    }

    public function test_excel_export_stock_report_returns_valid_spreadsheet(): void
    {
        $admin = User::where('role_id', 1)->first();

        $response = $this->actingAs($admin)->get(route('export.stok'));
        $response->assertStatus(200);
        $this->assertStringContainsString('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', $response->headers->get('content-type'));
        $this->assertStringContainsString('attachment;', $response->headers->get('content-disposition'));
    }

    public function test_excel_export_orders_returns_valid_spreadsheet(): void
    {
        $admin = User::where('role_id', 1)->first();

        $response = $this->actingAs($admin)->get(route('export.pesanan'));
        $response->assertStatus(200);
        $this->assertStringContainsString('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', $response->headers->get('content-type'));
        $this->assertStringContainsString('attachment;', $response->headers->get('content-disposition'));
    }

    public function test_excel_export_expenses_returns_valid_spreadsheet(): void
    {
        $admin = User::where('role_id', 1)->first();

        $response = $this->actingAs($admin)->get(route('export.pengeluaran'));
        $response->assertStatus(200);
        $this->assertStringContainsString('application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', $response->headers->get('content-type'));
        $this->assertStringContainsString('attachment;', $response->headers->get('content-disposition'));
    }
}
