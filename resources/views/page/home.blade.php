@extends('master')
@section('content')
<link rel="stylesheet" href="{{ asset('/source/assets/css/page/index.css') }}">

<!-- Hero Slider -->
<!-- Hero Slider -->
<section class="slider-container" id="slider">
    <div class="slider">
        @foreach($slide as $sl)
        <div class="slide">
            <img src="{{ asset('source/images/slide/' . $sl->image) }}"
                alt="">
            <div class="slide-content">
                <h2 class="slide-title">Máy Ảnh Chuyên Nghiệp</h2>
                <p class="slide-description">Khám phá bộ sưu tập máy ảnh mirrorless và DSLR từ các thương hiệu hàng
                    đầu thế giới với công nghệ tiên tiến nhất.</p>
                <a href="products.html" class="btn btn-primary">Khám phá ngay</a>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Slider Controls -->
    <div class="slider-controls">
        <button class="control-btn active" data-slide="0"></button>
        <button class="control-btn" data-slide="1"></button>
        <button class="control-btn" data-slide="2"></button>
        <button class="control-btn" data-slide="3"></button>
        <button class="control-btn" data-slide="4"></button>
    </div>

    <!-- Navigation Buttons -->
    <div class="slider-nav">
        <button class="nav-btn prev-btn">
            <i class="fas fa-chevron-left"></i>
        </button>
        <button class="nav-btn next-btn">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div>
</section>


