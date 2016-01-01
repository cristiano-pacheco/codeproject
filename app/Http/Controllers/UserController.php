<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Repositories\UserRepository;
use CodeProject\Http\Requests;
use CodeProject\Http\Controllers\Controller;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;

class UserController extends Controller
{
    private $repository;
    
    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }
    
    public function authenticated()
    {
        $idUser = Authorizer::getResourceOwnerId();
        return $this->repository->find($idUser);
    }

    public function index()
    {
        return $this->repository->all();
    }
}