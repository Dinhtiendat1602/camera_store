<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Checkout;
use App\Models\Cart;

class CheckoutController extends Controller
{
    public function processCheckout(Request $request)
    {

        $request->validate([
            'shipping_full_name' => 'required|string|max:150',
            'shipping_email' => 'required|email|max:150',
            'shipping_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'payment_method' => 'required|string'
        ]);

        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        $totalAmount = $cartItems->sum(function($item) {
            return $item->quantity * $item->product->price;
        });

        // Tạo đơn hàng
        $order = Order::create([
            'order_code' => 'ORD' . time(),
            'user_id' => Auth::id(),
            'customer_name' => $request->shipping_full_name,
            'customer_email' => $request->shipping_email,
            'customer_phone' => $request->shipping_phone,
            'customer_address' => $request->shipping_address,
            'total_amount' => $totalAmount,
            'final_amount' => $totalAmount,
            'payment_method' => $request->payment_method,
            'status' => 'pending'
        ]);

        // Tạo chi tiết đơn hàng
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'total' => $item->quantity * $item->product->price
            ]);
        }

        // Lưu thông tin checkout
        Checkout::create([
            'order_id' => $order->id,
            'user_id' => Auth::id(),
            'shipping_full_name' => $request->shipping_full_name,
            'shipping_email' => $request->shipping_email,
            'shipping_phone' => $request->shipping_phone,
            'shipping_address' => $request->shipping_address,
            'shipping_city' => $request->shipping_city,
            'shipping_district' => $request->shipping_district,
            'shipping_ward' => $request->shipping_ward,
            'payment_method' => $request->payment_method,
            'total_amount' => $totalAmount
        ]);

        // Xóa giỏ hàng
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->route('order.success')->with('success', 'Đặt hàng thành công!');
    }
}