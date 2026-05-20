<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Food;
use App\Models\Review;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    /* ---------------- ORDERS ---------------- */
    public function orders()
    {
        $today = now()->toDateString();

        // 🟡 PENDING (not finished)
        $pendingOrders = \App\Models\Order::whereDate('created_at', $today)
            ->whereNotIn('status', ['delivered', 'cancelled'])
            ->latest()
            ->get();

        // 🟢 FINISHED TODAY
        $finishedOrders = \App\Models\Order::whereDate('created_at', $today)
            ->whereIn('status', ['delivered', 'cancelled'])
            ->latest()
            ->get();

        return view('admin.orders', compact('pendingOrders', 'finishedOrders'));
    }

    public function showOrder($id)
    {
        $order = Order::with(['user', 'items.food', 'rider'])->findOrFail($id);
        $riders = \App\Models\User::where('role', 'rider')->get();

        return view('admin.order_show', compact('order', 'riders'));
    }

    public function assignRider(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // 🚫 BLOCK if already assigned or in progress
        if ($order->rider_id !== null) {
            return back()->with('error', 'This order is already assigned to a rider.');
        }

        if (in_array($order->status, ['on delivery', 'delivered'])) {
            return back()->with('error', 'Cannot reassign an order that is already in progress or completed.');
        }

        // ✅ Assign rider
        $order->rider_id = $request->rider_id;
        $order->status = 'assigned';
        $order->save();

        return back()->with('success', 'Rider assigned successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $order->update([
            'status' => $request->status,
            'eta' => $request->eta
        ]);

        return back()->with('success', 'Order updated');
    }

    /* ---------------- FOODS ---------------- */
    public function foods()
    {
        $foods = Food::latest()->paginate(8);

        return view('admin.foods', compact('foods'));
    }

    public function makeUnavailable($id)
    {
        $food = Food::findOrFail($id);

        // Force stock to zero
        $food->stock = 0;
        $food->save();

        return back()->with('success', 'Food marked as unavailable.');
    }

    public function storeFood(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $imagePath = null;

        // SAVE IMAGE
        if ($request->hasFile('image')) {

            $imagePath = $request->file('image')->store('foods', 'public');

        }

        // CREATE FOOD
        \App\Models\Food::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
        ]);

        return redirect('/admin/foods')
            ->with('success', 'Food added successfully!');
    }
    public function updateFood(Request $request, $id)
    {
        $food = Food::findOrFail($id);

        $food->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return back();
    }

    /* ---------------- REVIEWS ---------------- */
    public function reviews()
    {
        $reviews = Review::with('user', 'food')->latest()->get();
        return view('admin.reviews', compact('reviews'));
    }

    /* ---------------- SALES ---------------- */
    public function sales()
    {
        // 📅 TODAY ONLY
        $today = Carbon::today();

        // ✅ Get today's delivered orders
        $orders = Order::where('status', 'delivered')
            ->whereDate('created_at', $today)
            ->get();

        // 💰 Total Sales
        $totalSales = $orders->sum('total_price');

        // 📦 Total Orders
        $totalOrders = $orders->count();

        // 📊 Average Order Value
        $averageOrder = $totalOrders > 0 
            ? $totalSales / $totalOrders 
            : 0;

        return view('admin.sales', compact(
            'orders',
            'totalSales',
            'totalOrders',
            'averageOrder'
        ));
    }
    public function deleteFoods()
    {
        $foods = Food::latest()->paginate(12);

        return view('admin.delete-foods', compact('foods'));
    }
}