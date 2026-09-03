<?php

namespace App\Http\Controllers\backoffice;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRoleRequest;
use App\Models\MemberRoles;

class MemberRoleController extends Controller
{

    public function create(MemberRoleRequest $request) {
        try {
            $model = new MemberRoles;

            $model->code = $request["code"];
            $model->name = $request["name"];

            $model->save();

            session()->flash("create", "Data Member Role {$request['name']} Berhasil Ditambahkan.");

            return ApiResponse::successResponse("");

        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Membuat Data Member Role : {$e->getMessage()}");
        }
    }

    public function edit($id) {
        $data = MemberRoles::find($id);

        return response()->json($data);
    }

    public function update(MemberRoleRequest $request, $id) {
        try {
            $model = MemberRoles::find($id);

            $model->code = $request["code"];
            $model->name = $request["name"];

            $model->save();

            session()->flash("update", "Data Member Role {$request['name']} Berhasil Diupdate.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Mengupdate Data Member Role : {$e->getMessage()}");
        }
    }

    public function delete($id) {
        try {
            $model = MemberRoles::find($id);

            $model->delete();

            session()->flash("delete", "Data Member Role {$model->name} Berhasil Dihapus.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Menghapus Data Member Role : {$e->getMessage()}");
        }
    }
}
