<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Login');
    }

    public function test_superadmin_can_authenticate_with_valid_credentials(): void
    {
        $response = $this->post('/login', [
            'username' => 'sadmin',
            'password' => 'asd',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard'));
    }

    public function test_admin_cabang_can_authenticate_with_valid_credentials(): void
    {
        $response = $this->post('/login', [
            'username' => 'admin1',
            'password' => 'asd',
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(route('dashboard'));
    }

    public function test_users_cannot_authenticate_with_invalid_password(): void
    {
        $response = $this->post('/login', [
            'username' => 'sadmin',
            'password' => 'wrongpassword',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('username');
    }

    public function test_inactive_or_blocked_user_cannot_login(): void
    {
        // Find or temporarily create an inactive user
        $inactiveUser = User::updateOrCreate(
            ['username' => 'blocked_user'],
            [
                'nama' => 'Blocked User',
                'email' => 'blocked@example.com',
                'password' => Hash::make('secret123'),
                'role_id' => 2,
                'penempatan_cabang' => 1,
                'status' => 0,
            ]
        );

        $response = $this->post('/login', [
            'username' => 'blocked_user',
            'password' => 'secret123',
        ]);

        $this->assertGuest();
        $response->assertSessionHasErrors('username');

        // Cleanup
        $inactiveUser->delete();
    }

    public function test_authenticated_user_can_logout(): void
    {
        $user = User::where('username', 'sadmin')->first();

        $response = $this->actingAs($user)->post('/logout');

        $this->assertGuest();
        $response->assertRedirect(route('login'));
    }
}
