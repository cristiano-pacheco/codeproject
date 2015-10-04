<?php
namespace CodeProject\Services;

use CodeProject\Repositories\ProjectRepository;
use CodeProject\Validators\ProjectValidator;
use Prettus\Validator\Exceptions\ValidatorException;

class ProjectService
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
    
    public function __construct(ProjectRepository $repository, ProjectValidator $validator)
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
    
    public function showOne($id)
    {
        try {
            return $this->repository->find($id);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => 'Registro não encontrado.'
            ];
        }    
    }
    
    public function delete($id)
    {
        try {
            if($this->repository->find($id)->delete()){
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