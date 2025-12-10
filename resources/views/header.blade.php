    <!-- Header -->
    <link rel="stylesheet" href="{{ asset('/source/assets/css/components/header.css') }}">
    <header class="header">
        <div class="container">
            <div class="header-top">
                <div class="logo">
                    <a class="kyron" href="index.html">Kyron</a>
                </div>
                <nav class="main-nav">
                    <ul>
                        <li><a href="{{ route('home')}}">Trang chủ</a></li>
                        <li class="dropdown">
                            <a href="{{ route('categories')}}">Danh mục</a>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('categories', ['category_id' => 1]) }}">Sony</a></li>
                                <li><a href="{{ route('categories', ['category_id' => 2]) }}">Canon</a></li>
                                <li><a href="{{ route('categories', ['category_id' => 3]) }}">Nikon</a></li>
                                <li><a href="{{ route('categories', ['category_id' => 4]) }}">Fujifilm</a></li>
                                <li><a href="{{ route('categories', ['category_id' => 5]) }}">Leica</a></li>
                                <li><a href="{{ route('categories', ['category_id' => 6]) }}">Lumix</a></li>
                                <li><a href="{{ route('categories', ['category_id' => 7]) }}">Pentax</a></li>
                            </ul>
                        </li>
                        <li><a href="{{ route('about')}}">Về chúng tôi</a></li>
                        <li><a href="{{ route('contact') }}">Liên hệ</a></li>
                    </ul>
                </nav>
                <div class="header-actions">
                    <a href="{{ route('cart') }}" class="cart-icon">
                       <span class="cart"> <i class="fa-solid fa-cart-shopping"></i></span>
                        <span class="cart-count">{{ $cartCount ?? 0 }}</span>
                    </a>
                    <div class="auth-links">
                        @auth
                            <span>Xin chào, {{ Auth::user()->full_name }}</span>
                            @if(Auth::user()->role === 'admin')
                                <span>/</span>
                                <a href="{{ route('admin.dashboard') }}">Admin</a>
                            @endif
                            <span>/</span>
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" style="background: none; border: none; color: inherit; cursor: pointer;">Đăng xuất</button>
                            </form>
                        @else
                            <a href="{{ route('login') }}">Đăng nhập</a>
                            <span>/</span>
                            <a href="{{ route('register') }}">Đăng ký</a>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </header>