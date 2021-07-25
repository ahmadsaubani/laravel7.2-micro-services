<?php

namespace App\Transformers;

use App\Models\Roles;
use League\Fractal\TransformerAbstract;

class RoleTransformer extends TransformerAbstract
{
    public $type = 'roles';
    
    protected $availableIncludes = [];

    public function transform(Roles $model)
    {
        return [
            "id"            => $model->id,
            "uuid"          => $model->uuid,
            "title"         => $model->title,
        ];
    }
}