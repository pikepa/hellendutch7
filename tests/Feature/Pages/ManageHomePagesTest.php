<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;

uses(RefreshDatabase::class);

it('redirects unauthorised to login guest loads the dashboard page', function () {
    $this->get('/dashboard')->assertRedirect('/login');
});

it('loads dashboard when signed in user accesses it ', function () {
    $user = User::factory()->create();

    $this->actingAs($user)->get('/dashboard')
        ->assertStatus(200)
        ->assertSee('Dashboard');
});

test('a name is required', function () {
    Livewire::test('pages.manage-pages')
    ->set('name', '')
    ->set('title', 'Hellen Dutch')
    ->set('active', 'false')
    ->call('add')
    ->assertHasErrors(['name' => 'required']);
});
