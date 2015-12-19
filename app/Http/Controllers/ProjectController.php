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
    
    public function __construct(ProjectRepository $repository, ProjectService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }
    
    public function index()
    {
        return $this->repository->findWhere(['owner_id'=>\Authorizer::getResourceOwnerId()]);
    }
    
    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }
    
    public function show($id)
    {
        if($this->checkProjectPermissions($id)== false){
            return ['error'=>'Access forbidden'];
        }
        return $this->service->show($id);
    }
    
    public function update(Request $request, $id)
    {
        if($this->checkProjectPermissions($id)== false){
            return ['error'=>'Access forbidden'];
        }
        return $this->service->update($request->all(),$id);
    }
    
    public function destroy($id)
    {
        if($this->checkProjectPermissions($id)== false){
            return ['error'=>'Access forbidden'];
        }
        
        return $this->service->delete($id);
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
    
    private function checkProjectOwner($projectId)
    {
        $userId =  \Authorizer::getResourceOwnerId();
        return $this->repository->isOwner($projectId,$userId);
    }
    
    private function checkProjectMember($projectId)
    {
        $userId =  \Authorizer::getResourceOwnerId();
        return $this->repository->hasMember($projectId,$userId);
    }
    
    private function checkProjectPermissions($projectId)
    {
        if($this->checkProjectOwner($projectId) || $this->checkProjectMember($projectId)){
            return true;
        }
        return false;
    }
}
