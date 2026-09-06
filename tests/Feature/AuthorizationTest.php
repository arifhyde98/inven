<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    public function test_unauthenticated_user_cannot_access_dashboard(): void
    {
        $response = $this->get('/dashboard');
        $response->assertRedirect(route('login'));
    }

    public function test_unauthenticated_user_cannot_access_pos(): void
    {
        $response = $this->get('/pos');
        $response->assertRedirect(route('login'));
    }

    public function test_superadmin_can_access_user_management(): void
    {
        $superadmin = User::where('role_id', 1)->first();

        $response = $this->actingAs($superadmin)->get(route('users.index'));
        $response->assertStatus(200);
        $response->assertSee('Admin Cabang');
    }

    public function test_superadmin_can_access_cabang_management(): void
    {
        $superadmin = User::where('role_id', 1)->first();

        $response = $this->actingAs($superadmin)->get(route('cabang.index'));
        $response->assertStatus(200);
        $response->assertSee('Data Cabang');
    }

    public function test_admin_cabang_cannot_access_user_management(): void
    {
        $admin = User::where('role_id', 2)->first();

        $response = $this->actingAs($admin)->get(route('users.index'));
        $response->assertStatus(403);
    }

    public function test_admin_cabang_cannot_access_cabang_management(): void
    {
        $admin = User::where('role_id', 2)->first();

        $response = $this->actingAs($admin)->get(route('cabang.index'));
        $response->assertStatus(403);
    }

    public function test_admin_cabang_can_access_their_pos_and_barang(): void
    {
        $admin = User::where('role_id', 2)->first();

        $responsePos = $this->actingAs($admin)->get(route('pos.index'));
        $responsePos->assertStatus(200);

        $responseBarang = $this->actingAs($admin)->get(route('barang.index'));
        $responseBarang->assertStatus(200);
    }
}
