<?php
namespace App\Service;


use App\Repository\UserRepository;


class UserService extends BaseService
{

    protected $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }



}
