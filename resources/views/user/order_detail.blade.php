@extends('master')

@section('title', 'Chi tiết đơn hàng #' . $order->order_code)

@section('custom_css')
<link rel="stylesheet" href="{{ asset('source/assets/css/users/profile.css') }}">
@endsection

@section('content')
<div class="container profile-container">
    <div class="row">
        <div class="col-md-3 profile-sidebar">
            <div class="card">
                <!-- <div class="card-header">
                    <h5>Tài khoản</h5>
                </div> -->
                <div class="card-body">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile') }}">Thông tin tài khoản</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="{{ route('profile.orders') }}">Đơn hàng của tôi</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9 profile-content">
            <div class="card">
                <div class="card-header">
                    <h5>Chi tiết đơn hàng #{{ $order->order_code }}</h5>
                </div>
                <div class="card-body">
                    <div class="row order-detail-section">
                        <div class="col-md-6">
                            <h6><strong>Thông tin khách hàng</strong></h6>
                            <p><strong>Họ tên:</strong> {{ $order->customer_name }}</p>
                            <p><strong>Email:</strong> {{ $order->customer_email }}</p>
                            <p><strong>Số điện thoại:</strong> {{ $order->customer_phone }}</p>
                            <p><strong>Địa chỉ:</strong> {{ $order->customer_address }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6><strong>Thông tin đơn hàng</strong></h6>
                            <p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                            <p><strong>Trạng thái:</strong> 
                                @if($order->status == 'pending')
                                    <span class="badge badge-status bg-warning">Chờ xử lý</span>
                                @elseif($order->status == 'confirmed')
                                    <span class="badge badge-status bg-info">Đã xác nhận</span>
                                @elseif($order->status == 'shipping')
                                    <span class="badge badge-status bg-primary">Đang giao</span>
                                @elseif($order->status == 'completed')
                                    <span class="badge badge-status bg-success">Hoàn thành</span>
                                @elseif($order->status == 'cancelled')
                                    <span class="badge badge-status bg-danger">Đã hủy</span>
                                @endif
                            </p>
                            <p><strong>Phương thức thanh toán:</strong> 
                                @if($order->payment_method == 'cod')
                                    Thanh toán khi nhận hàng
                                @elseif($order->payment_method == 'bank_transfer')
                                    Chuyển khoản ngân hàng
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="order-detail-section">
                        <h6><strong>Sản phẩm</strong></h6>
                        <div class="table-responsive">
                            <table class="table table-bordered order-products-table">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Giá</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->orderItems as $item)
                                        <tr>
                                            <td>{{ $item->product->name }}</td>
                                            <td>{{ number_format($item->price) }}₫</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ number_format($item->total) }}₫</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 offset-md-6">
                            <table class="table table-borderless order-summary-table">
                                <tr>
                                    <td><strong>Tạm tính:</strong></td>
                                    <td class="text-end">{{ number_format($order->total_amount) }}₫</td>
                                </tr>
                                <tr>
                                    <td><strong>Phí vận chuyển:</strong></td>
                                    <td class="text-end">{{ number_format($order->shipping_fee) }}₫</td>
                                </tr>
                                @if($order->discount_amount > 0)
                                    <tr>
                                        <td><strong>Giảm giá:</strong></td>
                                        <td class="text-end">-{{ number_format($order->discount_amount) }}₫</td>
                                    </tr>
                                @endif
                                <tr>
                                    <td><strong>Tổng cộng:</strong></td>
                                    <td class="text-end"><strong>{{ number_format($order->final_amount) }}₫</strong></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection