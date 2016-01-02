<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Http\Controllers\Controller;
use CodeProject\Repositories\ProjectTaskRepository;
use CodeProject\Services\ProjectTaskService;
use CodeProject\Traits\crudControllerTrait;
use Illuminate\Support\Facades\Response;

class ProjectTaskController extends Controller
{
    /**
     * @var ProjectTaskRepository
     */
    private $repository;

    /**
     * @var ProjectTaskService
     */
    private $service;

    /**
     * ProjectTaskController constructor.
     *
     * @param ProjectTaskRepository $repository
     * @param ProjectTaskService $service
     */
    public function __construct(ProjectTaskRepository $repository, ProjectTaskService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    /**
     * Display a listing of the resource
     *
     * @param $id
     * @return Response
     */
    public function index($id)
    {
        return $this->repository->findWhere(['project_id'=>$id]);
    }

    /**
     * Store na newly created resource in storage
     *
     * @param Request $request
     * $param int $id
     * @return Response
     */
    public function store(Request $request, $id)
    {
        $data = $request->all();
        $data['project_id'] = $id;
        return $this->service->create($data);
    }

    /**
     * Display the specified resource
     *
     * @param int $id
     * @param int $idTask
     * @return Response
     */
    public function show($id, $idTask)
    {
        return $this->service->show($id,$idTask);
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
