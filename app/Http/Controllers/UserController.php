<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Http\Requests;
use CodeProject\Http\Controllers\Controller;
use LucaDegasperi\OAuth2Server\Facades\Authorizer;
use CodeProject\Entities\User;

class UserController extends Controller
{
    private $model;
    
    public function __construct(User $model)
    {
        $this->model = $model;
    }
    
    public function authenticated()
    {
        $idUser = Authorizer::getResourceOwnerId();
        return $this->model->find($idUser);
    }
}
