<?php

namespace App\Services;

use App\Traits\ApiResponser;
use App\Traits\ConsumeExternalService;

/**
 * 
 * 
 */
class AuthorService
{
    use ApiResponser;
    use ConsumeExternalService;

    public $baseUri;
    public $secret;

    public function __construct()
    {
        $this->baseUri = config('services.author.base_uri');
        $this->secret = config('services.author.secret');
    }

    public function obtainAuthors()
    {
        return $this->performRequest('GET', '/api/author/populate');
    }

    public function findAuthorByUuid($uuid)
    {
        return $this->performRequest('GET', '/api/author/show/'. $uuid);
    }

    public function findAuthorId($uuid)
    {
        return $this->performRequest('GET', '/api/author/getId/'. $uuid);
    }

    public function createAuthor($data)
    {
        return $this->performRequest('POST', '/api/author/create', $data);
    }

    public function updateAuthorByUuid($uuid, $data)
    {
        return $this->performRequest('POST', '/api/author/edit/'. $uuid, $data);
    }

    public function deleteAuthorByUuid($uuid)
    {
        return $this->performRequest('DELETE', '/api/author/delete/'. $uuid);
    }
}