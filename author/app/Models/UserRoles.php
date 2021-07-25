<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CreateUuid;

class UserRoles extends Model
{
    use CreateUuid;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'role_id'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function roles() {
        return $this->belongsTo(Roles::class);
    }
}
