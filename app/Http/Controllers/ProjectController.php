<?php

namespace CodeProject\Http\Controllers;

use CodeProject\Http\Controllers\Controller;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use CodeProject\Traits\crudControllerTrait;

class ProjectController extends Controller
{
    private $repository;
    private $service;
    
    use crudControllerTrait;
    
    public function __construct(ProjectRepository $repository, ProjectService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }
    
    public function addMember($id, $idMember)
    {
       return $this->service->addMember($id,$idMember);
    }
    
    public function removeMember($id, $idMember)
    {
        return $this->service->removeMember($id,$idMember);
    }
    
    public function members($id)
    {
        return $this->service->getMembers($id);
    }
    
    public function isMember($id, $idMember)
    {
        return $this->service->isMember($id,$idMember);
    }
}
