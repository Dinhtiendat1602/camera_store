@extends('master')

@section('title', 'Thông tin tài khoản')

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
                            <a class="nav-link active" href="{{ route('profile') }}">Thông tin tài khoản</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile.orders') }}">Đơn hàng của tôi</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-9 profile-content">
            <div class="card">
                <div class="card-header">
                    <h5>Thông tin tài khoản</h5>
                </div>
                <div class="card-body profile-info">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Họ tên:</strong></label>
                                <p>{{ $user->full_name }}</p>
                            </div>
                            <div class="form-group">
                                <label><strong>Email:</strong></label>
                                <p>{{ $user->email }}</p>
                            </div>
                            <div class="form-group">
                                <label><strong>Số điện thoại:</strong></label>
                                <p>{{ $user->phone ?? 'Chưa cập nhật' }}</p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><strong>Địa chỉ:</strong></label>
                                <p>{{ $user->address ?? 'Chưa cập nhật' }}</p>
                            </div>
                            <div class="form-group">
                                <label><strong>Ngày đăng ký:</strong></label>
                                <p>{{ $user->created_at->format('d/m/Y') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection