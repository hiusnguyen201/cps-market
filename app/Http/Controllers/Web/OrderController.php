<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function home (Request $request){
        $orders = Order::where(function ($query) use ($request) {
            $query->orWhere('code', 'like', '%' . $request->code . '%');
        });
        
        $orders = $orders->paginate($request->limit ?? 10);

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