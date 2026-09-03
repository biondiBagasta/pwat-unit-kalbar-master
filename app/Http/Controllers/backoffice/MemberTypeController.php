<?php

namespace App\Http\Controllers\backoffice;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRequest;
use App\Http\Requests\MemberTypeRequest;
use App\Models\MemberTypes;

class MemberTypeController extends Controller
{
    public function create(MemberTypeRequest $request) {
        try {
            $model = new MemberTypes;

            $model->code = $request["code"];
            $model->name = $request["name"];

            $model->save();

            session()->flash("create", "Data Member Type {$request['name']} Berhasil Ditambahkan.");

            return ApiResponse::successResponse("");

        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Membuat Data Member Type : {$e->getMessage()}");
        }
    }

    public function edit($id) {
        $data = MemberTypes::find($id);

        return response()->json($data);
    }

    public function update(MemberTypeRequest $request, $id) {
        try {
            $model = MemberTypes::find($id);

            $model->code = $request["code"];
            $model->name = $request["name"];

            $model->save();

            session()->flash("update", "Data Member Type {$request['name']} Berhasil Diupdate.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Mengupdate Data Member Type : {$e->getMessage()}");
        }
    }

    public function delete($id) {
        try {
            $model = MemberTypes::find($id);

            $model->delete();

            session()->flash("delete", "Data Member Type {$model->name} Berhasil Dihapus.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Menghapus Data Member Type : {$e->getMessage()}");
        }
    }
}
