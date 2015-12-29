<?php
namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Repositories\ProjectFileRepository;
use CodeProject\Validators\ProjectFileValidator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as Storage;
use Prettus\Validator\Exceptions\ValidatorException;
use Prettus\Validator\Contracts\ValidatorInterface;

class ProjectFileService
{

    protected $repository;
    protected $projectRepository;
    protected $validator;
    protected $filesystem;
    protected $storage;
    
    public function __construct(ProjectFileRepository $repository, 
                                ProjectRepository $projectRepository, 
                                ProjectFileValidator $validator, 
                                Filesystem $filesystem, 
                                Storage $storage)
    {
        $this->repository        = $repository;
        $this->projectRepository = $projectRepository;
        $this->validator         = $validator;
        $this->filesystem        = $filesystem;
        $this->storage           = $storage;
    }
    
    public function createFile(array $data)
    {
        try {
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_CREATE);
  
            $project = $this->projectRepository->skipPresenter()->find($data['project_id']); 
            $projectFile = $project->files()->create($data);
            
            $this->storage->put($projectFile->getFileName(), $this->filesystem->get($data['file']));
            
            return $projectFile;
            
        }catch (ValidatorException $e){
    
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }
        
    }
    
    public function update(array $data, $id)
    {
        try {
            $this->validator->with($data)->passesOrFail(ValidatorInterface::RULE_UPDATE);
            
            return $this->repository->update($data,$id);
            
        }catch (ValidatorException $e){
    
            return [
                'error' => true,
                'message' => $e->getMessageBag()
            ];
        }
    }
    
    public function getFilePath($id)
    {
        $projectFile = $this->repository->skipPresenter()->find($id);
        return $this->getBaseUrl($projectFile);
    }
    
    public function getFileName($id)
    {
        $projectFile = $this->repository->skipPresenter()->find($id);
        return $projectFile->getFileName();
    }
    
    private function getBaseUrl($projectFile)
    {
        switch($this->storage->getDefaultDriver()){
            case 'local':
                return $this->storage->getDriver()->getAdapter()->getPathPrefix().'/'.$projectFile->getFileName();
        }
    }
    
    public function checkProjectOwner($projectFileId)
    {
        try{
            
            $userId =  \Authorizer::getResourceOwnerId();
            $projectId = $this->repository->skipPresenter()->find($projectFileId)->project_id;
            return $this->projectRepository->isOwner($projectId,$userId);
            
        }catch(\Exception $e){
            
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
            
        }
        
    }
    
    public function checkProjectMember($projectFileId)
    {
        try{
            $userId =  \Authorizer::getResourceOwnerId();
            $projectId = $this->repository->skipPresenter()->find($projectFileId)->project_id;
            return $this->projectRepository->hasMember($projectId,$userId);
        }catch(\Exception $e){
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
        
    }
    
    public function checkProjectPermissions($projectFileId)
    {
        try{
            if($this->checkProjectOwner($projectFileId) or $this->checkProjectMember($projectFileId)){
                return true;
            }
        }catch(\Exception $e){
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
        
        return false;
    }
    
    public function destroyImage($id)
    {
        try{
            $projectFile = $this->repository->skipPresenter()->find($id);
            
            if($projectFile){
 
                if($this->storage->exists($projectFile->getFileName())){
                    $this->storage->delete($projectFile->getFileName());
                    $projectFile->delete();
                }
            }
            
            return [
                'error' => false,
                'message' => 'Arquivo deletado com sucesso.'
            ];
    
        }catch (\Exception $e){
    
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }
}