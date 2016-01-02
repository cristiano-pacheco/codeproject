<?php
namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Http\Controllers\Controller;
use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Services\ProjectFileService;
use CodeProject\Services\ProjectService;

class ProjectFileController extends Controller
{
    private $repository;
    private $service;
    
    public function __construct(ProjectFileRepository $repository, ProjectFileService $service)
    {
        $this->repository = $repository;
        $this->service = $service;
    }
    
    public function index($id)
    {
        return $this->repository->findWhere(['project_id'=>$id]);
    }
    
    public function show($idProject, $idFile)
    {
        return $this->repository->find($idFile);
    }
    
    public function showFile($idProject, $idFile)
    {

        $filePath = $this->service->getFilePath($idFile);
        $fileContent = file_get_contents($filePath);
        $file64 = base64_encode($fileContent);
        return [
            'file' => $file64,
            'size' => filesize($filePath),
            'name' => $this->service->getFileName($idFile)
        ];
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

    public function update(Request $request, $idProject, $idFile)
    {
        return $this->service->update($request->all(),$idFile);
    }
    
    public function destroy($idProject, $idFile)
    {
        $this->service->destroyImage($idFile);
    }       
}