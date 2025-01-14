<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function allOrder(){
        $orders = Order::all();
        return view('backend.order.all_order',compact('orders'));
    }

    public function orderDetails(string $id){

        $orders = Order::with('product')->findOrFail($id);
        // dd($orders);
        return view('backend.order.order_details',compact('orders'));
    }
}
