<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Http\Controllers\Controller;
use CodeProject\Repositories\ProjectNoteRepository;
use CodeProject\Services\ProjectNoteService;

class ProjectNoteController extends Controller
{
    private $repository;
    private $service;
    
    public function __construct(ProjectNoteRepository $repository, ProjectNoteService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }

    public function index($id)
    {
        return $this->repository->findWhere(['project_id'=>$id]);
    }
    
    public function store(Request $request,$id)
    {
        $data = $request->all();
        $data['project_id'] = $id;
        return $this->service->create($data);
    }
    
    public function show($id, $noteId)
    {
        return $this->service->show($id,$noteId);
    }
    
    public function update(Request $request, $id,  $noteId)
    {
        $data = $request->all();
        $data['project_id'] = $id;
        return $this->service->update($data,$noteId);
    }
    
    public function destroy($id, $noteId)
    {
        return $this->service->delete($noteId);
    }
}
