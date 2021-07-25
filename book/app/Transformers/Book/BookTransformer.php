<?php

namespace App\Transformers\Book;

use App\Models\Book\Book;
use League\Fractal\TransformerAbstract;

class BookTransformer extends TransformerAbstract
{
    public $type = 'book';
    
    protected $availableIncludes = [];

    public function transform(Book $model)
    {
        return [
            "id"                        => $model->uuid,
            "title"                     => $model->title,
            "description"               => $model->description,
            "author_id"                 => $model->author_id,
            "price"                     => $model->price,
        ];
    }
}