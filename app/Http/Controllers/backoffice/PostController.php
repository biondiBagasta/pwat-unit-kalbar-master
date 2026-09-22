<?php

namespace App\Http\Controllers\backoffice;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\PostCategories;
use App\Models\Posts;
use App\Models\PostStatuses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function index(Request $request) {

        $pageTake = 20;

        $term = $request->query("term") ?? "";

        $currentPage = (int) ($request->query("page") ?? 1);

        // Jika Bukan Merupakan Member
        if(Auth::user()->user_role->code != 'ME') {
            $count = Posts::where(
            function ($q) use($term) {
                $q->where("title", "like", "%{$term}%")
                ->orWhere("hashtag", "like", "%{$term}%")
                ->orWhereHas("post_category", function ($q2) use($term) {
                    $q2->where("name", "like", "%{$term}%");
                })->orWhereHas("posted_by", function ($q2) use($term) {
                    $q2->where("full_name", "like", "%{$term}%");
                });
            })->count();

            $totalPage = ceil(($count / $pageTake) + 0.4);

            $data = Posts::with("post_category", "member")->where(
            function ($q) use($term) {
                $q->where("title", "like", "%{$term}%")
                ->orWhere("hashtag", "like", "%{$term}%")
                ->orWhereHas("post_category", function ($q2) use($term) {
                    $q2->where("name", "like", "%{$term}%");
                })->orWhereHas("posted_by", function ($q2) use($term) {
                    $q2->where("full_name", "like", "%{$term}%");
                });
            })->take($pageTake)
            ->skip(($currentPage - 1) * $pageTake)->get();

            $post_categories_data = PostCategories::orderBy("name", "asc")->get();
            $post_statuses_data = PostStatuses::where("code", "!=", "WT")->orderBy("code", "asc")->get();


            return view("backoffice.post.index",
            [
                "data" => $data,
                "post_categories_data" => $post_categories_data,
                "current_page" => $currentPage,
                "count" => $count,
                "total_page" => $totalPage,
                "post_statuses_data" => $post_statuses_data,
                "term" => $term
            ]);
        } else {
            $authenticatedMember = Auth::user()->member;

            $count = Posts::
            where("posted_by", "=", $authenticatedMember->id)
            ->where(
            function ($q) use($term) {
                $q->where("title", "like", "%{$term}%")
                ->orWhere("hashtag", "like", "%{$term}%")
                ->orWhereHas("post_category", function ($q2) use($term) {
                    $q2->where("name", "like", "%{$term}%");
                });
            })->count();

            $totalPage = ceil(($count / $pageTake) + 0.4);

            $data = Posts::with("post_category", "member")
            ->where("posted_by", "=", $authenticatedMember->id)
            ->where(
            function ($q) use($term) {
                $q->where("title", "like", "%{$term}%")
                ->orWhere("hashtag", "like", "%{$term}%")
                ->orWhereHas("post_category", function ($q2) use($term) {
                    $q2->where("name", "like", "%{$term}%");
                });
            })->take($pageTake)
            ->skip(($currentPage - 1) * $pageTake)->get();

            $post_categories_data = PostCategories::orderBy("name", "asc")->get();
            $post_statuses_data = PostStatuses::where("code", "!=", "WT")->orderBy("code", "asc")->get();


            return view("backoffice.post.index",
            [
                "data" => $data,
                "post_categories_data" => $post_categories_data,
                "current_page" => $currentPage,
                "count" => $count,
                "total_page" => $totalPage,
                "post_statuses_data" => $post_statuses_data,
                "term" => $term
            ]);
        }
    }

    public function create(PostRequest $request) {
        try {
            $model = new Posts;

            $model->title = $request["title"];
            $model->content = $request["content"];
            $model->hashtag = $request["hashtag"];
            $model->post_category_id = $request["post_category_id"];
            $model->post_status_id = 1;
            $model->posted_by = Auth::user()->member->id;

            if($request["cover_image"]) {
                $filename = time().'_'.$request["cover_image"]->getClientOriginalName();
                $request["cover_image"]->storeAs("posts", $filename, 'public');
                $model->cover_image = $filename;
            }

            $model->save();

            session()->flash("create", "Data Post Berhasil Ditambahkan.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Membuat Data Post : {$e->getMessage()}");
        }
    }

    public function edit($id) {
        $data = Posts::with("post_category", "member", "post_status")->find($id);

        return response()->json($data);
    }

    public function update(PostRequest $request, $id) {

        try {
            $model = Posts::find($id);

            $model->title = $request["title"];
            $model->content = $request["content"];
            $model->hashtag = $request["hashtag"];
            $model->post_category_id = $request["post_category_id"];
            $model->post_status_id = 1;

            if($request["cover_image"]) {
                if($model->cover_image != null) {
                    $path = "app/public/post/". $model->cover_image;

                    if(file_exists(storage_path($path))) {
                        unlink(storage_path($path));
                    }
                }

                $filename = time().'_'.$request["cover_image"]->getClientOriginalName();
                $request["cover_image"]->storeAs("posts", $filename, 'public');
                $model->cover_image = $filename;
            }

            $model->save();

            session()->flash("update", "Data Post Berhasil Diupdate.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Mengupdate Data Post : {$e->getMessage()}");
        }
    }

    public function delete($id) {
        try {
            $model = Posts::find($id);

            if($model->cover_image != null) {
                $path = "app/public/post/". $model->cover_image;

                if(file_exists(storage_path($path))) {
                    unlink(storage_path($path));
                }
            }

            $model->delete();

            session()->flash("delete", "Data Post Berhasil Dihapus.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Menghapus Data Post : {$e->getMessage()}");
        }
    }

    public function updateStatus(Request $request, $id) {

        try {
            $model = Posts::find($id);
            $model->post_status_id = $request["post_status_id"];

            $model->save();

            session()->flash("update", "Status Publish Postingan Berhasil Diupdate.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Mengupdate Status Publish Postingan : {$e->getMessage()}");
        }
    }

    public function countWaiting() {
        if(Auth::user()->user_role->code == "ME") {
            $count = Posts::where(function($q) {
              $q->whereHas("member", function($p) {
                $p->where("user_id", "=", Auth::user()->id);
              })->whereHas("post_status", function($p) {
                $p->where("code", "=", "WT");
              });
            })->count();

            return $count;
        } else {}
        $count = Posts::whereHas("post_status", function($q) {
            $q->where("code", "=", "WT");
        })->count();

        return $count;
    }
}
