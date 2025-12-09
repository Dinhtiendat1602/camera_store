<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    protected $table = 'product_specs';
    
    protected $fillable = [
        'product_id',
        'spec_key',
        'spec_value', 
        'spec_group'
    ];
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}