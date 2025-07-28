<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Service\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;



class ProductController extends BaseController
{
    protected $service;



    public function __construct(ProductService $service)
    {
        $this->service = $service;

    }

    public function index(): JsonResponse
    {

        $products = Cache::store('redis')
            ->remember('products', 3600, fn() => $this->service->all());

        return response()->json($products);
    }

  //admin için
    public function store(StoreProductRequest $request): JsonResponse
    {
        return response()->json(
            $this->service->store($request->validated()),
            201
        );
    }


    public function update(UpdateProductRequest $request, $id): JsonResponse
    {
        return response()->json(
            $this->service->update($id, $request->validated())
        );
    }


}
