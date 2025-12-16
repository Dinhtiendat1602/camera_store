<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'full_name.required' => 'Vui lòng nhập họ tên',
            'full_name.max' => 'Họ tên không được quá 50 ký tự',
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.unique' => 'Email này đã được sử dụng',
            'password.required' => 'Vui lòng nhập mật khẩu',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp',
        ]);

        User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'customer'
        ]);
        return redirect()->route('login')->with('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ], [
            'email.required' => 'Vui lòng nhập email',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Vui lòng nhập mật khẩu',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('home')->with('success', 'Đăng nhập thành công!');
        }

        return back()->with('error', 'Email hoặc mật khẩu không đúng!');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('home')->with('success', 'Đăng xuất thành công!');
    }
    
    /**
     * Hiển thị trang profile của người dùng
     */
    public function showProfile()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }
    
    /**
     * Hiển thị danh sách đơn hàng của người dùng
     */
    public function showOrders()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $orders = $user->orders()->orderBy('created_at', 'desc')->get();
        return view('user.orders', compact('user', 'orders'));
    }
    
    /**
     * Hiển thị chi tiết đơn hàng
     */
    public function showOrderDetail($id)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $order = $user->orders()->with('orderItems.product')->findOrFail($id);
        return view('user.order_detail', compact('user', 'order'));
    }
}