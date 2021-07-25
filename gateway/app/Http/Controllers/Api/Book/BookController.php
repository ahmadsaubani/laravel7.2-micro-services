<?php

namespace App\Http\Controllers\Api\Book;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\AuthorService;
use App\Services\BookService;
use Exception;

class BookController extends Controller
{

    public $bookService;
    public $authorService;

    public function __construct(BookService $bookService, AuthorService $authorService)
    {
        $this->bookService = $bookService;
        $this->authorService = $authorService;
    }

    public function index()
    {
        return $this->successResponse($this->bookService->obtainBook(), 200);
    }

    public function show($uuid)
    {
        return $this->successResponse($this->bookService->findBookByUuid($uuid), 200);
    }

    public function create(Request $request)
    {
        try {
            $getRealId = $this->authorService->findAuthorId($request->author_id);
            $input = $request->only("title", "description", "price", "author_id");
            $input["author_id"] = $getRealId;

            return $this->successResponse($this->bookService->createBook($input), 201);
            // return $this->bookService->createBook($request->all());

        } catch (Exception $e) {
            return $this->getClientError($e);
        }
    }

    public function edit(Request $request, $uuid)
    {
        try {
            $getRealId = $this->authorService->findAuthorId($request->author_id);
            $input = $request->only("title", "description", "price", "author_id");
            $input["author_id"] = $getRealId;
            return $this->successResponse($this->bookService->updateBookByUuid($uuid, $request->all()), 200);

        } catch (Exception $e) {
            return $this->getClientError($e);
        }
    }

    public function delete($uuid)
    {
        try {
            return $this->successResponse($this->bookService->deleteBookByUuid($uuid), 200);

        } catch (Exception $e) {
            return $this->getClientError($e);
        }
    }
}