<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class BuyerOrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->get();
        return view('orders.index', compact('orders'));
    }

    public function rate(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $order->rating = $request->rating;
        $order->review = $request->review;

        $order->save();

        return back();
    }
}