<?php
namespace CodeProject\Services;

use CodeProject\Repositories\ClientRepository;
use CodeProject\Validators\ProjectNoteValidator;
use Prettus\Validator\Exceptions\ValidatorException;
use CodeProject\Repositories\ProjectNoteRepository;


class ProjectNoteService
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
    
    public function __construct(ProjectNoteRepository $repository, ProjectNoteValidator $validator)
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
            
            $data = $this->repository->findWhere(['project_id'=>$id,'id'=>$noteId]);
            $result['data'] = '';
            if(isset($data['data'][0]) && count($data['data'][0])){
                $result['data'] = $data['data'][0];
            }
            return $result;
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
            
            if($this->repository->delete($id)){
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
