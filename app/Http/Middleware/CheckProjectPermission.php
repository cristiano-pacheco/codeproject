<?php

namespace CodeProject\Http\Middleware;

use Closure;
use CodeProject\Services\ProjectService;

class CheckProjectPermission
{
    private $repository;
    
    public function __construct(ProjectService $service)
    {
        $this->service = $service;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $id = $request->route('id');
        $projectId = isset($id) ? $request->route('id') : $request->route('project');
        
        if($projectId){

            if($this->service->checkProjectPermissions($projectId) == false){
               return ['success'=>"You haven't permission to access project."];
            }
        }
        
        return $next($request);
    }
}
