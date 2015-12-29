<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;
use CodeProject\Entities\ProjectFiles;

/**
 * Class ProjectFileTransformer
 * @package namespace CodeProject\Transformers;
 */
class ProjectFileTransformer extends TransformerAbstract
{

    /**
     * Transform the \ProjectFile entity
     * @param \ProjectFile $model
     *
     * @return array
     */
    public function transform(ProjectFiles $model)
    {
        return [
            'id'         => (int) $model->id,
            'project_id' => (int) $model->project_id,
            'name'       => $model->name,
            'extension'  => $model->extension,
            'description'=> $model->description
       ];
    }
}
