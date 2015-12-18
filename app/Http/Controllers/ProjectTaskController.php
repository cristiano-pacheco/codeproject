<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Http\Controllers\Controller;
use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Services\ProjectTaskService;
use CodeProject\Traits\crudControllerTrait;

class ProjectTaskController extends Controller
{
    private $repository;
    private $service;
     
    public function __construct(ProjectTaskRepository $repository, ProjectTaskService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }
    
    public function index($id)
    {
        return $this->repository->findWhere(['project_id'=>$id]);
    }
    
    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }
    
    public function show($id, $noteId)
    {
        return $this->service->show($id,$noteId);
    }
    
    public function update(Request $request, $id, $noteId)
    {
        return $this->service->update($request->all(),$noteId);
    }
    
    public function destroy($id, $noteId)
    {
        return $this->service->delete($noteId);
    }
}
