<?php

namespace App\Transformers;

use App\Models\User;
use App\Models\UserRoles;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public $type = 'user';
    
    protected $availableIncludes = ['user_role'];

    public function transform(User $model)
    {
        return [
            "id"            => $model->uuid,
            "username"      => $model->username,
            "first_name"    => $model->first_name,
            "last_name"     => $model->last_name,
            "phone_number"  => $model->phone_number,
            "email"         => $model->email
        ];
    }

    public function includeUserRole(User $user)
    {
        $userRoles = UserRoles::where("user_id", $user->id)->first();

        if (!empty($userRoles)) {
            return $this->item($userRoles, new UserRolesTransformer(), 'user_role');
        }
    }
}