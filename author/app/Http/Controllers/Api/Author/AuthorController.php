<?php

namespace App\Http\Controllers\Api\Author;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Author\Author;
use App\Models\User;
use App\Transformers\Author\AuthorTransformer;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::get();

        $result = $this->collection($authors, new AuthorTransformer());

        return $this->showResultV2('Data Found', $result);
    }

    public function show($uuid)
    {
        $author = Author::where("uuid", $uuid)->first();

        if (! $author) {
            return $this->errorResponse("Author tidak ditemukan", 400);
        }

        $result = $this->item($author, new AuthorTransformer());

        return $this->showResultV2('Data Found', $result);
    }

    public function create(Request $request)
    {
        try {
            DB::beginTransaction();

            $validation = validator($request->all(), [
                "name" => 'required',
                "gender" => 'required',
                "country" => 'required',
            ]);

            if ($validation->fails()) {
                return $this->errorResponse($validation->errors(), 422);
            }

            $input = $request->only("name", "gender", "country");
            
            $author = Author::create([
                "name"      => $input["name"],
                "gender"    => $input["gender"],
                "country"   => $input["country"]
            ]);
            DB::commit();

            $result = $this->item($author, new AuthorTransformer());

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
            $author = Author::where("uuid", $uuid)->first();

            if (!$author) {
                return $this->errorResponse("Author tidak ditemukan.", 400);
            }

            $validation = validator($request->all(), [
                "name" => 'required',
                "gender" => 'required',
                "country" => 'required',
            ]);

            if ($validation->fails()) {
                return $this->errorResponse($validation->errors(), 422);
            }

            $input = $request->only("name", "gender", "country");
            
            $author->name       = $input["name"];
            $author->gender     = $input["gender"];
            $author->country    = $input["country"];
            $author->save();

            DB::commit();

            $result = $this->item($author, new AuthorTransformer());

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
            $author = Author::where("uuid", $uuid)->first();

            if (!$author) {
                return $this->errorResponse("Author tidak ditemukan.", 400);
            }

            $author->delete();
            DB::commit();

            return $this->showResult('Data deleted', []);

        } catch (Exception $e) {
            DB::rollBack();
            return $this->realErrorResponse($e);
        }
    }

    public function getDataId($uuid) 
    {
        $author = Author::where("uuid", $uuid)->first();

        if (! $author) {
            return $this->errorResponse("Author tidak ditemukan", 400);
        }

        return $author->id;
    }
}