@extends('master')

@section('content')
<link rel="stylesheet" href="{{ asset('/source/assets/css/page/checkout.css') }}">
@if(!isset($cartItems) || $cartItems->isEmpty())
    <div class="alert alert-warning text-center">
        <i class="fas fa-exclamation-circle"></i> Giỏ hàng của bạn đang trống. 
        <a href="{{ route('categories') }}">Tiếp tục mua sắm</a>
    </div>
@else
<form action="{{ route('checkout.process') }}" method="POST">
    @csrf
    <div class="checkout-container">
        <div class="main-content">
            <section class="shipping-info card">
                <h2>1. 📍 Thông tin giao hàng</h2>
                
                <div class="form-group">
                    <label for="shipping_full_name">Họ và tên (*)</label>
                    <input class="input-checkout" type="text" name="shipping_full_name" value="{{ Auth::user()->name ?? '' }}" placeholder="Ví dụ: Nguyễn Văn A" required>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="shipping_phone">Số điện thoại (*)</label>
                        <input class="input-checkout" type="tel" name="shipping_phone" value="{{ Auth::user()->phone ?? '' }}" placeholder="0901 234 567" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="shipping_email">Email (*)</label>
                        <input class="input-checkout" type="email" name="shipping_email" value="{{ Auth::user()->email ?? '' }}" placeholder="email@example.com" required>
                    </div>
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
                $shipping = 0; // Miễn phí ship
                $discount = 0; // Chưa áp dụng giảm giá
                $total = $subtotal + $shipping - $discount;
            @endphp

            <div class="summary-details">
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
                    <span id="total-amount">{{ number_format($total, 0, ',', '.') }}₫</span>
                </div>
            </div>
            
            <button type="submit" class="place-order-btn">HOÀN TẤT ĐẶT HÀNG</button>

            <p class="policy-note">Bằng cách nhấn **Hoàn Tất Đặt Hàng**, bạn chấp nhận các <a href="#">Điều khoản</a> của chúng tôi.</p>
        </div>
    </div>
</form>
@endif

<script>
    // --- JAVASCRIPT ĐỂ XỬ LÝ CLICK PHƯƠNG THỨC THANH TOÁN ---
    document.addEventListener('DOMContentLoaded', function() {
        const radioGroups = document.querySelectorAll('.radio-group');
        const bankTransferInfo = document.getElementById('bank-transfer-info');

        radioGroups.forEach(group => {
            group.addEventListener('click', function() {
                const radioInput = this.querySelector('input[type="radio"]');
                
                // Chỉ chọn nếu nó không bị disabled
                if (radioInput && !radioInput.disabled) {
                    radioInput.checked = true;
                    
                    // Hiển thị/ẩn thông tin chuyển khoản ngân hàng
                    if (radioInput.value === 'bank') {
                        bankTransferInfo.classList.remove('hidden');
                    } else {
                        bankTransferInfo.classList.add('hidden');
                    }
                }
            });
        });
    });
</script>
@endsection