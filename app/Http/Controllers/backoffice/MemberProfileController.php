<?php

namespace App\Http\Controllers\backoffice;

use App\Http\Controllers\Controller;
use App\Models\Members;
use Illuminate\Http\Request;

class MemberProfileController extends Controller
{
    public function overview($id) {
        $data = Members::find($id);

        return view("backoffice.member_profile.tab_routes.overview", [
            "data" => $data
        ]);
    }
}
