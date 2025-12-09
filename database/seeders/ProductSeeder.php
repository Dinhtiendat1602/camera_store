<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Tạo danh mục
        $categories = [
            ['name' => 'Máy ảnh DSLR'],
            ['name' => 'Máy ảnh Mirrorless'],
            ['name' => 'Ống kính'],
            ['name' => 'Phụ kiện'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Tạo sản phẩm
        $products = [
            [
                'category_id' => 1,
                'name' => 'Canon EOS 5D Mark IV',
                'price' => 65000000,
                'sale_price' => 58000000,
                'quantity' => 10,
                'thumbnail' => 'canon-5d-mark-iv.jpg',
                'description' => 'Máy ảnh DSLR full-frame chuyên nghiệp với cảm biến 30.4MP',
                'is_featured' => true,
                'total_sold' => 25
            ],
            [
                'category_id' => 1,
                'name' => 'Nikon D850',
                'price' => 70000000,
                'quantity' => 8,
                'thumbnail' => 'nikon-d850.jpg',
                'description' => 'Máy ảnh DSLR độ phân giải cao 45.7MP',
                'is_featured' => true,
                'total_sold' => 18
            ],
            [
                'category_id' => 2,
                'name' => 'Sony A7R V',
                'price' => 85000000,
                'sale_price' => 80000000,
                'quantity' => 5,
                'thumbnail' => 'sony-a7r-v.jpg',
                'description' => 'Máy ảnh mirrorless full-frame 61MP với khả năng quay video 8K',
                'is_featured' => true,
                'total_sold' => 12
            ],
            [
                'category_id' => 2,
                'name' => 'Fujifilm X-T5',
                'price' => 45000000,
                'quantity' => 15,
                'thumbnail' => 'fujifilm-xt5.jpg',
                'description' => 'Máy ảnh mirrorless APS-C 40MP với thiết kế cổ điển',
                'total_sold' => 30
            ],
            [
                'category_id' => 3,
                'name' => 'Canon EF 24-70mm f/2.8L',
                'price' => 35000000,
                'quantity' => 20,
                'thumbnail' => 'canon-24-70.jpg',
                'description' => 'Ống kính zoom tiêu chuẩn chuyên nghiệp',
                'total_sold' => 45
            ],
            [
                'category_id' => 3,
                'name' => 'Sony FE 85mm f/1.4 GM',
                'price' => 42000000,
                'quantity' => 12,
                'thumbnail' => 'sony-85mm.jpg',
                'description' => 'Ống kính chân dung cao cấp với độ mở khẩu lớn',
                'total_sold' => 22
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}