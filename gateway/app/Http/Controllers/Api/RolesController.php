<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Roles;
use App\Models\User;
use App\Transformers\RoleTransformer;
use Illuminate\Support\Facades\Auth;

class RolesController extends Controller
{
    public function populate()
    {
        $roles = Roles::where("isHidden", false)->get();

        $result = $this->collection($roles, new RoleTransformer());

        return $this->showResultV2('Data Found', $result);
    }

    public function adminPopulate()
    {
        $user = Auth::user();

        if (! isModerator($user)) {
            return $this->errorResponse('you dont have permission.', 403);
        }
        
        $roles = Roles::get();

        $result = $this->collection($roles, new RoleTransformer());

        return $this->showResultV2('Data Found', $result);
    }
}