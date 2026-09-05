<?php

namespace App\Http\Controllers\backoffice;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\EventCategoryRequest;
use App\Models\EventCategories;

class EventCategoryController extends Controller
{
    public function create(EventCategoryRequest $request) {
        try {
            $model = new EventCategories;

            $model->code = $request["code"];
            $model->name = $request["name"];

            $model->save();

            session()->flash("create", "Data Event Category {$request['name']} Berhasil Ditambahkan.");

            return ApiResponse::successResponse("");

        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Membuat Data Event Category : {$e->getMessage()}");
        }
    }

    public function edit($id) {
        $data = EventCategories::find($id);

        return response()->json($data);
    }

    public function update(EventCategoryRequest $request, $id) {
        try {
            $model = EventCategories::find($id);

            $model->code = $request["code"];
            $model->name = $request["name"];

            $model->save();

            session()->flash("update", "Data Event Category {$request['name']} Berhasil Diupdate.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Mengupdate Event Category : {$e->getMessage()}");
        }
    }

    public function delete($id) {
        try {
            $model = EventCategories::find($id);

            $model->delete();

            session()->flash("delete", "Data Event Category {$model->name} Berhasil Dihapus.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Menghapus Data Event Category : {$e->getMessage()}");
        }
    }
}
