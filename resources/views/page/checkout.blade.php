@extends('master')
@section('content')
    <link rel="stylesheet" href="{{ asset('/source/assets/css/page/checkout.css') }}">
    @if($cartItems->isEmpty())
        <div class="empty-cart">
            <h2>Giỏ hàng trống</h2>
            <a href="{{ route('home') }}" class="btn">Tiếp tục mua sắm</a>
        </div>
    @else
    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="checkout-container">
            <div class="main-content">
                <section class="shipping-info card">
                    <h2>1. 🚚 Thông tin Giao hàng</h2>
                    <div class="form-row">
                        <div class="form-group half-width">
                            <label for="shipping_full_name">Họ và Tên (*)</label>
                            <input class="input-checkout" type="text" name="shipping_full_name" value="{{ Auth::user()->name ?? '' }}" placeholder="Ví dụ: Nguyễn Văn A" required>
                        </div>
                        <div class="form-group half-width">
                            <label for="shipping_phone">Số điện thoại (*)</label>
                            <input class="input-checkout" type="tel" name="shipping_phone" value="{{ Auth::user()->phone ?? '' }}" placeholder="0901 234 567" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="shipping_email">Email (*)</label>
                        <input class="input-checkout" type="email" name="shipping_email" value="{{ Auth::user()->email ?? '' }}" placeholder="email@example.com" required>
                    </div>

                    <div class="form-group">
                        <label for="shipping_address">Địa chỉ chi tiết (*)</label>
                        <textarea name="shipping_address" rows="3" placeholder="Số nhà, tên đường, phường/xã, quận/huyện, tỉnh/thành phố" required></textarea>
                    </div>
                </section>

                <section class="payment-method card">
                    <h2>2. 💳 Phương thức Thanh toán</h2>
                    <div class="payment-options">
                        <div class="radio-group">
                            <input class="input-checkout" type="radio" id="cod" name="payment_method" value="cod" checked>
                            <label for="cod">Thanh toán khi nhận hàng (COD)</label>
                            <p class="method-detail">Thanh toán tiền mặt cho nhân viên giao hàng khi nhận đơn.</p>
                        </div>
                        
                        <div class="radio-group">
                            <input class="input-checkout" type="radio" id="bank" name="payment_method" value="bank">
                            <label for="bank">Chuyển khoản Ngân hàng</label>
                            <p class="method-detail">Thông tin tài khoản sẽ được hiển thị sau khi đặt hàng thành công.</p>
                        </div>
                    </div>
                </section>
            </div>
        
            <div class="order-summary card">
                <h2>📝 Đơn hàng của bạn</h2>

                <div class="product-list">
                    @foreach($cartItems as $item)
                    <div class="product-item">
                        <span class="product-name">{{ $item->product->name }}</span>
                        <span class="product-qty">x {{ $item->quantity }}</span>
                        <span class="product-price">{{ number_format($item->quantity * ($item->product->sale_price ?? $item->product->price)) }}₫</span>
                    </div>
                    @endforeach
                </div>

                <hr>

                @php
                    $subtotal = $cartItems->sum(function($item) {
                        return $item->quantity * ($item->product->sale_price ?? $item->product->price);
                    });
                    $shipping = $subtotal >= 5000000 ? 0 : 30000;
                    $total = $subtotal + $shipping;
                @endphp

                <div class="summary-details">
                    <div class="summary-item">
                        <span>Tổng tiền hàng</span>
                        <span>{{ number_format($subtotal) }}₫</span>
                    </div>
                    <div class="summary-item">
                        <span>Phí vận chuyển</span>
                        <span class="shipping-fee">{{ $shipping > 0 ? number_format($shipping) . '₫' : 'Miễn phí' }}</span>
                    </div>
                </div>

                <div class="summary-item total">
                    <strong>Tổng cộng phải thanh toán</strong>
                    <strong>{{ number_format($total) }}₫</strong>
                </div>
                
                <button type="submit" class="place-order-btn">HOÀN TẤT ĐẶT HÀNG</button>

                <p class="policy-note">Bằng cách nhấn **Hoàn Tất Đặt Hàng**, bạn chấp nhận các <a href="#">Điều khoản</a> của chúng tôi.</p>
            </div>
        </div>
    </form>
    @endif

    </div>

    <script>
        // --- JAVASCRIPT ĐỂ XỬ LÝ CLICK PHƯƠNG THỨC THANH TOÁN ---
        document.addEventListener('DOMContentLoaded', function() {
            const radioGroups = document.querySelectorAll('.radio-group');

            radioGroups.forEach(group => {
                group.addEventListener('click', function() {
                    const radioInput = this.querySelector('input[type="radio"]');
                    
                    // Chỉ chọn nếu nó không bị disabled
                    if (radioInput && !radioInput.disabled) {
                        radioInput.checked = true;
                    }
                });
            });
        });
    </script>
@endsection