<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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