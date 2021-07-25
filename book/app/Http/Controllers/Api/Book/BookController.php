<?php

namespace App\Http\Controllers\Api\Book;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Book\Book;
use App\Transformers\Book\BookTransformer;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::get();

        $result = $this->collection($books, new BookTransformer());

        return $this->showResultV2('Data Found', $result);
    }

    public function show($uuid)
    {
        $book = Book::where("uuid", $uuid)->first();

        if (! $book) {
            return $this->errorResponse("Buku tidak ditemukan", 400);
        }

        $result = $this->item($book, new BookTransformer());

        return $this->showResultV2('Data Found', $result);
    }

    public function create(Request $request)
    {
        try {
            DB::beginTransaction();

            $validation = validator($request->all(), [
                "title"         => 'required',
                "description"   => 'required',
                "price"         => 'required',
                "author_id"     => 'required',
            ]);

            if ($validation->fails()) {
                return $this->errorResponse($validation->errors(), 422);
            }

            $input = $request->only("title", "description", "price", "author_id");
            
            $book = Book::create([
                "title"         => $input["title"],
                "description"   => $input["description"],
                "price"         => $input["price"],
                "author_id"     => $input["author_id"],
            ]);
            DB::commit();

            $result = $this->item($book, new BookTransformer());

            return $this->showResultV2('Data Found', $result);

        } catch (Exception $e) {
            DB::rollBack();
            return $this->realErrorResponse($e);
        }
    }

    public function edit(Request $request, $uuid)
    {
        try {
            DB::beginTransaction();
            $book = Book::where("uuid", $uuid)->first();

            if (!$book) {
                return $this->errorResponse("Buku tidak ditemukan.", 400);
            }

            $validation = validator($request->all(), [
                "title"         => 'required',
                "description"   => 'required',
                "price"         => 'required',
                "author_id"     => 'required',
            ]);

            if ($validation->fails()) {
                return $this->errorResponse($validation->errors(), 422);
            }

            $input = $request->only("title", "description", "price", "author_id");
            
            $book->title                = $input["title"];
            $book->description          = $input["description"];
            $book->price                = $input["price"];
            $book->author_id            = $input["author_id"];
            $book->save();

            DB::commit();

            $result = $this->item($book, new BookTransformer());

            return $this->showResultV2('Data Found', $result);

        } catch (Exception $e) {
            DB::rollBack();
            return $this->realErrorResponse($e);
        }
    }

    public function delete($uuid)
    {
        try {
            DB::beginTransaction();
            $book = Book::where("uuid", $uuid)->first();

            if (!$book) {
                return $this->errorResponse("Buku tidak ditemukan.", 400);
            }

            $book->delete();
            DB::commit();

            return $this->showResult('Data deleted', []);

        } catch (Exception $e) {
            DB::rollBack();
            return $this->realErrorResponse($e);
        }
    }
}