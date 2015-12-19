<?php
namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;
use CodeProject\Traits\crudServiceTrait;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Contracts\Filesystem\Factory as Storage;

class ProjectService
{
    use crudServiceTrait;
    /**
     * 
     * @var ClientRepository
     */
    protected $repository;
    
    /**
     * 
     * @var ClientValidator
     */
    protected $validator;
    
    protected $filesystem;
    
    protected $storage;
    
    public function __construct(ProjectRepository $repository, ProjectValidator $validator, Filesystem $filesystem, Storage $storage)
    {
        $this->repository  = $repository;
        $this->validator   = $validator;
        $this->filesystem  = $filesystem;
        $this->storage     = $storage;
    }
    
    public function addMember($idProject, $idUser)
    {
        try {
            $this->repository->find($idProject)->members()->attach($idUser);
            return [
                'error' => false,
                'message' => 'Membro adicionado com sucesso.'
            ];
    
        } catch (\Exception $e){
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }
    
    public function removeMember($idProject, $idUser)
    {
        try {
            $this->repository->find($idProject)->members()->detach($idUser);
             
            return [
                'error' => false,
                'message' => 'Membro removido com sucesso.'
            ];
    
        } catch (\Exception $e){
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }
    
    public function isMember($id,$idUser)
    {
        $members =  $this->repository->find($id)->members;
        foreach($members as $member){
            if($member->id == $idUser){
                return true;
            }
        }
        return false;
    }
    
    public function getMembers($id)
    {
        return $this->repository->find($id)->members;
    }
    
    public function createFile(array $data)
    {
        $project = $this->repository->skipPresenter()->find($data['project_id']);
        $projectFile = $project->files()->create($data);
        
        $this->storage->put($projectFile->id.'.'.$data['extension'], $this->filesystem->get($data['file']));
    }
    
    public function destroyImage($idProject, $idFile)
    {
        try{
    
            $project = $this->repository->skipPresenter()->find($idProject);
            $img = $project->files()->find($idFile);
    
            if(file_exists(storage_path().'/app/'.$img->id.'.'.$img->extension)){
                $this->storage->delete($img->id.'.'.$img->extension);
            }
    
            $img->delete();
    
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