<!-- Featured Products -->
<section class="featured-products">
    <div class="container">
        <h2 class="section-title">Sản phẩm nổi bật</h2>
        <div class="products-grid">
            @foreach($featuredProducts as $product)
            <div class="product-card" id="product-{{ $product->id }}">
                <div class="product-image">
                    <img src="{{ asset('source/images/products/' . $product->thumbnail) }}" alt="{{ $product->name }}">
                    <div class="product-overlay">
                        <a href="{{ route('detail', $product->id) }}" class="btn btn-secondary">Xem chi tiết</a>
                        <form action="{{ route('cart.add') }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-primary">Thêm vào giỏ</button>
                        </form>
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">
                        <a href="{{ route('detail', $product->id) }}">{{ $product->name }}</a>
                    </h3>
                    <div class="product-price">
                        <span class="current-price">{{ number_format($product->sale_price ?? $product->price, 0, ',', '.') }}₫</span>
                        @if($product->sale_price)
                        <span class="original-price">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                        @endif
                    </div>
                    <p class="product-description">{{ Str::limit($product->description, 100) }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="view-all">
            <a href="{{ route('categories')}}" class="btn btn-outline">Xem tất cả sản phẩm</a>
        </div>
    </div>
</section>

<section class="bestsale-products">
    <div class="container">
        <h2 class="section-title">Sản phẩm bán chạy</h2>
        <div class="products-grid">
            @foreach($bestSaleProducts as $product)
            <div class="product-card" id="product-{{ $product->id }}">
                <div class="product-image">
                    <img src="/source/images/products/{{ $product->thumbnail }}" alt="{{ $product->name }}">
                    <div class="product-overlay">
                        <a href="{{ route('detail', $product->id) }}" class="btn btn-secondary">Xem chi tiết</a>
                        <form action="{{ route('cart.add') }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-primary">Thêm vào giỏ</button>
                        </form>
                    </div>
                </div>
                <div class="product-info">
                    <h3 class="product-name">
                        <a href="{{ route('detail', $product->id) }}">{{ $product->name }}</a>
                    </h3>
                    <div class="product-price">
                        <span class="current-price">{{ number_format($product->sale_price ?? $product->price, 0, ',', '.') }}₫</span>
                        @if($product->sale_price)
                        <span class="original-price">{{ number_format($product->price, 0, ',', '.') }}₫</span>
                        @endif
                    </div>
                    <p class="product-description">{{ Str::limit($product->description, 100) }}</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="view-all">
            <a href="{{ route('categories')}}" class="btn btn-outline">Xem tất cả sản phẩm</a>
        </div>
    </div>
</section>
    <section class="camera-brand-section">
        <div class="container">
            <h2 class="section-title">Lời Khuyên Chọn Máy Ảnh Theo Hãng</h2>
            <p class="section-subtitle">Mỗi hãng máy ảnh có thế mạnh riêng. Tìm hiểu đặc điểm của từng hãng để chọn được máy ảnh phù hợp với phong cách và nhu cầu của bạn.</p>
            
            <!-- Lựa chọn hãng -->
            <div class="brand-selection">
                <div class="brand-card sony-brand active" data-brand="sony">
                    <div class="brand-logo">
                        <img src="{{ asset('source/images/products/sony6.png') }}" alt="">
                    </div>
                    <div class="brand-name">Sony</div>
                </div>
                
                <div class="brand-card fujifilm-brand" data-brand="fujifilm">
                    <div class="brand-logo">
                        <img src="{{ asset('source/images/products/fujifilm8.png') }}" alt="">
                    </div>
                    <div class="brand-name">Fujifilm</div>
                </div>
                
                <div class="brand-card nikon-brand" data-brand="nikon">
                    <div class="brand-logo">
                        <img src="{{ asset('source/images/products/nikon7.png') }}" alt="">
                    </div>
                    <div class="brand-name">Nikon</div>
                </div>
                
                <div class="brand-card canon-brand" data-brand="canon">
                    <div class="brand-logo">
                        <img src="{{ asset('source/images/products/canon7.png') }}" alt="">
                    </div>
                    <div class="brand-name">Canon</div>
                </div>
            </div>
            
            <!-- Thông tin Sony -->
            <div class="brand-info active" id="sony-info">
                <div class="info-header">
                    <div class="info-icon sony-icon">
                        <i class="fas fa-camera"></i>
                    </div>
                    <div>
                        <h3 class="info-title">Sony - Công Nghệ Vượt Trội</h3>
                        <p class="info-tagline">Dẫn đầu công nghệ cảm biến và AF, lựa chọn của các nhiếp ảnh gia hiện đại</p>
                    </div>
                </div>
                
                <div class="features-container">
                    <div class="feature-box">
                        <div class="feature-title">
                            <i class="feature-icon fas fa-microchip"></i>
                            Công Nghệ Cảm Biến
                        </div>
                        <p class="feature-content">Sony sản xuất cảm biến tốt nhất thị trường với độ nhạy sáng cao, dải động rộng và khả năng chụp thiếu sáng vượt trội.</p>
                    </div>
                    
                    <div class="feature-box">
                        <div class="feature-title">
                            <i class="feature-icon fas fa-bolt"></i>
                            Tự Động Lấy Nét (AF)
                        </div>
                        <p class="feature-content">Hệ thống AF nhanh và chính xác bậc nhất, đặc biệt mạnh trong nhận diện mắt và theo dõi đối tượng chuyển động.</p>
                    </div>
                    
                    <div class="feature-box">
                        <div class="feature-title">
                            <i class="feature-icon fas fa-video"></i>
                            Quay Video
                        </div>
                        <p class="feature-content">Máy ảnh Sony có khả năng quay video chuyên nghiệp với tính năng như S-Log, Hybrid Log-Gamma và tốc độ khung hình cao.</p>
                    </div>
                </div>
                
                <div class="suitability">
                    <h4 class="suitability-title">
                        <i class="suitability-icon fas fa-user-check"></i>
                        Phù hợp với
                    </h4>
                    <div class="suitability-list">
                        <div class="suitability-item">
                            <i class="fas fa-video"></i> Người quay video
                        </div>
                        <div class="suitability-item">
                            <i class="fas fa-running"></i> Chụp thể thao, động vật
                        </div>
                        <div class="suitability-item">
                            <i class="fas fa-moon"></i> Chụp thiếu sáng
                        </div>
                        <div class="suitability-item">
                            <i class="fas fa-mobile-alt"></i> Người dùng công nghệ
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Thông tin Fujifilm -->
            <div class="brand-info" id="fujifilm-info">
                <div class="info-header">
                    <div class="info-icon fujifilm-icon">
                        <i class="fas fa-film"></i>
                    </div>
                    <div>
                        <h3 class="info-title">Fujifilm - Phong Cách Cổ Điển</h3>
                        <p class="info-tagline">Màu sắc đặc trưng, thiết kế vintage và trải nghiệm chụp ảnh thú vị</p>
                    </div>
                </div>
                
                <div class="features-container">
                    <div class="feature-box">
                        <div class="feature-title">
                            <i class="feature-icon fas fa-palette"></i>
                            Màu Sắc Đặc Trưng
                        </div>
                        <p class="feature-content">Fujifilm nổi tiếng với các film simulation tái tạo màu sắc phim cổ điển như Provia, Velvia, Astia và Classic Chrome.</p>
                    </div>
                    
                    <div class="feature-box">
                        <div class="feature-title">
                            <i class="feature-icon fas fa-cogs"></i>
                            Trải Nghiệm Cơ học
                        </div>
                        <p class="feature-content">Thiết kế nút vặn cơ học, cảm giác sử dụng như máy phim, mang lại trải nghiệm chụp ảnh thú vị và trực quan.</p>
                    </div>
                    
                    <div class="feature-box">
                        <div class="feature-title">
                            <i class="feature-icon fas fa-compact-disc"></i>
                            Hệ Thống Ống Kính
                        </div>
                        <p class="feature-content">Ống kính chất lượng cao với kích thước nhỏ gọn, đặc biệt mạnh ở các tiêu cự cố định (prime lens).</p>
                    </div>
                </div>
                
                <div class="suitability">
                    <h4 class="suitability-title">
                        <i class="suitability-icon fas fa-user-check"></i>
                        Phù hợp với
                    </h4>
                    <div class="suitability-list">
                        <div class="suitability-item">
                            <i class="fas fa-street-view"></i> Nhiếp ảnh đường phố
                        </div>
                        <div class="suitability-item">
                            <i class="fas fa-portrait"></i> Chụp chân dung
                        </div>
                        <div class="suitability-item">
                            <i class="fas fa-plane"></i> Du lịch, phóng sự
                        </div>
                        <div class="suitability-item">
                            <i class="fas fa-heart"></i> Người yêu phim cổ điển
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Thông tin Nikon -->
            <div class="brand-info" id="nikon-info">
                <div class="info-header">
                    <div class="info-icon nikon-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <div>
                        <h3 class="info-title">Nikon - Chất Lượng Quang Học</h3>
                        <p class="info-tagline">Truyền thống lâu đời, chất lượng ảnh tuyệt vời và hệ thống ống kính phong phú</p>
                    </div>
                </div>
                
                <div class="features-container">
                    <div class="feature-box">
                        <div class="feature-title">
                            <i class="feature-icon fas fa-drafting-compass"></i>
                            Chất Lượng Quang Học
                        </div>
                        <p class="feature-content">Nikon sở hữu công nghệ quang học hàng đầu với các ống kính sắc nét, độ tương phản cao và màu sắc trung thực.</p>
                    </div>
                    
                    <div class="feature-box">
                        <div class="feature-title">
                            <i class="feature-icon fas fa-sun"></i>
                            Dải Động Rộng
                        </div>
                        <p class="feature-content">Cảm biến Nikon có dải động rộng, giữ chi tiết tốt ở vùng sáng và tối, lý tưởng cho phong cảnh và kiến trúc.</p>
                    </div>
                    
                    <div class="feature-box">
                        <div class="feature-title">
                            <i class="feature-icon fas fa-history"></i>
                            Tương Thích Ngược
                        </div>
                        <p class="feature-content">Hệ thống ngàm F-mount duy trì qua nhiều thập kỷ, cho phép sử dụng ống kính cũ trên thân máy mới.</p>
                    </div>
                </div>
                
                <div class="suitability">
                    <h4 class="suitability-title">
                        <i class="suitability-icon fas fa-user-check"></i>
                        Phù hợp với
                    </h4>
                    <div class="suitability-list">
                        <div class="suitability-item">
                            <i class="fas fa-mountain"></i> Nhiếp ảnh phong cảnh
                        </div>
                        <div class="suitability-item">
                            <i class="fas fa-archway"></i> Kiến trúc, nội thất
                        </div>
                        <div class="suitability-item">
                            <i class="fas fa-feather-alt"></i> Chụp chim, động vật hoang dã
                        </div>
                        <div class="suitability-item">
                            <i class="fas fa-campground"></i> Người dùng lâu năm
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Thông tin Canon -->
            <div class="brand-info" id="canon-info">
                <div class="info-header">
                    <div class="info-icon canon-icon">
                        <i class="fas fa-camera-retro"></i>
                    </div>
                    <div>
                        <h3 class="info-title">Canon - Toàn Diện & Phổ Biến</h3>
                        <p class="info-tagline">Thương hiệu phổ biến nhất, hệ sinh thái đầy đủ và màu da người đẹp</p>
                    </div>
                </div>
                
                <div class="features-container">
                    <div class="feature-box">
                        <div class="feature-title">
                            <i class="feature-icon fas fa-users"></i>
                            Hệ Sinh Thái Rộng Lớn
                        </div>
                        <p class="feature-content">Canon có đầy đủ sản phẩm từ entry-level đến chuyên nghiệp, với số lượng ống kính và phụ kiện khổng lồ.</p>
                    </div>
                    
                    <div class="feature-box">
                        <div class="feature-title">
                            <i class="feature-icon fas fa-portrait"></i>
                            Màu Da Người Tự Nhiên
                        </div>
                        <p class="feature-content">Canon nổi tiếng với màu da người đẹp, ấm áp và tự nhiên, rất được ưa chuộng trong chụp chân dung và sự kiện.</p>
                    </div>
                    
                    <div class="feature-box">
                        <div class="feature-title">
                            <i class="feature-icon fas fa-handshake"></i>
                            Dễ Sử Dụng
                        </div>
                        <p class="feature-content">Giao diện người dùng thân thiện, menu trực quan, phù hợp với người mới bắt đầu lẫn nhiếp ảnh gia chuyên nghiệp.</p>
                    </div>
                </div>
                
                <div class="suitability">
                    <h4 class="suitability-title">
                        <i class="suitability-icon fas fa-user-check"></i>
                        Phù hợp với
                    </h4>
                    <div class="suitability-list">
                        <div class="suitability-item">
                            <i class="fas fa-birthday-cake"></i> Chụp sự kiện, cưới hỏi
                        </div>
                        <div class="suitability-item">
                            <i class="fas fa-user-friends"></i> Chụp chân dung
                        </div>
                        <div class="suitability-item">
                            <i class="fas fa-graduation-cap"></i> Người mới bắt đầu
                        </div>
                        <div class="suitability-item">
                            <i class="fas fa-briefcase"></i> Nhiếp ảnh thương mại
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<script>
    // Slider JavaScript
    document.addEventListener('DOMContentLoaded', function() {
        const slider = document.querySelector('.slider');
        const slides = document.querySelectorAll('.slide');
        const prevBtn = document.querySelector('.prev-btn');
        const nextBtn = document.querySelector('.next-btn');
        const controlBtns = document.querySelectorAll('.control-btn');

        let currentSlide = 0;
        const totalSlides = slides.length;
        let slideInterval;

        // Initialize slider
        function initSlider() {
            updateSliderPosition();
            updateControlButtons();
            startAutoSlide();
        }

        // Move to specific slide
        function goToSlide(slideIndex) {
            currentSlide = slideIndex;
            updateSliderPosition();
            updateControlButtons();
            resetAutoSlide();
        }

        // Move to next slide
        function nextSlide() {
            currentSlide = (currentSlide + 1) % totalSlides;
            updateSliderPosition();
            updateControlButtons();
            resetAutoSlide();
        }

        // Move to previous slide
        function prevSlide() {
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            updateSliderPosition();
            updateControlButtons();
            resetAutoSlide();
        }

        // Update slider position
        function updateSliderPosition() {
            slider.style.transform = `translateX(-${currentSlide * 100}%)`;
        }

        // Update control buttons
        function updateControlButtons() {
            controlBtns.forEach((btn, index) => {
                if (index === currentSlide) {
                    btn.classList.add('active');
                } else {
                    btn.classList.remove('active');
                }
            });
        }

        // Start automatic sliding
        function startAutoSlide() {
            slideInterval = setInterval(nextSlide, 10000);
        }

        // Reset automatic sliding timer
        function resetAutoSlide() {
            clearInterval(slideInterval);
            startAutoSlide();
        }

        // Event listeners
        prevBtn.addEventListener('click', prevSlide);
        nextBtn.addEventListener('click', nextSlide);

        controlBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                const slideIndex = parseInt(this.getAttribute('data-slide'));
                goToSlide(slideIndex);
            });
        });

        // Pause auto slide on hover
        const sliderContainer = document.getElementById('slider');
        sliderContainer.addEventListener('mouseenter', () => {
            clearInterval(slideInterval);
        });

        sliderContainer.addEventListener('mouseleave', () => {
            startAutoSlide();
        });

        // Initialize the slider
        initSlider();

        // Removed add to cart JavaScript - now using PHP forms
    });
