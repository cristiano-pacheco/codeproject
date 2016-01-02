<?php

namespace CodeProject\Http\Controllers;

use Illuminate\Http\Request;
use CodeProject\Http\Controllers\Controller;
use CodeProject\Repositories\ProjectMemberRepository;
use CodeProject\Services\ProjectMemberService;
use Illuminate\Support\Facades\Response;

class ProjectMemberController extends Controller
{
    /**
     * @var ProjectMemberRepository
     */
    private $repository;

    /**
     * @var ProjectMemberService
     */
    private $service;

    /**
     * ProjectMemberController constructor.
     *
     * @param ProjectMemberRepository $repository
     * @param ProjectMemberService $service
     */
    public function __construct(ProjectMemberRepository $repository, ProjectMemberService $service)
    {
        $this->repository = $repository;
        $this->service = $service;

        $this->middleware('check.project.owner',['except'=> ['show','index']]);
        $this->middleware('check.project.permission',['except'=> ['store','destroy']]);
    }

    /**
     * Display a listing of the resource
     *
     * @param $id
     * @return Response
     */
    public function index($id)
    {
        return $this->repository->findWhere(['project_id'=>$id]);
    }

    /**
     * Store na newly created resource in storage
     *
     * @param Request $request
     * $param int $id
     * @return Response
     */
    public function store(Request $request, $id)
    {
        $data = $request->all();
        $data['project_id'] = $id;
        return $this->service->create($data);
    }

    /**
     * Display the specified resource
     *
     * @param int $id
     * @param int $idTask
     * @return Response
     */
    public function show($id, $idProjectMember)
    {
        return $this->service->show($idProjectMember);
    }

    /**
     * Remove the specified resource from sotrage.
     * @param int $id
     * @param int $idProjectMember
     * @return array
     */
    public function destroy($id, $idProjectMember)
    {
        return $this->service->delete($idProjectMember);
    }
}
