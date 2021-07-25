<?php

namespace App\Transformers;

use App\Models\Roles;
use App\Models\UserRoles;
use League\Fractal\TransformerAbstract;

class UserRolesTransformer extends TransformerAbstract
{
    public $type = 'user_role';
    
    protected $availableIncludes = ['roles'];

    public function transform(UserRoles $model)
    {
        return [
            "id"            => $model->id,
            "uuid"          => $model->uuid,
        ];
    }

    public function includeRoles(UserRoles $model)
    {
        $role = Roles::where("id", $model->role_id)->first();

        if (!empty($role)) {
            return $this->item($role, new RoleTransformer(), 'roles');
        }
    }
}