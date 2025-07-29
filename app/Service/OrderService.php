<?php
namespace App\Service;


use App\Models\Order;
use App\Models\Product;
use App\Repository\OrderRepository;



class OrderService extends BaseService
{

    protected $repository;

    public function __construct(OrderRepository $repository)
    {
        $this->repository = $repository;
    }

    public function storeOrder(int $userId, array $items): Order
    {
        // Sipariş
        $order = $this->repository->store([
            'user_id'     => $userId,
            'status'      => 'pending',
            'total_price' => 0,
        ]);

        $total = 0;
        foreach ($items as $item) {
            $product = \App\Models\Product::findOrFail($item['product_id']);
            $qty     = $item['quantity'];

            if ($product->stock_quantity < $qty) {
                throw new \Exception("“{$product->name}” için yeterli stok yok.");
            }

            $unitPrice = $product->price;

            //OrderItem
            $order->items()->create([
                'product_id' => $product->id,
                'quantity'   => $qty,
                'unit_price' => $unitPrice,
            ]);

            // Stok
            $product->decrement('stock_quantity', $qty);

            $total += $unitPrice * $qty;
        }

        //  Toplamı
        $this->repository->update($order->id, ['total_price' => $total]);


        return $this->repository->find($order->id, [
            'items.product', 'user'
        ]);
    }

}
