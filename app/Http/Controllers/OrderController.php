<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // only logged-in users can create/view orders
    }

    // List all orders for the logged-in user
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->with('product')->paginate(10);
        return view('orders.index', compact('orders'));
    }

    // Show form to create an order (checkout)
    public function create()
    {
        $products = Product::all();
        return view('orders.create', compact('products'));
    }

    // Store order
    public function store(Request $request)
    {
        $request->validate([
            'cart_data' => 'required|json',
        ]);

        $cart = json_decode($request->cart_data, true);

        if(!$cart || count($cart) === 0){
            return redirect()->back()->with('error', 'Your cart is empty.');
        }

        foreach($cart as $item){
            // Validate each item
            if(!isset($item['id'], $item['quantity']) || $item['quantity'] < 1){
                continue; // skip invalid items
            }

            $product = Product::find($item['id']);
            if(!$product || $product->stock < $item['quantity']){
                continue; // skip if product doesn't exist or not enough stock
            }

            Order::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'quantity' => $item['quantity'],
                'total_price' => $product->price * $item['quantity'],
            ]);

            // Optional: reduce stock
            $product->decrement('stock', $item['quantity']);
        }

        return redirect()->route('orders.index')->with('success', 'Order placed successfully!');
    }

    // Show order details
    public function show(Order $order)
    {
        $this->authorize('view', $order); // optional: add policy later
        return view('orders.show', compact('order'));
    }
}
