<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class ManageFileUploadTest extends TestCase
{
    use  RefreshDatabase;

    /** @test */
    public function can_upload_image()
    {
        $user = User::factory()->create();

        $file = UploadedFile::fake()->image('test.png');

        Storage::fake('images');

        Livewire::actingAs($user)
            ->test('images.upload')
            ->set('newAvatar', $file)
            ->call('submit');

        $user->refresh();

        $this->assertNotNull($user->avatar);
        Storage::disk('avatars')->assertExists($user->avatar);
    }
}
