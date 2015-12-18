<?php
namespace CodeProject\Services;

use CodeProject\Validators\ProjectTaskValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use CodeProject\Repositories\ProjectTaskRepository;


class ProjectTaskService
{
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
    
    public function __construct(ProjectTaskRepository $repository, ProjectTaskValidator $validator)
    {
        $this->repository = $repository;
        $this->validator = $validator;
    }
    
    public function create(array $data)
    {
        try {
            $this->validator->with($data)->passesOrFail();
            return $this->repository->create($data);
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
    
    public function show($id,$noteId)
    {
        try {
            return $this->repository->findWhere(['project_id'=>$id,'id'=>$noteId]);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => 'Registro não encontrado.'
            ];
        }    
    }
    
    public function delete($noteId)
    {
        try {
            if($this->repository->find($noteId)->delete()){
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
