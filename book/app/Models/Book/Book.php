<?php

namespace App\Models\Book;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CreateUuid;

class Book extends Model
{
    use CreateUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'description',
        'price',
        'author_id'
    ];
}
