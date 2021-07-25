<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\CustomMessagesException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Roles;
use App\Models\User;
use App\Services\MailService;
use App\Transformers\UserTransformer;
use Exception;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

    public function register(Request $request) 
    {    
        DB::beginTransaction();

        try {
            $input = $request->only("first_name", "last_name", "username", "phone_number", "email", "password", "confirmation_password", 'role_id');
            $validator = validator($request->all(), 
                [ 
                    'first_name'            => 'required',
                    'last_name'             => 'required',
                    'phone_number'          => 'required',
                    'email'                 => 'required|email|unique:users,email',
                    'username'              => 'required|unique:users,username',
                    'password'              => 'required|min:5',  
                    'confirmation_password' => 'required|same:password', 
                    'role_id'               => 'required'
                ],
                [
                    "first_name.required"               => "nama depan harus diisi.",
                    "last_name.required"                => "nama belakang harus diisi.",
                    "phone_number.required"             => "nomor telp harus diisi.",
                    "phone_number.unique"               => "nomor telp sudah digunakan, silahkan gunakan nomor telp yang lain.",
                    "email.required"                    => "email harus diisi.",
                    "email.unique"                      => "email sudah digunakan, silahkan gunakan email yang lain.",
                    "username.required"                 => "username harus diisi.",
                    "username.unique"                   => "username sudah digunakan, silahkan gunakan username yang lain.",
                    "password.required"                 => "password harus diisi.",  
                    "password.min"                      => "password harus berisikan minimal 5 karakter.",
                    "confirmation_password.required"    => "konfirmasi password harus diisi.",  
                    "confirmation_password.same"        => "konfirmasi password tidak sesuai."
                ]
            ); 
    
            if ($validator->fails()) {
                return $this->errorResponse($validator->errors());
            }    

            $check = User::whereEmail($input['email'])->exists();

            if ($check) {
                throw new CustomMessagesException("Duplicate Entry Exception", 403);
            }

            $input['password'] = Hash::make($input['password']);
            $input['email']     = trim(strtolower($input['email']));
            $user = User::create($input);

            foreach ($input['role_id'] as $uuidRole) {
                $getRole = Roles::where("uuid", $uuidRole)->first();
    
                if (!$getRole) {
                    return $this->errorResponse('Role not found', 409);
                }
                $user->userRoles()->create([
                    "user_id"   => $user->id,
                    "role_id"   => $getRole->id
                ]);
            }
            
            DB::commit();

            return $this->showResult('data created', ['data' => $user]);

        } catch(Exception $e) {
            DB::rollBack();
            return $this->realErrorResponse($e);
        }
        
    }


    public function login(Request $request)
    {
        $input = $request->only('username', 'password');

        $validate = validator($request->all(), 
            [
                'username' => 'required|string',
                'password' => 'required|string',
            ],
            [
                'username.required' => 'username harus di isi.',
                'username.string' =>   'username harus bertype string.',
                'password.required' => 'password harus di isi.',
                'password.string' =>   'password harus bertype string.',
            ]
        );
        
        if ($validate->fails()) {  

            return $this->errorResponse($validate->errors(), 403);                      
        }

        $input = $request->only("username", "password");

        $loginType = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $input['username'] = str_replace(' ', '', trim(strtolower($input['username'])));
        

        $user = User::where($loginType, trim(strtolower($input['username'])))->first();

        if (!empty($user)) {
            if ($user->validateForPassportPasswordGrant($input['password'])) {
                if (! empty($user->tokens)) {
                    foreach ($user->tokens as $token) {
                        $token->revoked = true;
                        $token->save();
                    }
                }

                // if (is_null($user->email_verified_at)) {
                //     return $this->errorResponse('you must verified your email first.', 409);
                // }

                $success['token']       = $user->createToken('patungan')->accessToken;
                return $this->showResult('Data Found', [ 'data' => $success ]);
            
            } else {
                return $this->errorResponse('Wrong password', 401);
            }
        } else {
            return $this->errorResponse('User not found', 401);
        }
    }


    public function logout()
    {
        if (Auth::check()) {
            Auth::user()->token()->revoke();

            return $this->showResult('Logout success', [ 'data' => [] ]);
        } else {
            return $this->errorResponse('Unauthorised', 401);
        }
    }

    public function getUserLoggedIn()
    {
        $user = Auth::user();

        if (! $user) {
            return $this->errorResponse("User tidak ditemukan", 403);
        }

        $result = $this->item($user, new UserTransformer(), 'user_role');

        return $this->showResultV2("data found", $result);
    }
} 

