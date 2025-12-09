<?php

namespace App\Http\Controllers;
use App\Models\Slide;
use App\Models\Product;
use App\Models\BestSeller;
use App\Models\FeaturedProduct;
use App\Models\Category;
use App\Models\Order;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function showHome(){
        $slide = Slide::all();
        // Lấy sản phẩm nổi bật từ bảng products với is_featured = true
        $featuredProducts = Product::where('is_featured', true)->take(8)->get();
            
        // Lấy sản phẩm bán chạy từ bảng products sắp xếp theo total_sold
        $bestSaleProducts = Product::orderBy('total_sold', 'desc')->take(10)->get();
            
        return view('page.home', compact('slide', 'featuredProducts', 'bestSaleProducts'));
    }

    public function showCategories(Request $request){
        $categories = Category::all();
        $categoryId = $request->get('category_id');
        $search = $request->get('search');
        
        $query = Product::query();
        
        // Nếu có tìm kiếm, bỏ qua bộ lọc danh mục để tìm trong tất cả sản phẩm
        if($search) {
            $search = trim($search);
            $query->where(function($q) use ($search) {
                $q->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($search) . '%'])
                  ->orWhereRaw('LOWER(description) LIKE ?', ['%' . strtolower($search) . '%']);
            });
        } else if($categoryId) {
            // Chỉ lọc theo danh mục khi không có tìm kiếm
            $query->where('category_id', $categoryId);
        }
        
        $products = $query->get();
        
        return view('page.categories', compact('categories', 'products', 'categoryId'));
    }
    public function showRegister(){
        return view('user.register');
    }
    public function showLogin(){
        return view('user.login');
    }
    public function showCheckout(){
        return view('page.checkout');
    }
    public function showAbout(){
        return view('page.about');
    }
    public function showDetail($id = 1){
        $product = Product::with(['category', 'reviews', 'specifications'])->findOrFail($id);
        
        // Tăng view count
        $product->increment('view_count');
        
        // Lấy sản phẩm liên quan cùng danh mục
        $relatedProducts = $this->getProductsByCategory($product->category_id, $product->id, 8);
        
        // Lấy sản phẩm xem nhiều nhất
        $mostViewedProducts = $this->getMostViewedProducts(5);
        
        return view('page.product_detail', compact('product', 'relatedProducts', 'mostViewedProducts'));
    }
    public function showCart(){
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem giỏ hàng!');
        }
        
        $cartItems = \App\Models\Cart::with('product')
                                    ->where('user_id', Auth::id())
                                    ->get();
        
        return view('page.cart', compact('cartItems'));
    }
    public function showContact(){
        return view('page.contact');
    }
    public function showAdmin(){
        return view('admin.admin');
    }
    
    // Lấy sản phẩm xem nhiều nhất
    public function getMostViewedProducts($limit = 5)
    {
        return Product::orderBy('view_count', 'desc')
                     ->take($limit)
                     ->get();
    }
    
    // Lấy sản phẩm cùng danh mục
    public function getProductsByCategory($categoryId, $excludeId = null, $limit = 8)
    {
        $query = Product::where('category_id', $categoryId);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }
        
        return $query->orderBy('total_sold', 'desc')
                    ->take($limit)
                    ->get();
    }
}
