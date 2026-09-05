<?php

namespace App\Http\Controllers\backoffice;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\UserRoles;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request) {

        $pageTake = 20;

        $term = $request->query("term") ?? "";

        $currentPage = (int) ($request->query("page") ?? 1);

        $count = User::where([
            ["username", "like", "%" . $term . "%"],
        ])->count();

        $totalPage =  round(($count / $pageTake) + 0.4);

        $data = User::with("user_role")->where([
            ["username", "like", "%" . $term . "%"],
        ])->get();

        // Bagian Data User Roles
        $user_roles_data = UserRoles::orderBy("name", "asc")->get();

        return view("backoffice.user.index",
        [
            "data" => $data,
            "user_roles_data" => $user_roles_data,
            "current_page" => $currentPage,
            "count" => $count,
            "total_page" => $totalPage,
            "term" => $term
        ]);
    }

    public function create(UserRequest $request) {
        try {
            $model = new User;

            $model->username = $request["username"];
            $model->password = Hash::make($request["password"]);
            $model->user_role_id = $request["user_role_id"];

            $model->save();

            session()->flash("create", "Data User dengan Username {$request['username']} Berhasil Ditambahkan.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Membuat Data User : {$e->getMessage()}");
        }
    }

    public function edit($id) {
        $data = User::find($id);

        return response()->json($data);
    }

    public function update(UserRequest $request, $id) {

        try {
            $model = User::find($id);

            $model->username = $request["username"];

            if($request["password"]) {
                $model->password = Hash::make($request["password"]);
            } else {
                $model->password = $model->password;
            }

            $model->user_role_id = $request["user_role_id"];

            $model->save();

            session()->flash("update", "Data User dengan Username {$request['username']} Berhasil Diupdate.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Mengupdate Data User : {$e->getMessage()}");
        }
    }

    public function delete($id) {
        try {
            $model = User::find($id);

            if($model->member()->exists()) {

                return ApiResponse::errorResponse("Data User ini Sudah Memiliki Data Member, Sehingga tidak bisa Dihapus.");
            } else {
                $model->delete();

                session()->flash("delete", "Data User dengan Username {$model->username} Berhasil Dihapus.");

                return ApiResponse::successResponse("");
            }
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Menghapus Data User : {$e->getMessage()}");
        }
    }
}
