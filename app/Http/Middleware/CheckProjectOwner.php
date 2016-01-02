<?php

namespace CodeProject\Http\Middleware;

use Closure;
use CodeProject\Services\ProjectService;

class CheckProjectOwner
{
    /**
     * 
     * @var ProjectService
     */
    private $service;
    
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
        
        if($this->service->checkProjectOwner($projectId) == false){
            return ['error'=>'Access forbidden'];
        }
        return $next($request);
    }
}
