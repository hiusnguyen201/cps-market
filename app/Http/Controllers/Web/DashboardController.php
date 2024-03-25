<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function home()
    {
        return view("admin.dashboard.home", [
            'breadcumbs' => ['titles' => ['Dashboard']],
            'title' => 'Dashboard'
        ]);
    }
}
