<?php

namespace CodeProject\Transformers;

use League\Fractal\TransformerAbstract;
use CodeProject\Entities\Client;

/**
 * Class ClientTransformer
 * @package namespace CodeProject\Transformers;
 */
class ClientTransformer extends TransformerAbstract
{

    /**
     * Transform the \Client entity
     * @param \Client $model
     *
     * @return array
     */
    public function transform(Client $model)
    {
        return [
            'id'         => (int) $model->id,
            'name'       => $model->name,
            'responsible'=> $model->responsible,
            'email'      => $model->email,
            'phone'      => $model->phone,
            'address'    => $model->address,
            'obs'        => $model->obs,
            'created_at' => $model->created_at,
            'updated_at' => $model->updated_at,
        ];
    }
}
