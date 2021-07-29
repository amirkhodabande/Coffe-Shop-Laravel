<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Check user can log in successfully.
     */
    public function test_correct_response_after_user_logs_in()
    {
        $user = User::factory()->create();
        $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password'
        ])->assertOk()
            ->assertJson([
                'message' => 'User logged in successfully.',
            ]);
    }

    /**
     * Check user will get correct response after logging process failed.
     */
    public function test_a_user_receives_correct_message_when_passing_in_wrong_credentials()
    {
        $user = User::factory()->create();

        $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrongPassword'
        ])->assertStatus(422)
            ->assertJson([
                'message' => 'These credentials do not match our records.',
            ]);
    }
}