</script>
  <script>
        document.addEventListener('DOMContentLoaded', function() {
            const brandCards = document.querySelectorAll('.brand-card');
            const brandInfos = document.querySelectorAll('.brand-info');
            
            // Xử lý click chọn hãng
            brandCards.forEach(card => {
                card.addEventListener('click', function() {
                    // Xóa active khỏi tất cả card
                    brandCards.forEach(c => c.classList.remove('active'));
                    
                    // Thêm active cho card được click
                    this.classList.add('active');
                    
                    // Lấy brand được chọn
                    const selectedBrand = this.getAttribute('data-brand');
                    
                    // Ẩn tất cả brand info
                    brandInfos.forEach(info => {
                        info.classList.remove('active');
                    });
                    
                    // Hiển thị brand info tương ứng
                    const targetInfo = document.getElementById(`${selectedBrand}-info`);
                    if (targetInfo) {
                        targetInfo.classList.add('active');
                    }
                });
            });
            
            // Xử lý nút so sánh
            document.querySelector('.compare-action').addEventListener('click', function() {
                const activeCard = document.querySelector('.brand-card.active');
                const activeBrand = activeCard.getAttribute('data-brand');
                
                let brandNames = {
                    'sony': 'Sony',
                    'fujifilm': 'Fujifilm', 
                    'nikon': 'Nikon',
                    'canon': 'Canon'
                };
                
                alert(`Bạn đang xem thông tin về ${brandNames[activeBrand]}. Chúng tôi sẽ hiển thị bảng so sánh chi tiết giữa ${brandNames[activeBrand]} với các hãng khác.`);
                
                // Trong thực tế, bạn có thể hiển thị modal so sánh
                // showComparisonModal(activeBrand);
            });
            
            // Xử lý nút tư vấn
            document.querySelector('.expert-action').addEventListener('click', function() {
                const activeCard = document.querySelector('.brand-card.active');
                const activeBrand = activeCard.getAttribute('data-brand');
                
                let brandNames = {
                    'sony': 'Sony',
                    'fujifilm': 'Fujifilm', 
                    'nikon': 'Nikon',
                    'canon': 'Canon'
                };
                
                alert(`Bạn quan tâm đến máy ảnh ${brandNames[activeBrand]}? Chuyên gia của chúng tôi sẽ liên hệ tư vấn cho bạn trong vòng 30 phút.\n\nVui lòng để lại thông tin liên hệ hoặc gọi hotline: 1800 1234`);
                
                // Trong thực tế, bạn có thể hiển thị form liên hệ
                // showContactForm(activeBrand);
            });
            
            // Thêm hiệu ứng hover cho các brand card
            brandCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    if (!this.classList.contains('active')) {
                        this.style.transform = 'translateY(-8px)';
                        this.style.boxShadow = '0 15px 35px rgba(0, 0, 0, 0.1)';
                    }
                });
                
                card.addEventListener('mouseleave', function() {
                    if (!this.classList.contains('active')) {
                        this.style.transform = 'translateY(0)';
                        this.style.boxShadow = '0 10px 25px rgba(0, 0, 0, 0.05)';
                    }
                });
            });
        });
    </script>
@endsection