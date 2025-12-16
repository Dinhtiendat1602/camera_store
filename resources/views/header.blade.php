    <!-- Header -->
    <link rel="stylesheet" href="{{ asset('/source/assets/css/components/header.css') }}">
    <header class="header">

        <!-- Navigation -->
        <nav class="header-nav">
            <div class="container">
                <div class="nav-content">
                    <ul class="main-nav">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link">
                                <i class="fas fa-home"></i>
                                <span>Trang chủ</span>
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a href="{{ route('categories') }}" class="nav-link">
                                <i class="fas fa-th-large"></i>
                                <span>Danh mục sản phẩm</span>
                                <i class="fas fa-chevron-down"></i>
                            </a>
                            <div class="mega-menu">
                                <div class="mega-menu-content">
                                    <div class="menu-column">
                                        <h4>Thương hiệu nổi bật</h4>
                                        <ul>
                                            <li><a href="{{ route('categories', ['category_id' => 1]) }}"><i class="fab fa-sony"></i> Sony</a></li>
                                            <li><a href="{{ route('categories', ['category_id' => 2]) }}"><i class="fas fa-camera"></i> Canon</a></li>
                                            <li><a href="{{ route('categories', ['category_id' => 3]) }}"><i class="fas fa-camera-retro"></i> Nikon</a></li>
                                            <li><a href="{{ route('categories', ['category_id' => 4]) }}"><i class="fas fa-film"></i> Fujifilm</a></li>
                                        </ul>
                                    </div>
                                    <div class="menu-column">
                                        <h4>Thương hiệu khác</h4>
                                        <ul>
                                            <li><a href="{{ route('categories', ['category_id' => 5]) }}"><i class="fas fa-camera"></i> Leica</a></li>
                                            <li><a href="{{ route('categories', ['category_id' => 6]) }}"><i class="fas fa-video"></i> Lumix</a></li>
                                            <li><a href="{{ route('categories', ['category_id' => 7]) }}"><i class="fas fa-aperture"></i> Pentax</a></li>
                                        </ul>
                                    </div>
                                    <!-- <div class="menu-column">
                                        <h4>Phụ kiện</h4>
                                        <ul>
                                            <li><a href="#"><i class="fas fa-circle"></i> Ống kính</a></li>
                                            <li><a href="#"><i class="fas fa-battery-full"></i> Pin & Sạc</a></li>
                                            <li><a href="#"><i class="fas fa-sd-card"></i> Thẻ nhớ</a></li>
                                            <li><a href="#"><i class="fas fa-camera-retro"></i> Túi đựng</a></li>
                                        </ul>
                                    </div> -->
                                </div>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('about') }}" class="nav-link">
                                <i class="fas fa-info-circle"></i>
                                <span>Về chúng tôi</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('contact') }}" class="nav-link">
                                <i class="fas fa-phone"></i>
                                <span>Liên hệ</span>
                            </a>
                        </li>
                    </ul>
                    
                    <!-- Right Side Items -->
                    <div class="nav-right">
                        <!-- Search Bar -->
                        <div class="search-container">
                            <form class="search-form" method="GET" action="{{ route('categories') }}">
                                <div class="search-input-group">
                                    <input type="text" name="search" placeholder="Tìm kiếm..." class="search-input" value="{{ request('search') }}">
                                    <button type="submit" class="search-btn">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        
                        <!-- Cart -->
                        <a href="{{ route('cart') }}" class="nav-action cart-item">
                            <i class="fas fa-shopping-cart"></i>
                            @if(($cartCount ?? 0) > 0)
                                <span class="cart-badge">{{ $cartCount }}</span>
                            @endif
                        </a>

                        <!-- User Account -->
                        <div class="nav-action user-item">
                            @auth
                                <div class="user-dropdown">
                                    <div class="user-trigger">
                                        <i class="fas fa-user-circle"></i>
                                        <i class="fas fa-chevron-down dropdown-arrow"></i>
                                    </div>
                                    <div class="user-menu">
                                        <a href="{{ route('profile') }}" class="user-menu-item">
                                            <i class="fas fa-user"></i> Thông tin cá nhân
                                        </a>
                                        <a href="{{ route('profile.orders') }}" class="user-menu-item">
                                            <i class="fas fa-box"></i> Đơn hàng của tôi
                                        </a>
                                        @if(Auth::user()->role === 'admin')
                                            <a href="{{ route('admin.dashboard') }}" class="user-menu-item">
                                                <i class="fas fa-cog"></i> Quản trị
                                            </a>
                                        @endif
                                        <div class="menu-divider"></div>
                                        <form action="{{ route('logout') }}" method="POST">
                                            @csrf
                                            <button type="submit" class="user-menu-item logout-btn">
                                                <i class="fas fa-sign-out-alt"></i> Đăng xuất
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('login') }}" class="login-link">
                                    <i class="fas fa-sign-in-alt"></i>
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>