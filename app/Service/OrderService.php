<?php
namespace App\Service;


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
        // 1) Sipariş kaydı
        $order = $this->repository->store([
            'user_id'     => $userId,
            'status'      => 'pending',
            'total_price' => 0,
        ]);

        $total = 0;
        foreach ($items as $item) {

            $product = Product::findOrFail($item['product_id']);
            $qty     = $item['quantity'];

            if ($product->stock_quantity < $qty) {
                throw new \Exception("“{$product->name}” için yeterli stok yok.");
            }

            $unitPrice = $product->price;

            $order->items()->attach($product->id, [
                'quantity'   => $qty,
                'unit_price' => $unitPrice,
            ]);

            $product->decrement('stock_quantity', $qty);

            $total += $unitPrice * $qty;
        }

        $this->repository->update($order->id, ['total_price' => $total]);

        return $this->repository->find($order->id, ['items.product', 'user']);
    }

}
