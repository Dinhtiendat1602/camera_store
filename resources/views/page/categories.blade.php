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
                    <!-- <div class="search-container">
                        <form method="GET" action="{{ route('categories') }}" class="search-form">
                            @if($categoryId)
                                <input type="hidden" name="category_id" value="{{ $categoryId }}">
                            @endif
                            <input type="text" name="search" placeholder="Tìm kiếm sản phẩm..." value="{{ request('search') }}" class="search-input">
                            <button type="submit" class="search-btn">🔍</button>
                        </form>
                    </div> -->
                </div>
                @if($products->count() > 0)
                    <div class="products-grid">
                        @foreach($products as $product)
                        <div class="product-card">
                            <div class="product-image">
                                <img src="/source/images/products/{{ $product->thumbnail }}" alt="{{ $product->name }}">
                                <div class="product-overlay">
                                    <a href="{{ route('detail', $product->id) }}" class="btn btn-secondary">Xem chi tiết</a>
                                    <form class="add-to-cart-form" data-product-id="{{ $product->id }}" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="button" class="btn btn-primary add-to-cart-btn">
                                            <i class="fas fa-shopping-cart"></i>
                                            <span class="btn-text">Thêm vào giỏ</span>
                                        </button>
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

    <script>
document.addEventListener('DOMContentLoaded', function() {
    // AJAX Add to Cart for Categories Page
    const addToCartForms = document.querySelectorAll('.add-to-cart-form');
    
    addToCartForms.forEach(form => {
        const btn = form.querySelector('.add-to-cart-btn');
        
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const btnText = this.querySelector('.btn-text');
            const btnIcon = this.querySelector('i');
            const originalText = btnText.textContent;
            
            // Disable button and show loading
            this.disabled = true;
            btnIcon.className = 'fas fa-spinner fa-spin';
            btnText.textContent = 'Đang thêm...';
            
            const formData = new FormData(form);
            
            fetch('{{ route("cart.add") }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Success feedback
                    btnIcon.className = 'fas fa-check';
                    btnText.textContent = 'Đã thêm!';
                    this.style.backgroundColor = '#28a745';
                    
                    // Show success notification
                    showNotification('Đã thêm sản phẩm vào giỏ hàng!', 'success');
                    
                    // Reset button after 2 seconds
                    setTimeout(() => {
                        btnIcon.className = 'fas fa-shopping-cart';
                        btnText.textContent = originalText;
                        this.style.backgroundColor = '';
                        this.disabled = false;
                    }, 2000);
                } else {
                    throw new Error(data.message || 'Có lỗi xảy ra');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                
                // Error feedback
                btnIcon.className = 'fas fa-exclamation-triangle';
                btnText.textContent = 'Lỗi!';
                this.style.backgroundColor = '#dc3545';
                
                showNotification(error.message || 'Có lỗi xảy ra khi thêm vào giỏ hàng', 'error');
                
                // Reset button after 2 seconds
                setTimeout(() => {
                    btnIcon.className = 'fas fa-shopping-cart';
                    btnText.textContent = originalText;
                    this.style.backgroundColor = '';
                    this.disabled = false;
                }, 2000);
            });
        });
    });
    
    // Notification function
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.innerHTML = `
            <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle'}"></i>
            <span>${message}</span>
        `;
        
        document.body.appendChild(notification);
        
        // Show notification
        setTimeout(() => notification.classList.add('show'), 100);
        
        // Hide notification after 3 seconds
        setTimeout(() => {
            notification.classList.remove('show');
            setTimeout(() => notification.remove(), 300);
        }, 3000);
    }
});
    </script>
@endsection
