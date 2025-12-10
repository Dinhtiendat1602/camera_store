<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Category;

class AdminController extends Controller
{
    /**
     * ====================
     * DASHBOARD
     * ====================
     */
    public function dashboard()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_users' => User::count(),
            'revenue' => Order::where('status', 'completed')->sum('total_amount'),
            'pending_orders' => Order::where('status', 'pending')->count(),
        ];

        $recent_orders = Order::with('user')->orderBy('created_at', 'desc')->take(10)->get();
        $low_stock_products = Product::where('quantity', '<', 10)->orderBy('quantity')->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recent_orders', 'low_stock_products'));
    }

    /**
     * ====================
     * PRODUCT MANAGEMENT
     * ====================
     */
    
    public function products(Request $request)
    {
        $query = Product::with('category');
        
        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        }

        
        // Filter by status
        if ($request->has('status')) {
            if ($request->status == 'in_stock') {
                $query->where('quantity', '>', 0);
            } elseif ($request->status == 'out_of_stock') {
                $query->where('quantity', '<=', 0);
            }
        }
        
        $products = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.products.index', compact('products'));
    }

    public function createProduct()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            try {
                $uploadPath = public_path('source/images/products');
                
                // Kiểm tra và tạo thư mục
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                
                // Kiểm tra quyền ghi
                if (!is_writable($uploadPath)) {
                    chmod($uploadPath, 0777);
                }
                
                $file->move($uploadPath, $filename);
                $validated['thumbnail'] = $filename;
            } catch (\Exception $e) {
                Log::error('Upload error: ' . $e->getMessage());
                return back()->withErrors(['thumbnail' => 'Lỗi upload: ' . $e->getMessage()]);
            }
        }

        Product::create($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được thêm thành công!');
    }

    public function showProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('thumbnail')) {
            // Delete old image if exists
            if ($product->thumbnail && file_exists(public_path('source/images/products/' . $product->thumbnail))) {
                unlink(public_path('source/images/products/' . $product->thumbnail));
            }
            
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            
            try {
                $uploadPath = public_path('source/images/products');
                
                // Kiểm tra và tạo thư mục
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                
                // Kiểm tra quyền ghi
                if (!is_writable($uploadPath)) {
                    chmod($uploadPath, 0777);
                }
                
                $file->move($uploadPath, $filename);
                $validated['thumbnail'] = $filename;
            } catch (\Exception $e) {
                Log::error('Upload error: ' . $e->getMessage());
                return back()->withErrors(['thumbnail' => 'Lỗi upload: ' . $e->getMessage()]);
            }
        }

        $product->update($validated);

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }

    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        
        // Delete image if exists
        if ($product->thumbnail && file_exists(public_path('source/images/products/' . $product->thumbnail))) {
            unlink(public_path('source/images/products/' . $product->thumbnail));
        }
        
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Sản phẩm đã được xóa thành công!');
    }

    /**
     * ====================
     * ORDER MANAGEMENT
     * ====================
     */
    
    public function orders(Request $request)
    {
        $query = Order::query();
        
        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('order_code', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('customer_phone', 'like', "%{$search}%");
        }
        
        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by date
        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $orders = $query->orderBy('created_at', 'desc')->paginate(20);
        $statuses = ['pending', 'processing', 'completed', 'cancelled'];
        
        return view('admin.orders.index', compact('orders', 'statuses'));
    }

    public function showOrder($id)
    {
        $order = Order::with(['orderItems.product', 'user'])->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function updateOrder(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
            'payment_status' => 'nullable|in:pending,paid,failed',
            'notes' => 'nullable|string',
        ]);

        $order->update($validated);

        return redirect()->route('admin.orders.show', $id)
            ->with('success', 'Đơn hàng đã được cập nhật thành công!');
    }

    public function updateOrderStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);
        
        $order->update(['status' => $request->status]);
        
        return response()->json(['success' => true, 'message' => 'Cập nhật trạng thái thành công!']);
    }

    public function destroyOrder($id)
    {
        $order = Order::findOrFail($id);
        
        // Delete related order items first
        $order->orderItems()->delete();
        
        $order->delete();

        return redirect()->route('admin.orders.index')
            ->with('success', 'Đơn hàng đã được xóa thành công!');
    }

    /**
     * ====================
     * USER MANAGEMENT
     * ====================
     */
    
    public function users(Request $request)
    {
        $query = User::query();
        
        // Search
        if ($request->has('search')) {
            $search = $request->search;
            $query->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
        }
        
        // Filter by role
        if ($request->has('role')) {
            $query->where('role', $request->role);
        }
        
        $users = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.users.index', compact('users'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'role' => 'required|in:admin,customer',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        
        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Người dùng đã được thêm thành công!');
    }

    public function showUser($id)
    {
        $user = User::with('orders')->findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'role' => 'required|in:admin,customer',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'Người dùng đã được cập nhật thành công!');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Người dùng đã được xóa thành công!');
    }
}