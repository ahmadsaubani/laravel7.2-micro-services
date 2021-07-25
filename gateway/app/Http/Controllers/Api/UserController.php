<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Roles;
use App\Models\User;
use App\Models\UserRoles;
use App\Services\FileUploadService;
use App\Services\MailService;
use App\Transformers\UserTransformer;

class UserController extends Controller
{
    public function populate()
    {
        $user = Auth::user();

        if (! isAdmin($user)) {
            return $this->errorResponse('You dont have permission.', 404);
        }

        $users  = User::orderBy("email")->get();
        
        $result = $this->collection($users, new UserTransformer(), 'user_role.roles');

        return $this->showResultV2('Data Found', $result);
    }
}