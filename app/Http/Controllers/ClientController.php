<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Http\Controllers\Controller;
use CodeProject\Repositories\ClientRepository;
use CodeProject\Services\ClientService;
use CodeProject\Traits\crudControllerTrait;

class ClientController extends Controller
{
    private $repository;
    private $service;
    
    use crudControllerTrait;
    
    public function __construct(ClientRepository $repository, ClientService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }
}
