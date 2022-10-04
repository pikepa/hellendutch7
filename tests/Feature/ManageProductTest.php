<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Tests\TestCase;

class ManageProductTest extends TestCase
{
    use withFaker, RefreshDatabase;

    /** @test */
    public function a_product_detail_can_be_viewed()
    {
        $this->signIn();
        $product=Product::factory()->create();

        $response = $this->get('/product/'.$product->id)
                ->assertStatus(200)
                ->assertSee($product->title);

        $this->assertCount(1, Product::all());
    }

    /** @test */
    public function a_product_can_be_added()
    {
        $this->signIn();

        $response = $this->post('/product', $this->data());
       
        $product = Product::first();
      //  dd($product);
        $response->assertRedirect($product->path());
        $this->assertCount(1, Product::all());
    }

    /** @test */
    public function a_product_can_be_updated()
    {
        $this->signIn();
        $this->post('/product', $this->data());

        $product = Product::first();

        $response = $this->patch($product->path(), [
            'title' => 'Changed Title',
            'description' => 'New Description',
            'status'=>'For Sale',
            'price' => '10000',
            'discount' => '0',
            'publish_at'=>'2019-07-02',
            'owner_id'=>Auth::id(),
        ]);
        $this->assertEquals('Changed Title', Product::first()->title);
        $this->assertEquals(1, Product::first()->id);
        $response->assertRedirect($product->fresh()->path());
    }

    /** @test */
    public function a_product_can_be_deleted()
    {
        $this->signIn();

        $product=Product::factory()->create();

        $this->assertCount(1, Product::all());

        $response = $this->delete('/product/'.$product->id);
dd(Product::count());
        $this->assertCount(0, Product::all());
     //   $response->assertRedirect('/');
    }

    /** @test */
    public function a_product_can_belong_to_a_category()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create();

        $category->products()->sync($product);

        $this->assertDatabaseHas('category_product', [
            'category_id' => $category->id,
            'Product_id' => $product->id,
        ]);
    }

    private function data()
    {
        return [
            'title' => 'Cool Book Title',
            'slug' => Str::slug('Cool Book Title', '-'),
            'description' => 'Victors Ferfy',
            'status'=>'For Sale',
            'price' => '10000',
            'discount' => '0',
            'publish_at'=>'2019-07-02',
            'owner_id'=>Auth::id(),
        ];
    }
}
