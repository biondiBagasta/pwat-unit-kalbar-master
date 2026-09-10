<?php

namespace App\Http\Controllers\backoffice;

use App\Http\Controllers\Controller;
use App\Models\Members;
use App\Models\PostCategories;
use App\Models\Posts;
use App\Models\Provinces;
use App\Models\SuggestionCategories;
use App\Models\Suggestions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberProfileController extends Controller
{
    public function overviewPage($id) {
        $data = Members::with("member_type", "member_role", "regency.province")->find($id);

        $post_count = Posts::where("posted_by", "=", $id)->count();
        $suggestion_count = Suggestions::where("member_id", "=", $id)->count();

        $provinces = Provinces::all();

        return view("backoffice.member_profile.tab_routes.overview.index", [
            "data" => $data,
            "member_id" => $id,
            "post_count" => $post_count,
            "suggestion_count" => $suggestion_count,
            "provinces" => $provinces
        ]);
    }

    public function postPage($id, Request $request) {
        $pageTake = 20;

        $currentPage = (int) ($request->query("page") ?? 1);

        $count = Posts::where("posted_by", "=", $id)->count();

        $totalPage = ceil(($count / $pageTake) + 0.4);

        // Jika Merupakan Akun yang Authenticated
        if(Auth::user()->member->id == $id) {
            $data = Posts::with("post_category", "member")->where("posted_by", "=", $id)
            ->take($pageTake)
            ->skip(($currentPage - 1) * $pageTake)->get();
        } else { // Jika Tidak
            $data = Posts::with("post_category", "member")->where(function ($q) use($id) {
                $q->where("posted_by", "=")->whereHas("post_status", function ($p0) {
                    $p0->where("code", "=", "PUB");
                });
            })
            ->take($pageTake)
            ->skip(($currentPage - 1) * $pageTake)->get();
        }

        $post_categories_data = PostCategories::orderBy("name", "asc")->get();

        return view("backoffice.member_profile.tab_routes.post.index", [
            "data" => $data,
            "member_id" => $id,
            "current_page" => $currentPage,
            "count" => $count,
            "total_page" => $totalPage,
            "post_categories_data" => $post_categories_data
        ]);
    }

    public function suggestionPage($id, Request $request) {
        $pageTake = 20;

        $currentPage = (int) ($request->query("page") ?? 1);

        $count = Suggestions::where("member_id", "=", $id)->count();

        $totalPage = ceil(($count / $pageTake) + 0.4);

        $data = Suggestions::with("suggestion_category", "member")->where("member_id", "=", $id)
        ->take($pageTake)
        ->skip(($currentPage - 1) * $pageTake)->get();

        $suggestion_categories_data = SuggestionCategories::orderBy("name", "asc")->get();

        return view("backoffice.member_profile.tab_routes.suggestion.index", [
            "data" => $data,
            "member_id" => $id,
            "current_page" => $currentPage,
            "count" => $count,
            "total_page" => $totalPage,
            "suggestion_categories_data" => $suggestion_categories_data
        ]);
    }
}
