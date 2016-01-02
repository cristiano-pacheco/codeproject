<?php

namespace CodeProject\Transformers;

use CodeProject\Entities\ProjectMember;
use League\Fractal\TransformerAbstract;

/**
 * Class ProjectMemberTransformer
 * @package namespace CodeProject\Transformers;
 */
class ProjectMemberTransformer extends TransformerAbstract
{
    protected $defaultIncludes = ['user'];

    /**
     * Transform the \User entity
     * @param \User $model
     *
     * @return array
     */
    public function transform(ProjectMember $model)
    {
        return [
            'id' => $model->id,
            'member_id' => $model->member_id,
            'project_id' => $model->project_id
        ];
    }

    public function includeUser(ProjectMember $member)
    {
        return $this->item($member->member, new MemberTransformer());
    }
}
