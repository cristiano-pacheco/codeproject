<?php

namespace CodeProject\Traits;

use Illuminate\Http\Request;

trait crudControllerTrait
{
    public function index()
    {
        return $this->repository->all();
    }
    
    public function store(Request $request)
    {
        return $this->service->create($request->all());
    }
    
    public function show($id)
    {
        return $this->service->show($id);
    }
    
    public function update(Request $request, $id)
    {
        return $this->service->update($request->all(),$id);
    }
    
    public function destroy($id)
    {
        return $this->service->delete($id);
    }
}