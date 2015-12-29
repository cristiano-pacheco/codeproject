<?php
namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Http\Controllers\Controller;
use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Services\ProjectFileService;

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
    
    public function show($id)
    {
        if($this->service->checkProjectPermissions($id)==false){
            return ['error'=>'Access Forbidden'];
        }
        return $this->repository->find($id);
    }
    
    public function showFile($id)
    {
        if($this->service->checkProjectPermissions($id)==false){
            return ['error'=>'Access Forbidden'];
        }
        
        $filePath = $this->service->getFilePath($id);
        $fileContent = file_get_contents($filePath);
        $file64 = base64_encode($fileContent);
        return [
            'file' => $file64,
            'size' => filesize($filePath),
            'name' => $this->service->getFileName($id)
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

    public function update(Request $request, $id)
    {
        if($this->service->checkProjectOwner($id)==false){
            return ['error'=>'Access Forbidden'];
        }
        return $this->service->update($request->all(),$id);
    }
    
    public function destroy($id)
    {
        if($this->service->checkProjectOwner($id)==false){
            return ['error'=>'Access Forbidden'];
        }
        
        $this->service->destroyImage($id);
    }       
}