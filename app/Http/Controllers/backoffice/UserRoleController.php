<?php

namespace App\Http\Controllers\backoffice;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRoleRequest;
use App\Models\UserRoles;

class UserRoleController extends Controller
{
    public function create(UserRoleRequest $request) {
        try {
            $model = new UserRoles;

            $model->code = $request["code"];
            $model->name = $request["name"];

            $model->save();

            session()->flash("create", "Data User Role {$request['name']} Berhasil Ditambahkan.");
            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Membuat Data User Role : {$e->getMessage()}");
        }
    }

    public function edit($id) {
        $data = UserRoles::find($id);

        return response()->json($data);
    }

    public function update(UserRoleRequest $request, $id) {
        try {

            $model = UserRoles::find($id);

            $model->code = $request["code"];
            $model->name = $request["name"];

            $model->save();

            session()->flash("update", "Data User Role {$request['name']} Berhasil Diupdate.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Mengupdate Data User Role : {$e->getMessage()}");
        }
    }

    public function delete($id) {

        try {
            $model = UserRoles::find($id);

            $model->delete();

            session()->flash("delete", "Data Member Role {$model->name} Berhasil Dihapus.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Menghapus Data User Role : {$e->getMessage()}");
        }
    }
}
