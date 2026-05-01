<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Sector;
use App\Models\Branch;
use App\Models\Category;

class OrderRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_can_place_order_with_details()
    {
        $sector = Sector::create(['name_ar' => 'Test Sector', 'name_en' => 'Test Sector', 'name_zh' => 'Test Sector']);
        $branch = Branch::create(['name_ar' => 'Test Branch', 'name_en' => 'Test Branch', 'name_zh' => 'Test Branch', 'sector_id' => $sector->id]);
        $category = Category::create(['name_ar' => 'Test Category', 'name_en' => 'Test Category', 'name_zh' => 'Test Category', 'branch_id' => $branch->id]);

        $seller = User::factory()->create(['type' => 'company']);
        $client = User::factory()->create(['type' => 'client']);

        $product = Product::create([
            'user_id' => $seller->id,
            'sector_id' => $sector->id,
            'branch_id' => $branch->id,
            'category_id' => $category->id,
            'name' => 'Test Product',
            'price' => 100,
            'min_order_quantity' => 200,
            'quantity' => 1000,
            'shipping_unit_type' => 'CBM',
            'currency_code' => 'USD'
        ]);

        $this->actingAs($client);

        $response = $this->postJson(route('orders.store'), [
            'product_id' => $product->id,
            'quantity' => 250,
            'shipping_unit_type' => '40ft',
            'notes' => 'Test notes'
        ]);

        $response->assertStatus(200)
                 ->assertJson(['success' => true]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $client->id,
            'product_id' => $product->id,
            'quantity' => 250,
            'shipping_unit_type' => '40ft',
            'notes' => 'Test notes'
        ]);
    }

    public function test_order_fails_if_quantity_is_less_than_minimum()
    {
        $sector = Sector::create(['name_ar' => 'Test Sector', 'name_en' => 'Test Sector', 'name_zh' => 'Test Sector']);
        $branch = Branch::create(['name_ar' => 'Test Branch', 'name_en' => 'Test Branch', 'name_zh' => 'Test Branch', 'sector_id' => $sector->id]);
        $category = Category::create(['name_ar' => 'Test Category', 'name_en' => 'Test Category', 'name_zh' => 'Test Category', 'branch_id' => $branch->id]);

        $seller = User::factory()->create(['type' => 'company']);
        $client = User::factory()->create(['type' => 'client']);

        $product = Product::create([
            'user_id' => $seller->id,
            'sector_id' => $sector->id,
            'branch_id' => $branch->id,
            'category_id' => $category->id,
            'name' => 'Test Product',
            'price' => 100,
            'min_order_quantity' => 200,
            'quantity' => 1000,
            'shipping_unit_type' => 'CBM',
            'currency_code' => 'USD'
        ]);

        $this->actingAs($client);

        $response = $this->postJson(route('orders.store'), [
            'product_id' => $product->id,
            'quantity' => 150,
            'shipping_unit_type' => 'CBM'
        ]);

        $response->assertStatus(422)
                 ->assertJson(['success' => false]);

        $this->assertDatabaseMissing('orders', [
            'product_id' => $product->id
        ]);
    }
}
