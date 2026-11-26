<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    private function user(): User
    {
        $user = new User([
            'name' => 'Admin',
            'email' => 'admin@example.org',
            'password' => bcrypt('correct-password'),
            'addr' => 'Address',
            'tel' => '123',
            'image_name' => '',
        ]);
        $user->save();

        return $user;
    }

    public function test_the_login_page_loads(): void
    {
        $this->get('/auth/login')->assertOk()->assertSee('name="password"', false);
    }

    public function test_a_user_logs_in_with_correct_credentials(): void
    {
        $user = $this->user();

        $this->post('/auth/login', ['email' => $user->email, 'password' => 'correct-password'])
            ->assertRedirect('/');

        $this->assertAuthenticatedAs($user);
    }

    public function test_a_wrong_password_is_refused(): void
    {
        $user = $this->user();

        $this->from('/auth/login')
            ->post('/auth/login', ['email' => $user->email, 'password' => 'wrong'])
            ->assertRedirect('/auth/login')
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_guests_are_sent_to_the_login_page(): void
    {
        $this->get('/volunteers')->assertRedirect('/auth/login');
    }

    public function test_the_api_needs_a_login(): void
    {
        $this->getJson('/api/volunteers')->assertUnauthorized();
        $this->getJson('/search/city?term=a')->assertUnauthorized();
        $this->getJson('/cron/checkActions')->assertUnauthorized();
    }

    public function test_a_user_logs_out(): void
    {
        $this->actingAs($this->user())->get('/auth/logout')->assertRedirect('/');

        $this->assertGuest();
    }

    public function test_the_locale_prefix_sets_the_locale_cookie(): void
    {
        $this->get('/el/auth/login')
            ->assertRedirect('auth/login')
            ->assertCookie('locale', 'el', encrypted: false);
    }
}
