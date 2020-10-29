<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageUserDetailsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_default_user_can_see_their_profile_page()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/profile/'.$user->id)->assertStatus(200)
            ->assertSee($user->name);
    }

    /** @test */
    public function a_guest_cannot_see_a_profile_page()
    {
        $user = User::factory()->create();

        $response = $this->get('/profile/'.$user->id)->assertRedirect('/login');
    }

    /** @test */
    public function a_logged_in_user_cannot_see_another_users_profile_page()
    {
        $user = User::factory()->create();
        $user2 = User::factory()->create();

        $this->actingAs($user);

        $response = $this->get('/profile/'.$user2->id)->assertStatus(403);
    }

    /** @test */
    public function an_authenticated_user_can_update_their_profile_name()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $user->name = 'Peter Pike';
        $user->save();
        $response = $this->get('/profile/'.$user->id)
            ->assertStatus(200)
            ->assertSee($user->name);
    }
}
