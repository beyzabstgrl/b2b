<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Resources\OrderResource;
use App\Service\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends BaseController

{
    protected $service;



    public function __construct(OrderService $service)
    {
        $this->service = $service;

    }
    public function index(): JsonResponse
    {
        $user = Auth::user();

        $orders = $user->role === 'admin'

            ? $this->service->all(['items.product', 'user'])

            : $this->service->findBy('user_id', $user->id);


        return response()->json(OrderResource::collection($orders));
    }


    public function store(StoreOrderRequest $request): JsonResponse
    {
        $order = $this->service->storeOrder(Auth::id(), $request->items);

        return response()->json(new OrderResource($order), 201);
    }


    public function show($id): JsonResponse
    {
        $order = $this->service->find($id, ['items.product', 'user']);

        if (! $order) {
            return response()->json(['message' => 'Sipariş bulunamadı'], 404);
        }

        $user = Auth::user();
        if ($user->role !== 'admin' && $order->user_id !== $user->id) {
            return response()->json(['message' => 'Yetkiniz yok'], 403);
        }

        return response()->json(new OrderResource($order));
    }
}
