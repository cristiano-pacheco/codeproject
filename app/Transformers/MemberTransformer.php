<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;
use CodeProject\Entities\User;

/**
 * Class ProjectMemberTransformer
 * @package namespace CodeProject\Transformers;
 */
class MemberTransformer extends TransformerAbstract
{

    /**
     * Transform the \User entity
     * @param \User $model
     *
     * @return array
     */
    public function transform(User $model)
    {
        return [
            'member_id' => (int) $model->id,
            'name' => $model->name,
        ];
    }
}
