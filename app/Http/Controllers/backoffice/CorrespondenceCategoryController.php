<?php

namespace App\Http\Controllers\backoffice;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\CorrespondenceCategoryRequest;
use App\Models\CorrespondenceCategories;
use Illuminate\Http\Request;

class CorrespondenceCategoryController extends Controller
{
    public function create(CorrespondenceCategoryRequest $request) {
        try {
            $model = new CorrespondenceCategories;

            $model->code = $request["code"];
            $model->name = $request["name"];

            $model->save();

            session()->flash("create", "Data Kategori Surat {$request['name']} Berhasil Ditambahkan.");

            return ApiResponse::successResponse("");

        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Membuat Data Kategori Surat : {$e->getMessage()}");
        }
    }

    public function edit($id) {
        $data = CorrespondenceCategories::find($id);

        return response()->json($data);
    }

    public function update(CorrespondenceCategoryRequest $request, $id) {
        try {
            $model = CorrespondenceCategories::find($id);

            $model->code = $request["code"];
            $model->name = $request["name"];

            $model->save();

            session()->flash("update", "Data Kategori Surat {$request['name']} Berhasil Diupdate.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Mengupdate Kategori Surat : {$e->getMessage()}");
        }
    }

    public function delete($id) {
        try {
            $model = CorrespondenceCategories::find($id);

            $model->delete();

            session()->flash("delete", "Data Kategori Surat {$model->name} Berhasil Dihapus.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Menghapus Data Event Category : {$e->getMessage()}");
        }
    }
}
