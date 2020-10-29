<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageCategoriesTest extends TestCase
{
    use  RefreshDatabase;

    /** @test */
    public function a_guest_can_not_create_a_category()
    {
        $response = $this->get('/category/create');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function a_category_can_be_added_to_the_database()
    {
        $category = Category::factory()->make();
        $category->save();
        $this->assertDatabaseHas('categories', ['category' => $category['category']]);
    }

    /** @test */
    public function a_guest_can_not_view_the_category_index()
    {
        $category = Category::factory()->create();
        $response = $this->get('/category');
        $response->assertRedirect('/login');
    }

    /** @test */
    public function a_SignedIn_user_can_view_the_category_index()
    {
        $this->signIn();
        $category = Category::factory()->create();
        $response = $this->get('/category');
        $response->assertStatus(200);
    }

    /** @test */
    public function a_guest_can_view_products_by_category()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create();

        $category->products()->sync($product);

        $response = $this->get('/bycategory/'.$category->id);
        $response->assertSee($product->title);
    }
}
