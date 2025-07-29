<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductCrudTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $customer;

    protected function setUp(): void
    {
        parent::setUp();

        // Migration + seed
        $this->artisan('migrate:fresh --seed');

        // Seedden al
        $this->admin    = User::where('role', 'admin')->firstOrFail();
        $this->customer = User::where('role', 'customer')->firstOrFail();

        if (Product::count() === 0) {
            Product::create([
                'name'           => 'Seed Ürün 1',
                'sku'            => 'SEED-001',
                'price'          => 50.00,
                'stock_quantity' => 10,
            ]);
        }
    }

    /** @test */
    public function anyone_can_list_products()
    {

        Product::firstOrFail();

        $response = $this->getJson('/api/products');
        $response->assertStatus(200)
            ->assertJsonStructure([['id','name','sku','price','stock_quantity']]);
    }

    /** @test */
    public function admin_can_create_update_and_delete_product()
    {
        $token = $this->admin->createToken('test')->plainTextToken;


        $create = $this->postJson('/api/products', [
            'name'           => 'Test Ürün',
            'sku'            => 'TEST-001',
            'price'          => 99.90,
            'stock_quantity' => 5,
        ], [
            'Authorization' => "Bearer $token",
            'Accept'        => 'application/json',
        ]);

        $create->assertStatus(201)
            ->assertJsonFragment(['sku' => 'TEST-001']);

        $id = $create->json('id');


        $update = $this->putJson("/api/products/{$id}", [
            'name'           => 'Test Ürün Güncel',
            'price'          => 120.00,
            'stock_quantity' => 3,
        ], [
            'Authorization' => "Bearer $token",
            'Accept'        => 'application/json',
        ]);

        $update->assertStatus(200)
            ->assertJsonFragment(['price' => 120.00]);


        // DELETE
        $delete = $this->deleteJson("/api/products/{$id}", [], [
            'Authorization' => "Bearer $token",
            'Accept'        => 'application/json',
        ]);

        $delete->assertStatus(200)
            ->assertJson(['message' => 'Kayıt başarıyla silindi']);
    }

    /** @test */
    public function customer_cannot_create_or_delete_product()
    {
        $token = $this->customer->createToken('test')->plainTextToken;

        $this->postJson('/api/products', [
            'name'           => 'X',
            'sku'            => 'X-001',
            'price'          => 1.00,
            'stock_quantity' => 1,
        ], [
            'Authorization' => "Bearer $token",
            'Accept'        => 'application/json',
        ])->assertStatus(403);

        $product = Product::first();

        $this->deleteJson("/api/products/{$product->id}", [], [
            'Authorization' => "Bearer $token",
            'Accept'        => 'application/json',
        ])->assertStatus(403);
    }
}
