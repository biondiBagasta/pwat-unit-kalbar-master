<?php

namespace App\Http\Controllers\backoffice;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRequest;
use App\Models\MemberRoles;
use App\Models\Members;
use App\Models\MemberTypes;
use App\Models\Provinces;
use App\Models\Regencies;
use App\Models\User;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index(Request $request) {
        // Bagian Select
        $member_types_data = MemberTypes::orderBy("name", "asc")->get();
        $member_roles_data = MemberRoles::orderBy("name", "asc")->get();
        $provinces = Provinces::all();

        // Bagian Query Main Data
        $pageTake = 20;

        $currentPage = (int) ($request->query("page") ?? 1);

        $term = $request->query("term") ?? "";

        $count = Members::where(
        function ($q) use($term) {
            $q->where("full_name", "like", "%{$term}%")
            ->orWhere("husband_name", "like", "%{$term}%")
            ->orWhere("husband_occupation", "like", "%{$term}%")
            ->orWhereHas("member_role", function ($q2) use($term) {
                $q2->where("name", "like", "%{$term}%");
            })->orWhereHas("member_type", function ($q2) use($term) {
                $q2->where("name", "like", "%{$term}%");
            });
        })->count();

        $totalPage = ceil(($count / $pageTake) + 0.4);

        $data = Members::with("member_role", "member_type", "user", "regency.province")->where(
        function ($q) use($term) {
            $q->where("full_name", "like", "%{$term}%")
            ->orWhere("husband_name", "like", "%{$term}%")
            ->orWhereHas("member_role", function ($q2) use($term) {
                $q2->where("name", "like", "%{$term}%");
            })->orWhereHas("member_type", function ($q2) use($term) {
                $q2->where("name", "like", "%{$term}%");
            });
        })->get();



        return view("backoffice.member.index", [
            "member_types_data" => $member_types_data,
            "member_roles_data" => $member_roles_data,
            "provinces" => $provinces,
            "data" => $data,
            "current_page" => $currentPage,
            "count" => $count,
            "total_page" => $totalPage,
            "term" => $term
        ]);
    }

    public function create(MemberRequest $request) {
        try {
            $model = new Members;
            $userData = User::where("username", "=", $request["username"])->first();

            $model->full_name = $request["full_name"];
            $model->address = $request["address"];
            $model->phone_number = $request["phone_number"];
            $model->job = $request["job"];
            $model->husband_name = $request["husband_name"];
            $model->husband_occupation = $request["husband_occupation"];
            $model->regency_id = $request["regency_id"];
            $model->user_id = $userData->id;

            $model->member_role_id = $request["member_role_id"];
            $model->member_type_id = $request["member_type_id"];

            if($request["photo"]) {
                $filename = time().'_'.$request["photo"]->getClientOriginalName();
                $request["photo"]->storeAs("members", $filename, 'public');
                $model->photo = $filename;
            }

            $model->save();

            session()->flash("create", "Data Member {$request['full_name']} Berhasil Ditambahkan.");

            return ApiResponse::successResponse("");

        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Membuat Data Member : {$e->getMessage()}");
        }
    }

    public function edit($id) {
        $data = Members::with("member_role", "member_type", "user", "regency.province")->find($id);

        return response()->json($data);
    }

    public function update(MemberRequest $request, $id) {
        try {
            $model = Members::find($id);

            $userData = User::where("username", "=", $request["username"])->first();

            $model->full_name = $request["full_name"];
            $model->address = $request["address"];
            $model->phone_number = $request["phone_number"];
            $model->job = $request["job"];
            $model->husband_name = $request["husband_name"];
            $model->husband_occupation = $request["husband_occupation"];
            $model->regency_id = $request["regency_id"];
            $model->user_id = $userData->id;

            $model->member_role_id = $request["member_role_id"];
            $model->member_type_id = $request["member_type_id"];

            if($request["photo"]) {
                $filename = time().'_'.$request["photo"]->getClientOriginalName();
                $request["photo"]->storeAs("members", $filename, 'public');
                $model->photo = $filename;
            }

            $model->save();


            session()->flash("update", "Data Member {$request['name']} Berhasil Diupdate.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Mengupdate Data Member : {$e->getMessage()}");
        }
    }

    public function delete($id) {
        try {
            $model = Members::find($id);

            if($model->photo != null) {
                $path = "app/public/members/". $model->photo;

                if(file_exists(storage_path($path))) {
                    unlink(storage_path($path));
                }
            }

            $model->delete();

            session()->flash("delete", "Data Member {$model->name} Berhasil Dihapus.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Menghapus Data Member : {$e->getMessage()}");
        }
    }

    public function checkUsername(Request $request) {
        $username = $request["username"];

        $dataUser = User::where("username", "=", $username)->first();

        if($dataUser == null) {
            return ApiResponse::errorResponse("Username belum terdaftar, silahkan buat user dengan username '{$username}' pada menu User.");
        } else {
            $countData = Members::where("user_id", "=", $dataUser->id)->count();

            if($countData == 0) {
                return ApiResponse::successResponse("Username tersedia.");
            } else {
                return ApiResponse::errorResponse("Username sudah digunakan!!!");
            }
        }
    }

    public function findManyRegency(Request $request) {
        $province_id = $request["province_id"];

        $data = Regencies::where("province_id", "=", $province_id)->get();

        return response()->json($data);
    }
}
