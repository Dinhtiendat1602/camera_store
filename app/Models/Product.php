<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    
    protected $fillable = [
        'name',
        'category_id',
        'price',
        'sale_price',
        'quantity',
        'thumbnail',
        'description',
        'view_count',
        'is_featured',
        'total_sold'
    ];
    
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    
    // Kiểm tra sản phẩm có giảm giá không
    public function hasDiscount()
    {
        return $this->sale_price && $this->sale_price < $this->price;
    }
    
    // Lấy giá hiện tại (giá sale nếu có, không thì giá gốc)
    public function getCurrentPrice()
    {
        return $this->hasDiscount() ? $this->sale_price : $this->price;
    }
    
    // Format giá tiền
    public function getFormattedPrice()
    {
        return number_format($this->getCurrentPrice(), 0, ',', '.') . '₫';
    }
    
    // Format giá gốc
    public function getFormattedOriginalPrice()
    {
        return number_format($this->price, 0, ',', '.') . '₫';
    }
    
    // Tính phần trăm giảm giá
    public function getDiscountPercentage()
    {
        if (!$this->hasDiscount()) {
            return 0;
        }
        return round((($this->price - $this->sale_price) / $this->price) * 100);
    }
    
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    
    public function specifications()
    {
        return $this->hasMany(Specification::class);
    }
}