<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Tests\TestCase;

class OrderFlowTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $customer;
    protected $products;

    protected function setUp(): void
    {
        parent::setUp();

        // Migration + seed
        $this->artisan('migrate:fresh --seed');

        $this->admin    = User::where('role','admin')->firstOrFail();
        $this->customer = User::where('role','customer')->firstOrFail();

        $this->products = Product::all();
    }

    /** @test */
    public function customer_can_create_and_see_own_order_but_not_others()
    {
        $token = $this->customer->createToken('test')->plainTextToken;

        // POST /api/orders
        $payload = [
            'items' => [
                [
                    'product_id' => $this->products[0]->id,
                    'quantity'   => 2,
                ],
                [
                    'product_id' => $this->products[1]->id,
                    'quantity'   => 1,
                ],
            ],
        ];
        $res = $this->postJson('/api/orders', $payload, [
            'Authorization' => "Bearer $token"
        ]);

        $res->assertStatus(201)
            ->assertJsonStructure([
                'id',
                'status',
                'total_price',
                'items' => [
                    '*' => ['id','order_id','product_id','quantity','unit_price','product']
                ],
                'user' => ['id','name','email','role']
            ]);
        $orderId = $res->json('id');


        $list = $this->getJson('/api/orders', [
            'Authorization' => "Bearer $token"
        ]);
        $list->assertStatus(200)
            ->assertJsonCount(1);

        $otherOrderId = Order::where('user_id','<>',$this->customer->id)->first()->id;
        $this->getJson("/api/orders/{$otherOrderId}", [
            'Authorization' => "Bearer $token"
        ])->assertStatus(403);
    }

    /** @test */
    public function admin_can_see_all_orders()
    {

        $token = $this->admin->createToken('test')->plainTextToken;

        $list = $this->getJson('/api/orders', [
            'Authorization' => "Bearer $token"
        ]);
        $list->assertStatus(200)
            ->assertJsonCount(Order::count());
    }

    /** @test */
    public function unauthorized_user_cannot_access_orders()
    {
        $this->getJson('/api/orders')->assertStatus(401);
        $this->postJson('/api/orders',['items'=>[]])->assertStatus(401);
    }
}
