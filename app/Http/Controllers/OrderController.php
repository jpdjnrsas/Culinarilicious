<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


class OrderController extends Controller
{
    public function foods()
    {
        $foods = Food::where('stock', '>', 0)->get();
        return view('foods.index', compact('foods'));
    }

    public function addToCart($id)
    {
        $food = Food::findOrFail($id);

        $cart = session()->get('cart', []);

        if(isset($cart[$id])) {
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $food->name,
                "price" => $food->price,
                "quantity" => 1
            ];
        }

        session()->put('cart', $cart);

        return redirect('/cart');
    }

    public function cancel($id)
{
    $order = Order::findOrFail($id);

    // 🚫 BLOCK CANCEL AFTER DELIVERY
    if ($order->status == 'delivered') {
        return back()->with('error', 'Cannot cancel delivered order.');
    }

    // 🚫 BLOCK CANCEL IF ON DELIVERY
    if ($order->status == 'on delivery') {
        return back()->with('error', 'Order is already on delivery.');
    }

    $order->status = 'cancelled';
    $order->save();

    return back()->with('success', 'Order cancelled.');
}

    public function cart()
    {
        $cart = session()->get('cart', []);
        return view('cart.index', compact('cart'));
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);

        if(empty($cart)) return back();

        $order = Order::create([
            'user_id' => Auth::id(),
            'status' => 'pending'
        ]);

        foreach ($cart as $id => $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'food_id' => $id,
                'price' => $item['price'],
                'quantity' => $item['quantity']
            ]);
        }

        session()->forget('cart');

        return redirect('/orders');
    }

    public function myOrders()
    {
        $orders = Order::with('items.food')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.food'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    public function storeReview(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|max:500',
        ]);

        $order = \App\Models\Order::findOrFail($request->order_id);

        // ❌ Only delivered orders can be reviewed
        if ($order->status !== 'delivered') {
            return back()->with('error', 'Only delivered orders can be reviewed.');
        }

        // ❌ Prevent duplicate review
        $alreadyReviewed = \App\Models\Review::where('order_id', $order->id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($alreadyReviewed) {
            return back()->with('error', 'You already reviewed this order.');
        }

        // ✅ Save review (ORDER-BASED)
        \App\Models\Review::create([
            'user_id' => auth()->id(),
            'order_id' => $order->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Review submitted successfully.');
    }

    public function receipt($id)
    {
        $order = Order::with('items.food', 'user')->findOrFail($id);

        // Optional security (recommended)
        if (auth()->id() !== $order->user_id && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $pdf = Pdf::loadView('orders.receipt', compact('order'));

        return $pdf->download('receipt_order_'.$order->id.'.pdf');
    }
}