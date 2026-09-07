<?php

namespace App\Http\Controllers\backoffice;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostCategoryRequest;
use App\Models\PostCategories;

class PostCategoryController extends Controller
{
    public function create(PostCategoryRequest $request) {
        try {
            $model = new PostCategories;

            $model->code = $request["code"];
            $model->name = $request["name"];

            $model->save();

            session()->flash("create", "Data Post Category {$request['name']} Berhasil Ditambahkan.");

            return ApiResponse::successResponse("");

        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Membuat Data Post Category : {$e->getMessage()}");
        }
    }

    public function edit($id) {
        $data = PostCategories::find($id);

        return response()->json($data);
    }

    public function update(PostCategoryRequest $request, $id) {
        try {
            $model = PostCategories::find($id);

            $model->code = $request["code"];
            $model->name = $request["name"];

            $model->save();

            session()->flash("update", "Data Post Category {$request['name']} Berhasil Diupdate.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Mengupdate Post Category : {$e->getMessage()}");
        }
    }

    public function delete($id) {
        try {
            $model = PostCategories::find($id);

            $model->delete();

            session()->flash("delete", "Data Post Category {$model->name} Berhasil Dihapus.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Menghapus Data Post Category : {$e->getMessage()}");
        }
    }
}
