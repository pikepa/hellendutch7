<?php

namespace Tests\Feature;

use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageMessageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_guest_can_create_a_message()
    {
        $response = $this->get('/contactme')
            ->assertStatus(200)
            ->assertSee('Message');
    }

    /** @test */
    public function a_message_is_added_to_the_database()
    {
        $message = Message::factory()->create();

        $this->assertDatabaseHas('messages', ['subject' => $message->subject]);
    }

    /** @test */
    public function a_guest_can_not_view_the_message_index()
    {
        $message = Message::factory()->create();
        $response = $this->get('/message');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function a_signed_in_user_can_view_messages()
    {
        $this->signIn();
        $message = Message::factory()->create();
        $response = $this->get('/message');
        $response->assertStatus(200);
    }
}
