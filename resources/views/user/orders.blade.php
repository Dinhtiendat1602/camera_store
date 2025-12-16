@extends('master')

@section('title', 'Đơn hàng của tôi')

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
                    <h5>Đơn hàng của tôi</h5>
                </div>
                <div class="card-body">
                    @if($orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered orders-table">
                                <thead>
                                    <tr>
                                        <th>Mã đơn hàng</th>
                                        <th>Ngày đặt</th>
                                        <th>Tổng tiền</th>
                                        <th>Trạng thái</th>
                                        <th>Chi tiết</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{ $order->order_code }}</td>
                                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ number_format($order->final_amount) }}₫</td>
                                            <td>
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
                                            </td>
                                            <td>
                                                <a href="{{ route('profile.order.detail', $order->id) }}" class="btn btn-primary btn-sm">Xem</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="alert alert-info text-center">
                            <p>Bạn chưa có đơn hàng nào.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection