<?php

namespace CodeProject\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeProject\Repositories\ProjectFilesRepository;
use CodeProject\Entities\ProjectFiles;

/**
 * Class ProjectFilesRepositoryEloquent
 * @package namespace CodeProject\Repositories;
 */
class ProjectFilesRepositoryEloquent extends BaseRepository implements ProjectFilesRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ProjectFiles::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
