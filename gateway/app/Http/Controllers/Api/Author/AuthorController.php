<?php

namespace App\Http\Controllers\Api\Author;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AuthorService;
use Exception;

class AuthorController extends Controller
{
    public $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    public function index()
    {
        return $this->successResponse($this->authorService->obtainAuthors(), 200);
    }

    public function show($uuid)
    {
        return $this->successResponse($this->authorService->findAuthorByUuid($uuid), 200);
    }

    public function getDataId($uuid)
    {
        return $this->successResponse($this->authorService->findAuthorId($uuid), 200);
    }

    public function create(Request $request)
    {
        try {
            return $this->successResponse($this->authorService->createAuthor($request->all()), 201);

        } catch (Exception $e) {
            return $this->getClientError($e);
        }
    }

    public function edit(Request $request, $uuid)
    {
        try {
            return $this->successResponse($this->authorService->updateAuthorByUuid($uuid, $request->all()), 200);

        } catch (Exception $e) {
            return $this->getClientError($e);
        }
    }

    public function delete($uuid)
    {
        try {
            return $this->successResponse($this->authorService->deleteAuthorByUuid($uuid), 200);

        } catch (Exception $e) {
            return $this->getClientError($e);
        }
    }
}