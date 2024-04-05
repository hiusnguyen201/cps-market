<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function home (){
        $orders = [];
        return view('admin.orders.home', [
            'limit_page' => config('constants.limit_page'),
            'breadcumbs' => ['titles' => ['Orders']],
            'title' => 'Manage Orders',
            "orders" => $orders
        ]);
    }
    public function details (){
        
    }
    public function create (){
        
    }
    public function handleCreate (){
        
    }
    public function edit (){
        
    }
    public function handleUpdate (){
        
    }
    public function handleDelete (){
        
    }
}