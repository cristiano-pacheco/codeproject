<?php
namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;
use CodeProject\Traits\crudServiceTrait;

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
    
    public function __construct(ProjectRepository $repository, ProjectValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
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
}