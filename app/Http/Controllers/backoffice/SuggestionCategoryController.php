<?php

namespace App\Http\Controllers\backoffice;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\SuggestionCategoryRequest;
use App\Models\SuggestionCategories;

class SuggestionCategoryController extends Controller
{
    public function create(SuggestionCategoryRequest $request) {
        try {
            $model = new SuggestionCategories;

            $model->code = $request["code"];
            $model->name = $request["name"];

            $model->save();

            session()->flash("create", "Data Kategori Saran {$request['name']} Berhasil Ditambahkan.");

            return ApiResponse::successResponse("");

        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Membuat Data Kategori Saran : {$e->getMessage()}");
        }
    }

    public function edit($id) {
        $data = SuggestionCategories::find($id);

        return response()->json($data);
    }

    public function update(SuggestionCategoryRequest $request, $id) {
        try {
            $model = SuggestionCategories::find($id);

            $model->code = $request["code"];
            $model->name = $request["name"];

            $model->save();

            session()->flash("update", "Data Kategori Saran {$request['name']} Berhasil Diupdate.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Mengupdate Data Kategori Saran : {$e->getMessage()}");
        }
    }

    public function delete($id) {
        try {
            $model = SuggestionCategories::find($id);

            $model->delete();

            session()->flash("delete", "Data Kategori Saran {$model->name} Berhasil Dihapus.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Menghapus Data Kategori Saran : {$e->getMessage()}");
        }
    }
}
