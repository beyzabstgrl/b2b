<?php
namespace App\Service;


use App\Repository\ProductRepository;
use App\Repository\UserRepository;


class ProductService extends BaseService
{

    protected $repository;

    public function __construct(ProductRepository $repository)
    {
        $this->repository = $repository;
    }



}
