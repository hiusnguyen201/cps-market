<?php

namespace App\Http\Controllers;


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
