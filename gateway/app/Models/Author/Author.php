<?php

namespace App\Models\Author;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CreateUuid;

class Author extends Model
{
    use CreateUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'gender',
        'country'
    ];
}
