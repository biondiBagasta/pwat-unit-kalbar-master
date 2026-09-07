<?php

namespace App\Http\Controllers\backoffice;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\FinanceCategoryRequest;
use App\Models\FinanceCategories;

class FinanceCategoryController extends Controller
{
    public function create(FinanceCategoryRequest $request) {
        try {
            $model = new FinanceCategories;

            $model->code = $request["code"];
            $model->name = $request["name"];
            $model->type = $request["type"];

            $model->save();

            session()->flash("create", "Data Finance Category {$request['name']} Berhasil Ditambahkan.");

            return ApiResponse::successResponse("");

        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Membuat Data Finance Category : {$e->getMessage()}");
        }
    }

    public function edit($id) {
        $data = FinanceCategories::find($id);

        return response()->json($data);
    }

    public function update(FinanceCategoryRequest $request, $id) {
        try {
            $model = FinanceCategories::find($id);

            $model->code = $request["code"];
            $model->name = $request["name"];
            $model->type = $request["type"];

            $model->save();

            session()->flash("update", "Data Finance Category {$request['name']} Berhasil Diupdate.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Mengupdate Finance Category : {$e->getMessage()}");
        }
    }

    public function delete($id) {
        try {
            $model = FinanceCategories::find($id);

            $model->delete();

            session()->flash("delete", "Data Finance Category {$model->name} Berhasil Dihapus.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Menghapus Data Finance Category : {$e->getMessage()}");
        }
    }
}
