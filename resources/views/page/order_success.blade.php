@extends('master')
@section('content')
<style>
.success-container {
    max-width: 600px;
    margin: 50px auto;
    padding: 40px;
    text-align: center;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.success-icon {
    font-size: 80px;
    color: #28a745;
    margin-bottom: 20px;
}

.success-title {
    font-size: 28px;
    color: #333;
    margin-bottom: 15px;
}

.success-message {
    font-size: 16px;
    color: #666;
    margin-bottom: 30px;
    line-height: 1.6;
}

.success-actions {
    display: flex;
    gap: 15px;
    justify-content: center;
    flex-wrap: wrap;
}

.btn {
    padding: 12px 24px;
    border: none;
    border-radius: 5px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s;
}

.btn-primary {
    background: #007bff;
    color: white;
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.2);
}

/* Styles for bank transfer payment */
.payment-info {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 20px;
    margin: 20px 0;
    text-align: left;
}

.payment-info h3 {
    color: #333;
    margin-top: 0;
    margin-bottom: 15px;
    font-size: 20px;
}

.bank-details {
    background: white;
    border: 1px solid #dee2e6;
    border-radius: 5px;
    padding: 15px;
    margin-bottom: 15px;
}

.bank-details p {
    margin: 8px 0;
    font-size: 15px;
}

.qr-code-container {
    text-align: center;
    margin: 20px 0;
}

.qr-code-container img {
    max-width: 200px;
    height: auto;
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 10px;
}

.hidden {
    display: none;
}
</style>

<div class="success-container">
    <div class="success-icon">
        <i class="fas fa-check-circle"></i>
    </div>
    
    <h1 class="success-title">Đặt hàng thành công!</h1>
    
    <p class="success-message">
        Cảm ơn bạn đã đặt hàng tại Camera Store. <br>
        Chúng tôi sẽ liên hệ với bạn trong thời gian sớm nhất để xác nhận đơn hàng.
    </p>
    
    <!-- Payment information for bank transfer -->
    @if(isset($order) && $order && $order->payment_method === 'bank')
    <div class="payment-info">
        <h3>Thông tin thanh toán chuyển khoản</h3>
        <div class="bank-details">
            <p><strong>Ngân hàng:</strong> VP Bank - Chi nhánh TP.HCM</p>
            <p><strong>Số tài khoản:</strong> 0942 981 363</p>
            <p><strong>Chủ tài khoản:</strong> Đinh Tiến Đạt</p>
            <p><strong>Số tiền:</strong> {{ number_format($order->final_amount, 0, ',', '.') }}₫</p>
            <p><strong>Nội dung chuyển khoản:</strong> {{ $order->order_code }} - {{ $order->customer_name }}</p>
        </div>
        
        <div class="qr-code-container">
            <p><strong>Quét mã QR để thanh toán:</strong></p>
            <!-- Replace with your actual QR code image path -->
            <img src="{{ asset('source/images/QR/qr.png') }}" alt="QR Code thanh toán">
        </div>      
        <p><i class="fas fa-info-circle"></i> Vui lòng chuyển khoản trong vòng 24 giờ. Sau khi chuyển khoản, đơn hàng sẽ được xử lý.</p>
    </div>
    @endif
    
    <div class="success-actions">
        <a href="{{ route('home') }}" class="btn btn-primary">
            <i class="fas fa-home"></i> Về trang chủ
        </a>
        <a href="{{ route('categories') }}" class="btn btn-secondary">
            <i class="fas fa-shopping-bag"></i> Tiếp tục mua sắm
        </a>
    </div>
</div>
@endsection