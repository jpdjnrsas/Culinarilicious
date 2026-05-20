<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class RiderController extends Controller
{
    public function orders()
    {
        $orders = Order::with(['user', 'items.food'])
            ->where('rider_id', Auth::id())
            ->latest()
            ->get();

        return view('rider.orders', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with(['items.food', 'user'])
            ->where('rider_id', auth()->id())
            ->findOrFail($id);

        return view('rider.order_show', compact('order'));
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        // 🚫 Prevent editing if already delivered
        if ($order->status === 'delivered') {
            return back()->with('error', 'Order already delivered.');
        }

        // ✅ VALIDATION (SMART FIX)
        $request->validate([
            'status' => 'required',
            'eta' => 'nullable|string|max:50',
            'proof_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // ❗ ONLY REQUIRE IMAGE IF:
        // - status is delivered
        // - AND no existing proof image yet
        if ($request->status === 'delivered' && !$order->proof_image && !$request->hasFile('proof_image')) {
            return back()->with('error', 'Proof image is required when marking as delivered.');
        }

        // 📸 HANDLE IMAGE UPLOAD (ONLY IF NEW IMAGE PROVIDED)
        if ($request->hasFile('proof_image')) {
            $path = $request->file('proof_image')->store('proofs', 'public');
            $order->proof_image = $path;
        }

        // ✅ UPDATE STATUS + ETA
        $order->status = $request->status;
        $order->eta = $request->eta;

        $order->save();

        return back()->with('success', 'Order updated successfully.');
    }
}