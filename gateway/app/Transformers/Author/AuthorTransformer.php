<?php

namespace App\Transformers\Author;

use App\Models\Author\Author;
use League\Fractal\TransformerAbstract;

class AuthorTransformer extends TransformerAbstract
{
    public $type = 'author';
    
    protected $availableIncludes = [];

    public function transform(Author $model)
    {
        return [
            "id"                => $model->uuid,
            "name"              => $model->name,
            "gender"            => $model->gender,
            "country"           => $model->country,
        ];
    }
}