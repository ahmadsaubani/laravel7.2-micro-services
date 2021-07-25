<?php

use App\Models\Auth\User;
use App\Models\Roles;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;


if (!function_exists('isAdmin')) {
    /**
     * @param User $user
     * @return Boolean
     */
    function isAdmin($user)
    {
        if (!$user) {
            return false;
        }

        $roles = $user->userRoles()->pluck("role_id")->toArray();

        $getAdminRole = Roles::where("title", "admin")->first();
        if (! in_array($getAdminRole->id, $roles)) {
            return false;
        }

        return true;
    }
}
