<?php
namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectTaskValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use CodeProject\Repositories\ProjectTaskRepository;


class ProjectTaskService
{
    /**
     * 
     * @var ProjectTaskRepository
     */
    protected $repository;
    
    /**
     * 
     * @var ProjectTaskValidator
     */
    protected $validator;

    /**
     * @var ProjectRepository
     */
    protected $projectRepository;


    
    public function __construct(ProjectTaskRepository $repository, ProjectTaskValidator $validator, ProjectRepository $projectRepository)
    {
        $this->repository = $repository;
        $this->validator = $validator;
        $this->projectRepository = $projectRepository;

    }
    
    public function create(array $data)
    {
        try {
            $this->validator->with($data)->passesOrFail();

            $projectTask = $this->repository->create($data);
            return $projectTask;

        }catch (ValidatorException $e)
        {
            return [
                'error'=>true, 
                'message'=>$e->getMessageBag()
            ];
        }
        
    }
    
    public function update(array $data, $id)
    {
        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->update($data,$id);
        }catch (ValidatorException $e)
        {
            return [
                'error'=>true,
                'message'=>$e->getMessageBag()
            ];
        }
        
    }
    
    public function show($id,$taskId)
    {
        try {
            return $this->repository->find($taskId);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => 'Registro não encontrado.'
            ];
        }    
    }
    
    public function delete($taskId)
    {
        try {
            $projectTask = $this->repository->skipPresenter()->find($taskId);
            if($projectTask->delete()){
                return [
                    'error' => false,
                    'message' => 'Registro deletado com sucesso.'
                ];
            }
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => 'Não foi possivel deletar o registro.'
            ];
        }
    }
}