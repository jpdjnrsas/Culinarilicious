<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Food;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FoodController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | BUYER VIEW - FOODS
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        if (auth()->user()->role !== 'buyer') {
            abort(403);
        }

        $foods = Food::where('stock', '>', 0)->paginate(12);

        return view('foods.index', compact('foods'));
    }
    /*
    |--------------------------------------------------------------------------
    | ADD TO CART
    |--------------------------------------------------------------------------
    */
    public function addToCart($id)
    {
        if (auth()->user()->role !== 'buyer') {
            abort(403);
        }

        $food = Food::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {

            // prevent exceeding stock
            if ($cart[$id]['quantity'] >= $food->stock) {
                return redirect()->back()->with('error', 'Not enough stock');
            }

            $cart[$id]['quantity']++;

        } else {
            $cart[$id] = [
                "name" => $food->name,
                "price" => $food->price,
                "quantity" => 1
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Added to cart!');
    }

    /*
    |--------------------------------------------------------------------------
    | VIEW CART
    |--------------------------------------------------------------------------
    */
    public function cart()
    {
        if (auth()->user()->role !== 'buyer') {
            abort(403);
        }

        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    /*
    |--------------------------------------------------------------------------
    | REMOVE FROM CART
    |--------------------------------------------------------------------------
    */
    public function removeFromCart($id)
    {
        if (auth()->user()->role !== 'buyer') {
            abort(403);
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Removed from cart');
    }

    /*
    |--------------------------------------------------------------------------
    | CHECKOUT
    |--------------------------------------------------------------------------
    */
    public function checkout()
    {
        if (auth()->user()->role !== 'buyer') {
            abort(403);
        }

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->back()->with('error', 'Cart is empty!');
        }

        DB::beginTransaction();

        try {

            $total = 0;

            // VALIDATE STOCK AGAIN (VERY IMPORTANT)
            foreach ($cart as $id => $item) {
                $food = Food::findOrFail($id);

                if ($food->stock < $item['quantity']) {
                    throw new \Exception("Not enough stock for {$food->name}");
                }

                $total += $item['price'] * $item['quantity'];
            }

            // CREATE ORDER
            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => 'pending',
                'total_price' => $total,
            ]);

            // SAVE ITEMS + DEDUCT STOCK
            foreach ($cart as $id => $item) {

                OrderItem::create([
                    'order_id' => $order->id,
                    'food_id' => $id,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // reduce stock
                $food = Food::find($id);
                $food->stock -= $item['quantity'];
                $food->save();
            }

            session()->forget('cart');

            DB::commit();

            return redirect('/orders')->with('success', 'Order placed successfully!');

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN VIEW - FOODS
    |--------------------------------------------------------------------------
    */
    public function adminIndex()
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $foods = Food::all();
        return view('admin.foods', compact('foods'));
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN ADD FOOD
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'admin') {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        Food::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock ?? 0,
        ]);

        return redirect()->back()->with('success', 'Food added!');
    }

    /*
    |--------------------------------------------------------------------------
    | ADMIN TOGGLE AVAILABILITY
    |--------------------------------------------------------------------------
    */
    public function makeUnavailable($id)
    {
        $food = Food::findOrFail($id);

        $food->stock = 0;
        $food->save();

        return back()->with('success', 'Food marked as out of stock');
    }
    public function edit($id)
    {
        $food = Food::findOrFail($id);
        return view('admin.foods.edit', compact('food'));
    }

    public function update(Request $request, $id)
    {
        $food = Food::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'price' => 'required',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
        ];

        // ✅ ONLY UPDATE IMAGE IF NEW ONE UPLOADED
        if ($request->hasFile('image')) {

            // OPTIONAL: delete old image
            if ($food->image && \Storage::disk('public')->exists($food->image)) {
                \Storage::disk('public')->delete($food->image);
            }

            $data['image'] = $request->file('image')->store('foods', 'public');
        }

        $food->update($data);

        return redirect('/admin/foods')->with('success', 'Food updated successfully');
    }

    public function create()
    {
        return view('admin.create-food');
    }

    public function destroy($id)
    {
        $food = \App\Models\Food::findOrFail($id);

        // Optional: delete image from storage
        if ($food->image) {
            \Storage::disk('public')->delete($food->image);
        }

        $food->delete();

        return redirect('/admin/foods')->with('success', 'Food deleted successfully.');
    }

}