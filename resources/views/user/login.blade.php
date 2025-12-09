@extends('master')
@section('content')
    <link rel="stylesheet" href="{{ asset('/source/assets/css/users/login.css') }}">

<div class="body_login">
    <div class="login-container">
        <div class="login-header">
            <h2>Đăng Nhập</h2>
            <p>Sử dụng email và mật khẩu của bạn để đăng nhập</p>
        </div>

       <h5 style="color: red;"> @include('error')</h5>
        <form action="/login" method="POST">
            @csrf
            <div class="form-group-login">
                <label for="email">Địa chỉ Email</label>
                <input type="email" id="email" name="email" class="form-control-login" placeholder="nhap@email.com" required>
            </div>

            <div class="form-group-login">
                <label for="password">Mật khẩu</label>
                <input type="password" id="password" name="password" class="form-control-login" placeholder="********"
                    required>
            </div>

            <div class="form-options-login">
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember" style="font-weight: normal; color: #ffffff;">Ghi nhớ tôi</label>
                </div>
                <a href="/forgot-password">Quên mật khẩu?</a>
            </div>

            <button type="submit" class="btn-login">ĐĂNG NHẬP</button>

            <div class="register-link">
                Bạn chưa có tài khoản? <a href="{{route('register')}}" class="register-link}">Đăng ký ngay</a>
            </div>
        </form>
    </div>

</div>

@endsection