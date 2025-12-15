<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Cart;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        try {
            if (!Auth::check()) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Bạn cần đăng nhập để thêm sản phẩm vào giỏ hàng.',
                        'redirect' => route('login')
                    ]);
                }
                return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thêm vào giỏ hàng!');
            }

            $productId = $request->input('product_id');
            $quantity = $request->input('quantity', 1);
            
            if (!$productId) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Thiếu thông tin sản phẩm!'
                    ]);
                }
                return redirect()->back()->with('error', 'Thiếu thông tin sản phẩm!');
            }

            $product = Product::findOrFail($productId);
        
            if ($product->quantity < $quantity) {
                if ($request->ajax() || $request->wantsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Số lượng sản phẩm không đủ!'
                    ]);
                }
                return redirect()->back()->with('error', 'Số lượng sản phẩm không đủ!');
            }

            $existingCart = Cart::where('user_id', Auth::id())
                               ->where('product_id', $productId)
                               ->first();

            if ($existingCart) {
                $newQuantity = $existingCart->quantity + $quantity;
                if ($product->quantity < $newQuantity) {
                    if ($request->ajax() || $request->wantsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Số lượng sản phẩm không đủ!'
                        ]);
                    }
                    return redirect()->back()->with('error', 'Số lượng sản phẩm không đủ!');
                }
                $existingCart->quantity = $newQuantity;
                $existingCart->save();
            } else {
                Cart::create([
                    'user_id' => Auth::id(),
                    'product_id' => $productId,
                    'quantity' => $quantity
                ]);
            }

            // Tính tổng số lượng trong giỏ hàng
            $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
            
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Đã thêm vào giỏ hàng!',
                    'cartCount' => $cartCount
                ]);
            }
            
            return redirect()->back()->with('success', 'Đã thêm vào giỏ hàng!')->withFragment('product-' . $productId);
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Có lỗi xảy ra: ' . $e->getMessage()
                ], 500);
            }
            return redirect()->back()->with('error', 'Có lỗi xảy ra!');
        }
    }

    public function updateCart(Request $request)
    {
        $cartId = $request->cart_id;
        $quantity = $request->quantity;
        
        $cartItem = Cart::where('id', $cartId)
                       ->where('user_id', Auth::id())
                       ->first();
        
        if ($cartItem && $quantity > 0) {
            if ($cartItem->product->quantity >= $quantity) {
                $cartItem->quantity = $quantity;
                $cartItem->save();
                return response()->json(['success' => true]);
            }
        }
        
        return response()->json(['success' => false]);
    }

    public function removeFromCart($id)
    {
        Cart::where('id', $id)
            ->where('user_id', Auth::id())
            ->delete();
            
        return redirect()->back()->with('success', 'Đã xóa sản phẩm khỏi giỏ hàng!');
    }

    public function checkout()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thanh toán!');
        }
        
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart')->with('error', 'Giỏ hàng trống!');
        }
        
        return view('page.checkout', compact('cartItems'));
    }
    
    public function getCartCount()
    {
        if (!Auth::check()) {
            return response()->json(['count' => 0]);
        }
        
        $count = Cart::where('user_id', Auth::id())->sum('quantity');
        return response()->json(['count' => $count]);
    }
}