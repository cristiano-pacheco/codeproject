<?php
namespace CodeProject\Traits;
use Prettus\Validator\Exceptions\ValidatorException;

trait crudServiceTrait
{
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
    
    public function show($id)
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
                'message' => 'Não foi possivel deletar o registro, Existe depenência a este registro ou ele não existe.'
            ];
        }
    }
}