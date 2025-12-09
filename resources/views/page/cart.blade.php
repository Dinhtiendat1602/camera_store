@extends('master')
@section('content')
<link rel="stylesheet" href="{{ asset('source/assets/css/page/cart.css') }}">
<link rel="stylesheet" href="{{ asset('source/assets/css/notification.css') }}">

@if(session('success'))
    <div class="notification-overlay">
        <div class="notification success">
            <i class="fas fa-check-circle"></i>
            <span>{{ session('success') }}</span>
        </div>
    </div>
@endif

@if(session('error'))
    <div class="notification-overlay">
        <div class="notification error">
            <i class="fas fa-exclamation-circle"></i>
            <span>{{ session('error') }}</span>
        </div>
    </div>
@endif

<div class="container">
    <div class="cart-container">
        @if($cartItems->count() > 0)
            <!-- Phần sản phẩm -->
            <div class="cart-items">
                <div class="cart-items-header">
                    <div>SẢN PHẨM</div>
                    <div>SỐ LƯỢNG</div>
                    <div>TỔNG TIỀN</div>
                    <div></div>
                </div>
                
                @foreach($cartItems as $item)
                <div class="cart-item" data-cart-id="{{ $item->id }}">
                    <div class="item-info">
                        <div class="item-image">
                            <img src="{{ asset('source/images/products/' . $item->product->thumbnail) }}" alt="{{ $item->product->name }}">
                        </div>
                        <div class="item-details">
                            <h3 class="item-name">{{ $item->product->name }}</h3>
                            <p class="item-sku">Mã SP: #{{ $item->product->id }}</p>
                            <div class="item-price-info">
                                <div class="item-price">{{ number_format($item->product->getCurrentPrice(), 0, ',', '.') }}₫</div>
                                @if($item->product->hasDiscount())
                                <div class="item-original-price">{{ number_format($item->product->price, 0, ',', '.') }}₫</div>
                                @endif
                            </div>
                            <span class="item-status {{ $item->product->quantity > 0 ? 'in-stock' : 'out-of-stock' }}">
                                <i class="fas fa-{{ $item->product->quantity > 0 ? 'check-circle' : 'times-circle' }}"></i> 
                                {{ $item->product->quantity > 0 ? 'Còn hàng' : 'Hết hàng' }}
                            </span>
                        </div>
                    </div>
                    <div class="quantity-section">
                        <div class="quantity-controls">
                            <button class="quantity-btn" data-cart-id="{{ $item->id }}" data-action="decrease" data-current="{{ $item->quantity }}">-</button>
                            <input type="number" class="quantity-input" value="{{ $item->quantity }}" min="1" max="{{ $item->product->quantity }}" readonly>
                            <button class="quantity-btn" data-cart-id="{{ $item->id }}" data-action="increase" data-current="{{ $item->quantity }}">+</button>
                        </div>
                        <div class="stock-indicator">
                            <span>Còn {{ $item->product->quantity }} sản phẩm</span>
                        </div>
                    </div>
                    <div class="item-total-section">
                        <div class="item-total">{{ number_format($item->product->getCurrentPrice() * $item->quantity, 0, ',', '.') }}₫</div>
                        @if($item->product->hasDiscount())
                        <div class="item-savings">Tiết kiệm: {{ number_format(($item->product->price - $item->product->getCurrentPrice()) * $item->quantity, 0, ',', '.') }}₫</div>
                        @endif
                    </div>
                    <div class="item-actions">
                        <form action="{{ route('cart.remove', $item->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn remove-btn" title="Xóa" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
                @endforeach
            </div>
            
            <!-- Phần tóm tắt -->
            <div class="cart-summary">
                <h3><i class="fas fa-receipt"></i> Tóm Tắt Đơn Hàng</h3>
                
                <div class="summary-details">
                    @php
                        $subtotal = $cartItems->sum(function($item) {
                            return $item->product->getCurrentPrice() * $item->quantity;
                        });
                        $shipping = $subtotal >= 5000000 ? 0 : 50000;
                        $total = $subtotal + $shipping ;
                    @endphp
                    
                    <div class="summary-row">
                        <span>Tạm tính:</span>
                        <span>{{ number_format($subtotal, 0, ',', '.') }}₫</span>
                    </div>
                    <div class="summary-row">
                        <span>Phí vận chuyển:</span>
                        <span>{{ $shipping > 0 ? number_format($shipping, 0, ',', '.') . '₫' : 'Miễn phí' }}</span>
                    </div>
                    <div class="summary-row total">
                        <span>Tổng thanh toán:</span>
                        <span>{{ number_format($total, 0, ',', '.') }}₫</span>
                    </div>
                </div>
                
                <div class="action-buttons">
                    <a href="{{ route('checkout') }}" class="btn btn-primary">
                        <i class="fas fa-lock"></i> Tiến Hành Thanh Toán
                    </a>
                    <a href="{{ route('categories') }}" class="btn btn-outline">
                        <i class="fas fa-arrow-left"></i> Tiếp Tục Mua Sắm
                    </a>
                </div>
            </div>
        @else
            <div class="empty-cart">
                <i class="fas fa-shopping-cart"></i>
                <h3>Giỏ hàng của bạn đang trống</h3>
                <p>Hãy thêm sản phẩm vào giỏ hàng để bắt đầu mua sắm</p>
                <a href="{{ route('categories') }}" class="btn btn-primary">
                    <i class="fas fa-store"></i> Xem sản phẩm
                </a>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const quantityBtns = document.querySelectorAll('.quantity-btn');
    
    quantityBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const cartId = this.getAttribute('data-cart-id');
            const action = this.getAttribute('data-action');
            const current = parseInt(this.getAttribute('data-current'));
            
            let newQuantity;
            if (action === 'increase') {
                newQuantity = current + 1;
            } else {
                newQuantity = current - 1;
            }
            
            updateQuantity(cartId, newQuantity);
        });
    });
});

function updateQuantity(cartId, newQuantity) {
    if (newQuantity < 1) return;
    
    fetch('{{ route("cart.update") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            cart_id: cartId,
            quantity: newQuantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Không thể cập nhật số lượng!');
        }
    });
}
</script>
@endsection