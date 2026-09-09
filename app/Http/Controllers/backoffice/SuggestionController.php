<?php

namespace App\Http\Controllers\backoffice;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\SuggestionRequest;
use App\Models\SuggestionCategories;
use App\Models\Suggestions;
use Illuminate\Http\Request;

class SuggestionController extends Controller
{
    public function index(Request $request) {

        $pageTake = 20;

        $term = $request->query("term") ?? "";

        $currentPage = (int) ($request->query("page") ?? 1);

        $count = Suggestions::where(
        function ($q) use($term) {
            $q->whereHas("member", function ($p0) use($term) {
                $p0->where("full_name", "like", "%{$term}%");
            })->orWhereHas("suggestion_category", function ($p1) use($term) {
                $p1->where("name", "like", "%{$term}%");
            });
        })->count();

        $totalPage = ceil(($count / $pageTake) + 0.4);

        $data = Suggestions::with("member", "suggestion_category")->where(
        function ($q) use($term) {
            $q->whereHas("member", function ($p0) use($term) {
                $p0->where("full_name", "like", "%{$term}%");
            })->orWhereHas("suggestion_category", function ($p1) use($term) {
                $p1->where("name", "like", "%{$term}%");
            });
        })->take($pageTake)
        ->skip(($currentPage - 1) * $pageTake)->get();

        // Bagian Suggestion Category
        $suggestion_categories_data = SuggestionCategories::orderBy("name", "asc")->get();

        return view("backoffice.suggestion.index",
        [
            "data" => $data,
            "suggestion_categories_data" => $suggestion_categories_data,
            "current_page" => $currentPage,
            "count" => $count,
            "total_page" => $totalPage,
            "term" => $term
        ]);
    }

    public function create(SuggestionRequest $request) {
        try {
            $model = new Suggestions;

            $model->title = $request["title"];
            $model->content = $request["content"];
            $model->suggestion_category_id = $request["suggestion_category_id"];

            if($request["cover_image"]) {
                $filename = time().'_'.$request["cover_image"]->getClientOriginalName();
                $request["cover_image"]->storeAs("posts", $filename, 'public');
                $model->cover_image = $filename;
            }


            $model->save();

            session()->flash("create", "Saran Anda Berhasil Diajukan.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Mengajukan Saran : {$e->getMessage()}");
        }
    }

    public function edit($id) {
        $data = Suggestions::with("member")->find($id);

        return response()->json($data);
    }

    public function update(SuggestionRequest $request, $id) {

        try {
            $model = Suggestions::find($id);

            $model->title = $request["title"];
            $model->content = $request["content"];
            $model->suggestion_category_id = $request["suggestion_category_id"];

            if($request["cover_image"]) {
                $filename = time().'_'.$request["cover_image"]->getClientOriginalName();
                $request["cover_image"]->storeAs("posts", $filename, 'public');
                $model->cover_image = $filename;
            }

            $model->save();

            session()->flash("update", "Data Saran Anda Berhasil Diupdate.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Mengupdate Data Saran : {$e->getMessage()}");
        }
    }

    public function delete($id) {
        try {
            $model = Suggestions::find($id);

            $model->delete();

            session()->flash("delete", "Data Saran Anda Berhasil Dihapus.");

            return ApiResponse::successResponse("");
        } catch(\Throwable $e) {
            return ApiResponse::errorResponse("Gagal Menghapus Data Saran : {$e->getMessage()}");
        }
    }
}
