<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_the_login_page()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertSee('ログイン');
    }

    /** @test */
    public function user_can_login_with_valid_credentials()
    {
        // ダミーデータの作成
        $user = User::create([
            'name' => 'テストユーザ',
            'email' => 'test@gmail.com',
            'password' => bcrypt('password'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@gmail.com',
            'password' => 'password',
        ]);

        $response->assertRedirect('/attendance');
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function email_is_required_for_login()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors('email');
    }

    /** @test */
    public function password_is_required_for_login()
    {
        $response = $this->post('/login', [
            'email' => 'test@gmail.com',
            'password' => '',
        ]);

        $response->assertSessionHasErrors('password');
    }

    /** @test */
    public function invalid_email_or_password_returns_error_message()
    {
        $response = $this->post('/login', [
            'email' => 'wrong-email@gmail.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors();
    }
}
