<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    //
    public function index(){
        return view('layouts.customer.account',[
            'title' => "Account"
        ]);
    }

}
