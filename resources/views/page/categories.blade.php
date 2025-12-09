@extends('master')
@section('content')
    <link rel="stylesheet" href="{{ asset('/source/assets/css/page/categories.css') }}">

    <div class="body-categoris">
        <div class="cl-2">
            <div class="cl-2-header">
                <h3>Danh mục </h3>
                <hr>
            </div>
            @foreach($categories as $category)
            <div class="brands">
                <a href="{{ route('categories', ['category_id' => $category->id]) }}">{{ $category->name }}</a>
            </div>
            @endforeach
        </div>
        <div class="container-categoris">
            <div class="cl-10">
                <div class="categories-header">
                    <h2 class="section-title">
                        @if(request('search'))
                            Kết quả tìm kiếm: "{{ request('search') }}"
                        @else
                            {{ $categoryId ? $categories->find($categoryId)->name : 'Tất cả sản phẩm' }}
                        @endif
                    </h2>
                    <div class="search-container">
                        <form method="GET" action="{{ route('categories') }}" class="search-form">
                            @if($categoryId)
                                <input type="hidden" name="category_id" value="{{ $categoryId }}">
                            @endif
                            <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..." value="{{ request('search') }}" class="search-input">
                            <button type="submit" class="search-btn">🔍</button>
                        </form>
                    </div>
                </div>
                @if($products->count() > 0)
                    <div class="products-grid">
                        @foreach($products as $product)
                        <div class="product-card">
                            <div class="product-image">
                                <img src="/source/images/products/{{ $product->thumbnail }}" alt="{{ $product->name }}">
                                <div class="product-overlay">
                                    <a href="{{ route('detail', $product->id) }}" class="btn btn-secondary">Xem chi tiết</a>
                                    <form action="{{ route('cart.add') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-primary">Thêm vào giỏ</button>
                                    </form>
                                </div>
                            </div>
                            <div class="product-info">
                                <h3 class="product-name">
                                    <a href="{{ route('detail', $product->id) }}">{{ $product->name }}</a>
                                </h3>
                                
                                <div class="product-price">
                                    <span class="current-price">{{ number_format($product->sale_price ?? $product->price, 0, ',', '.') }}₫</span>
                                    @if($product->sale_price)
                                    <span class="original-price">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                                    @endif
                                </div>
                                <p class="product-description">{{ Str::limit($product->description, 100) }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="no-products">
                        <p>Không tìm thấy sản phẩm nào{{ request('search') ? ' với từ khóa "' . request('search') . '"' : '' }}.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
