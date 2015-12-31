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
    
    public function checkProjectOwner($projectId)
    {
        $userId =  \Authorizer::getResourceOwnerId();
        return $this->repository->isOwner($projectId,$userId);
    }
    
    private function checkProjectMember($projectId)
    {
        $userId =  \Authorizer::getResourceOwnerId();
        return $this->repository->hasMember($projectId,$userId);
    }
    
    public function checkProjectPermissions($projectId)
    {
        if($this->checkProjectOwner($projectId) || $this->checkProjectMember($projectId)){
            return true;
        }
        return false;
    }
}