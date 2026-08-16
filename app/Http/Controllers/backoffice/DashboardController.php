<?php

namespace App\Http\Controllers\backoffice;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index() {
        return view('backoffice.dashboard.index');
    }
}
