@extends('master')
@section('content')
    <link rel="stylesheet" href="{{ asset('/source/assets/css/page/checkout.css') }}">
    <div class="checkout-container">
        <div class="main-content">
            <section class="shipping-info card">
                <h2>1. 🚚 Thông tin Giao hàng</h2>
                <form>
                    <div class="form-row">
                        <div class="form-group half-width">
                            <label for="full-name">Họ và Tên (*)</label>
                            <input class="input-checkout" type="text" id="full-name" placeholder="Ví dụ: Nguyễn Văn A" required>
                        </div>
                        <div class="form-group half-width">
                            <label for="phone">Số điện thoại (*)</label>
                            <input class="input-checkout" type="tel" id="phone" placeholder="0901 234 567" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group third-width">
                            <label for="province">Tỉnh / Thành phố (*)</label>
                            <select id="province" required>
                                <option value="">-- Chọn Tỉnh/Thành phố --</option>
                                <option value="hcm">TP. Hồ Chí Minh</option>
                                <option value="hn">Hà Nội</option>
                            </select>
                        </div>
                        <div class="form-group third-width">
                            <label for="district">Quận / Huyện (*)</label>
                            <select id="district" required>
                                <option value="">-- Chọn Quận/Huyện --</option>
                            </select>
                        </div>
                        <div class="form-group third-width">
                            <label for="ward">Phường / Xã (*)</label>
                            <select id="ward" required>
                                <option value="">-- Chọn Phường/Xã --</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address-detail">Địa chỉ chi tiết (*)</label>
                        <input class="input-checkout" type="text" id="address-detail" placeholder="Số nhà, tên đường, tòa nhà..." required>
                    </div>

                    <div class="form-group">
                        <label for="note">Ghi chú (Tùy chọn)</label>
                        <textarea id="note" rows="3" placeholder="Ví dụ: Giao hàng vào giờ hành chính..."></textarea>
                    </div>
                </form>
            </section>

            <section class="payment-method card">
                <h2>2. 💳 Phương thức Thanh toán</h2>
                <div class="payment-options">
                    
                    <div class="radio-group">
                        <input class="input-checkout" type="radio" id="cod" name="payment" value="cod" checked>
                        <label for="cod">Thanh toán khi nhận hàng (COD)</label>
                        <p class="method-detail">Thanh toán tiền mặt cho nhân viên giao hàng khi nhận đơn.</p>
                    </div>
                    
                    <div class="radio-group">
                        <input class="input-checkout" type="radio" id="transfer" name="payment" value="transfer">
                        <label for="transfer">Chuyển khoản Ngân hàng</label>
                        <p class="method-detail">Thông tin tài khoản sẽ được hiển thị sau khi đặt hàng thành công.</p>
                    </div>
                    
                    <div class="radio-group">
                        <input class="input-checkout" type="radio" id="card" name="payment" value="card">
                        <label for="card">Thẻ Tín dụng / Ghi nợ</label>
                        <p class="method-detail">Thanh toán an toàn qua cổng thanh toán.</p>
                    </div>
                </div>
            </section>

        </div>
        
        <div class="order-summary card">
            <h2>📝 Đơn hàng của bạn</h2>

            <div class="product-list">
                <div class="product-item">
                    <span class="product-name">Máy ảnh sony a6000</span>
                    <span class="product-qty">x 1</span>
                    <span class="product-price">250.000₫</span>
                </div>
                <div class="product-item">
                    <span class="product-name">Máy ảnh nikon IV</span>
                    <span class="product-qty">x 2</span>
                    <span class="product-price">600.000₫</span>
                </div>
            </div>

            <hr>

            <div class="summary-details">
                <div class="summary-item">
                    <span>Tổng tiền hàng</span>
                    <span>850.000₫</span>
                </div>
                <div class="summary-item">
                    <span>Phí vận chuyển</span>
                    <span class="shipping-fee">30.000₫</span>
                </div>
                <div class="summary-item">
                    <span>Mã giảm giá</span>
                    <span class="discount-amount">-50.000₫</span>
                </div>
            </div>

            <div class="summary-item total">
                <strong>Tổng cộng phải thanh toán</strong>
                <strong>830.000₫</strong>
            </div>
            
            <button class="place-order-btn">HOÀN TẤT ĐẶT HÀNG</button>

            <p class="policy-note">Bằng cách nhấn **Hoàn Tất Đặt Hàng**, bạn chấp nhận các <a href="#">Điều khoản</a> của chúng tôi.</p>
        </div>

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