<?php

namespace CodeProject\Http\Controllers;
use Illuminate\Http\Request;
use CodeProject\Http\Controllers\Controller;
use CodeProject\Repositories\ProjectRepository;
use CodeProject\Services\ProjectService;
use CodeProject\Traits\crudControllerTrait;

class ProjectFileController extends Controller
{
    private $repository;
    private $service;
    
    public function __construct(ProjectRepository $repository, ProjectService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }
    
    public function store(Request $request)
    {

        $file = $request->file('file');
        
        if(isset($file)){
            $extension = $file->getClientOriginalExtension();
        
            $data['file'] = $file;
            $data['extension'] = $extension;
            $data['name'] = $request->name;
            $data['project_id'] = $request->project_id;
            $data['description'] = $request->description;
            
            return $this->service->createFile($data);
            
        }else{
            return [
                'error' => true,
                'message' => 'arquivo inválido.'
            ];
        }
    }
    
    public function destroy($idProject, $idFile)
    {
        return $this->service->destroyImage($idProject, $idFile);
    }
        
}
