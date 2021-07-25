<?php

namespace App\Services;

use App\Traits\ConsumeExternalService;

/**
 * 
 * 
 */
class BookService
{
    use ConsumeExternalService;

    public $baseUri;
    public $secret;

    public function __construct()
    {
        $this->baseUri = config('services.book.base_uri');
        $this->secret = config('services.book.secret');
    }

    public function obtainBook()
    {
        return $this->performRequest('GET', '/api/book/populate');
    }

    public function findBookByUuid($uuid)
    {
        return $this->performRequest('GET', '/api/book/show/'. $uuid);
    }

    public function createBook($data)
    {
        return $this->performRequest('POST', '/api/book/create', $data);
    }

    public function updateBookByUuid($uuid, $data)
    {
        return $this->performRequest('POST', '/api/book/edit/'. $uuid, $data);
    }

    public function deleteBookByUuid($uuid)
    {
        return $this->performRequest('DELETE', '/api/book/delete/'. $uuid);
    }
}