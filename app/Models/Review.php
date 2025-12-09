<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $table = 'reviews';
    
    protected $fillable = [
        'product_id',
        'author_name', 
        'rating',
        'title',
        'content'
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function getStarsAttribute()
    {
        return str_repeat('★', $this->rating) . str_repeat('☆', 5 - $this->rating);
    }
}