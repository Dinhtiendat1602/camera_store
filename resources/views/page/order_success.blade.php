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