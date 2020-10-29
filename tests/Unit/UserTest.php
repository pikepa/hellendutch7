<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_default_user_is_not_an_admin()
    {
        $user = User::factory()->create();

        $this->assertFalse($user->isAdmin());
    }

    /** @test */
    public function an_admin_user_is_an_admin()
    {
        $admin = User::factory()->create(['type' => 'admin']);

        $this->assertTrue($admin->isAdmin());
    }
}
