@extends('master')
@section('content')
<link rel="stylesheet" href="{{ asset('/source/assets/css/users/register.css') }}">

<div class="body_rigester">
    <div class="register-container">
        <div class="register-header">
            <h2>Tạo Tài Khoản</h2>
            <p>Vui lòng điền thông tin để đăng ký</p>
        </div>
        @include('error')
        <form action="register" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Họ và Tên</label>
                <input type="text" id="name" name="full_name" class="form-control" placeholder="Nguyễn Văn A" required>
            </div>

            <div class="form-group">
                <label for="email">Địa chỉ Email</label>
                <input type="email" id="email" name="email" class="form-control" placeholder="nhap@email.com" required>
            </div>

            <div class="form-group">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" class="form-control" placeholder="********"
                    required>
            </div>

            <div class="form-group">
                <label for="password_confirmation">Xác nhận mật khẩu</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                    placeholder="Nhập lại mật khẩu trên" required>
            </div>

            <button type="submit" class="btn-register">ĐĂNG KÝ NGAY</button>

            <div class="login-link">
                Bạn đã có tài khoản? <a href="{{ route('login')}}">Đăng nhập tại đây</a>
            </div>
        </form>
    </div>
</div>
@endsection