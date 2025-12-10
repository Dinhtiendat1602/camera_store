@extends('master')
@section('content')
<link rel="stylesheet" href="{{ asset('source/assets/css/page/product-detail.css') }}">
<link rel="stylesheet" href="{{ asset('source/assets/css/page/product-detail-enhanced.css') }}">
<link rel="stylesheet" href="{{ asset('source/assets/css/notification.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@include('error')
<section class="product-detail">
    <div class="container">
        <!-- Breadcrumb -->

        <!-- Product Gallery and Info -->
        <div class="product-detail-content">
            <div class="product-gallery">
                <!-- Top Section: Main Image -->
                <div class="gallery-top">
                    <div class="main-image">
                        <img id="mainProductImage" src="{{ asset('source/images/products/' . $product->thumbnail) }}" alt="{{ $product->name }}">
                    </div>
                </div>

                <!-- Middle Section: 4 Thumbnail Images -->
                <div class="gallery-thumbnails">
                    <div class="thumbnails-container">
                        <!-- Thumbnail 1 -->
                        <div class="thumbnail-item active" data-image="{{ asset('source/images/products/' . $product->thumbnail) }}">
                            <img src="{{ asset('source/images/products/' . $product->thumbnail) }}" alt="{{ $product->name }}">
                            <div class="thumbnail-overlay"></div>
                        </div>

                        @if($relatedProducts->count() >= 3)
                        @foreach($relatedProducts->take(3) as $index => $related)
                        <!-- Thumbnail {{ $index + 2 }} -->
                        <div class="thumbnail-item" data-image="{{ asset('source/images/products/' . $related->thumbnail) }}">
                            <img src="{{ asset('source/images/products/' . $related->thumbnail) }}" alt="{{ $related->name }}">
                            <div class="thumbnail-overlay"></div>
                        </div>
                        @endforeach
                        @endif
                    </div>
                </div>

                <!-- Bottom Section: Video Player -->
                <div class="gallery-video">
                    <div class="video-container">
                        <!-- Video Player -->
                        <video id="productVideoPlayer" class="video-player"
                            poster="/myapp/source/image/slide/video-poster.jpg">
                            <source src="/myapp/source/image/slide/videoplayback.mp4" type="video/mp4">
                            Trình duyệt của bạn không hỗ trợ video.
                        </video>

                        <!-- Video Controls -->
                        <div class="video-controls">
                            <button id="videoPlayBtn" class="video-play-btn">
                                <i class="fas fa-play"></i>
                            </button>

                            <div class="video-title">Đánh giá Canon EOS R5</div>

                            <div class="video-time">
                                <span id="currentTime">0:00</span> /
                                <span id="duration">0:00</span>
                            </div>

                            <div class="video-volume">
                                <button id="volumeBtn" class="volume-btn">
                                    <i class="fas fa-volume-up"></i>
                                </button>
                                <input type="range" id="volumeSlider" class="volume-slider" min="0" max="1" step="0.1" value="1">
                            </div>

                            <button id="fullscreenBtn" class="video-fullscreen">
                                <i class="fas fa-expand"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- YouTube Video Modal (hidden by default) -->
                <div class="video-modal" id="youtubeVideoModal">
                    <div class="video-modal-content">
                        <button class="close-video-modal" onclick="closeYouTubeModal()">
                            <i class="fas fa-times"></i>
                        </button>
                        <div class="modal-video-container">
                            <iframe id="youtubeVideo" width="560" height="315"
                                src="https://www.youtube.com/embed/dQw4w9WgXcQ?rel=0&controls=1&modestbranding=1"
                                title="Video giới thiệu Canon EOS R5"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>

            <div class="product-info">
                <h1 class="product-title">{{ $product->name }}</h1>
                <div class="product-subtitle">{{ $product->description }}</div>

                <!-- <div class="product-rating">
                        <span class="stars">★★★★★</span>
                        <span class="review-count">(15 đánh giá)</span>
                        <span class="rating-value">4.8/5</span>
                    </div> -->

                <div class="product-price">
                    @if($product->sale_price)
                    <span class="current-price">{{ number_format($product->sale_price) }}₫</span>
                    <span class="original-price">{{ number_format($product->price) }}₫</span>
                    <span class="discount">-{{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%</span>
                    @else
                    <span class="current-price">{{ number_format($product->price) }}₫</span>
                    @endif
                </div>

                <!-- Product Highlights -->
                <div class="product-highlights">
                    <h3><i class="fas fa-bolt"></i> Ưu điểm vượt trội</h3>
                    <div class="highlight-grid">
                        <div class="highlight-item">
                            <i class="fas fa-camera highlight-icon"></i>
                            <span>Cảm biến Full-frame 45MP</span>
                        </div>
                        <div class="highlight-item">
                            <i class="fas fa-video highlight-icon"></i>
                            <span>Quay video 8K RAW 30fps</span>
                        </div>
                        <div class="highlight-item">
                            <i class="fas fa-shield-alt highlight-icon"></i>
                            <span>Ổn định hình ảnh 5-axis 8 stops</span>
                        </div>
                        <div class="highlight-item">
                            <i class="fas fa-bolt highlight-icon"></i>
                            <span>Chụp liên tiếp 20fps (electronic)</span>
                        </div>
                    </div>
                </div>

                <!-- Delivery Information -->
                <div class="delivery-info">
                    <div class="delivery-item">
                        <i class="fas fa-shipping-fast delivery-icon"></i>
                        <span><strong>Giao hàng nhanh:</strong> Nhận hàng trong 2-4 giờ tại TP.HCM</span>
                    </div>
                    <div class="delivery-item">
                        <i class="fas fa-box-open delivery-icon"></i>
                        <span><strong>Miễn phí vận chuyển:</strong> Cho đơn hàng từ 5.000.000₫</span>
                    </div>
                    <div class="delivery-item">
                        <i class="fas fa-sync-alt delivery-icon"></i>
                        <span><strong>Đổi trả dễ dàng:</strong> Trong 7 ngày nếu có lỗi</span>
                    </div>
                </div>

                <!-- Product Actions -->
                <div class="product-actions">
                    <div class="quantity-selector">
                        <label>Số lượng:</label>
                        <div class="quantity-controls">
                            <button class="quantity-btn btn-minus">-</button>
                            <input type="number" id="quantity" value="1" min="1" max="{{ $product->quantity }}">
                            <button class="quantity-btn btn-plus">+</button>
                        </div>
                        <div class="stock-info">Còn {{ $product->quantity }} sản phẩm</div>
                    </div>

                    <div class="action-buttons">
                        @if($product->quantity > 0)
                        @auth
                        <form action="{{ route('cart.add') }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" id="hidden-quantity" value="1">
                            <button type="submit" class="btn btn-add-cart">
                                <i class="fas fa-shopping-cart"></i>
                                Thêm vào giỏ hàng
                            </button>
                        </form>
                        @else
                        <a href="{{ route('login') }}" class="btn btn-add-cart">
                            <i class="fas fa-shopping-cart"></i>
                            Thêm vào giỏ hàng
                        </a>
                        @endauth

                        <a href="{{ route('checkout') }}?product_id={{ $product->id }}&quantity=1" class="btn btn-buy-now">
                            <i class="fas fa-bolt"></i>
                            Mua ngay
                        </a>
                        @else
                        <button class="btn btn-out-of-stock" disabled>
                            <i class="fas fa-times-circle"></i>
                            Hết hàng
                        </button>
                        @endif
                    </div>
                </div>

                <!-- Payment Methods -->
                <!-- <div class="payment-info">
                        <h4>Phương thức thanh toán:</h4>
                        <div class="payment-methods">
                            <span class="payment-method">COD</span>
                            <span class="payment-method">Chuyển khoản</span>
                            <span class="payment-method">Thẻ tín dụng</span>
                        </div>
                    </div> -->

                <!-- Product Meta -->
                <div class="product-meta">
                    @if($product->category)
                    <div class="meta-item">
                        <strong><i class="fas fa-tag"></i> Danh mục:</strong>
                        <span>{{ $product->category->name }}</span>
                    </div>
                    @endif
                    <div class="meta-item">
                        <strong><i class="fas fa-shield-alt"></i> Bảo hành:</strong> 24 tháng chính hãng
                    </div>
                    <div class="meta-item">
                        <strong><i class="fas fa-box"></i> Tình trạng:</strong>
                        <span class="{{ $product->quantity > 0 ? 'in-stock' : 'out-of-stock' }}">
                            {{ $product->quantity > 0 ? 'Còn hàng' : 'Hết hàng' }}
                        </span>
                    </div>
                    <div class="meta-item">
                        <strong><i class="fas fa-barcode"></i> Mã sản phẩm:</strong> {{ $product->id }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="product-tabs">
            <div class="tab-headers">
                <button class="tab-header active" onclick="openTab('description', this)">
                    <i class="fas fa-file-alt"></i> Mô tả chi tiết
                </button>
                <button class="tab-header" onclick="openTab('specifications', this)">
                    <i class="fas fa-microchip"></i> Thông số kỹ thuật
                </button>
                <button class="tab-header" onclick="openTab('reviews', this)">
                    <i class="fas fa-star"></i> Đánh giá ({{ $product->reviews->count() }})
                </button>
            </div>

            <div class="tab-content">
                <!-- Description Tab -->
                <div id="description" class="tab-panel active">
                    <h3>{{ $product->name }} - Mô tả chi tiết</h3>

                    <div class="product-description">
                        {!! $product->description !!}
                    </div>

                    @if($product->category)
                    <div class="category-info">
                        <h4>Danh mục sản phẩm</h4>
                        <p><strong>{{ $product->category->name }}</strong></p>
                        @if($product->category->description)
                        <p>{{ $product->category->description }}</p>
                        @endif
                    </div>
                    @endif
                </div>

                <!-- Specifications Tab -->
                <div id="specifications" class="tab-panel">
                    <div class="product-specs">
                        <h3>Thông Số Kỹ Thuật Chi Tiết - {{ $product->name }}</h3>
                        <div class="specs-grid">
                            @if($product->specifications->count() > 0)
                            @php
                            $specGroups = $product->specifications->groupBy('spec_group');
                            @endphp
                            @foreach($specGroups as $groupName => $specs)
                            <div class="spec-column">
                                <h4>{{ ucfirst($groupName) }}</h4>
                                @foreach($specs as $spec)
                                <div class="spec-item">
                                    <span class="spec-label">{{ $spec->spec_key }}:</span>
                                    <span class="spec-value">{{ $spec->spec_value }}</span>
                                </div>
                                @endforeach
                            </div>
                            @endforeach
                            @else
                            <div class="spec-column">
                                <h4>Thông tin cơ bản</h4>
                                <div class="spec-item">
                                    <span class="spec-label">Tên sản phẩm:</span>
                                    <span class="spec-value">{{ $product->name }}</span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Danh mục:</span>
                                    <span class="spec-value">{{ $product->category->name ?? 'Không xác định' }}</span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Mã sản phẩm:</span>
                                    <span class="spec-value">#{{ $product->id }}</span>
                                </div>
                                <div class="spec-item">
                                    <span class="spec-label">Tình trạng:</span>
                                    <span class="spec-value">{{ $product->quantity > 0 ? 'Còn hàng (' . $product->quantity . ' sản phẩm)' : 'Hết hàng' }}</span>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Reviews Tab -->
                <div id="reviews" class="tab-panel">
                    <h3>Đánh Giá Sản Phẩm - {{ $product->name }}</h3>

                    @if($product->reviews->count() > 0)
                    <div class="review-summary">
                        <div class="rating-overview">
                            <div class="average-rating">
                                <span class="rating-number">{{ number_format($product->reviews->avg('rating'), 1) }}</span>
                                <div class="rating-stars">
                                    @php
                                    $avgRating = round($product->reviews->avg('rating'));
                                    @endphp
                                    {!! str_repeat('★', $avgRating) . str_repeat('☆', 5 - $avgRating) !!}
                                </div>
                                <div class="rating-text">Dựa trên {{ $product->reviews->count() }} đánh giá</div>
                            </div>
                        </div>
                    </div>

                    @foreach($product->reviews as $review)
                    <div class="review-item">
                        <div class="review-header">
                            <div class="review-author">{{ $review->author_name }}</div>
                            <div class="review-date">{{ $review->created_at->format('d/m/Y') }}</div>
                        </div>
                        <div class="review-rating">{{ $review->stars }}</div>
                        <div class="review-title">{{ $review->title }}</div>
                        <p>{{ $review->content }}</p>
                    </div>
                    @endforeach
                    @else
                    <div class="no-reviews">
                        <p>Chưa có đánh giá nào cho sản phẩm này.</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Warranty Information -->
        <div class="product-warranty">
            <h3><i class="fas fa-shield-alt"></i> Chính Sách Bảo Hành & Hỗ Trợ</h3>
            <ul class="warranty-list">
                <li>Bảo hành 24 tháng chính hãng Canon Việt Nam</li>
                <li>1 đổi 1 trong 7 ngày nếu có lỗi kỹ thuật</li>
                <li>Hỗ trợ kỹ thuật 24/7 qua hotline</li>
                <li>Vệ sinh máy miễn phí định kỳ 6 tháng/lần</li>
                <li>Cập nhật firmware miễn phí trọn đời</li>
            </ul>
        </div>

        <!-- Related Products -->
        <div class="related-products">
            <h3 class="related-title">Sản Phẩm Liên Quan</h3>

            <div class="products-grid">
                @foreach($relatedProducts as $relatedProduct)
                <div class="product-card">
                    @if($relatedProduct->sale_price)
                    <div class="product-badge">-{{ round((($relatedProduct->price - $relatedProduct->sale_price) / $relatedProduct->price) * 100) }}%</div>
                    @endif
                    <div class="product-image">
                        <img src="{{ asset('source/images/products/' . $relatedProduct->thumbnail) }}" alt="{{ $relatedProduct->name }}">
                    </div>
                    <div class="product-content">
                        <h4 class="product-name">
                            <a href="{{ route('detail', $relatedProduct->id) }}">{{ $relatedProduct->name }}</a>
                        </h4>

                        <div class="product-price">
                            @if($relatedProduct->sale_price)
                            <span class="current-price">{{ number_format($relatedProduct->sale_price, 0, ',', '.') }}₫</span>
                            <span class="original-price">{{ number_format($relatedProduct->price, 0, ',', '.') }}₫</span>
                            @else
                            <span class="current-price">{{ number_format($relatedProduct->price, 0, ',', '.') }}₫</span>
                            @endif
                        </div>

                        <div class="product-rating-small">
                            <span class="stars-small">★★★★☆</span>
                            <span class="rating-count-small">({{ rand(5, 20) }} đánh giá)</span>
                        </div>

                        <div class="product-action">
                            <a href="{{ route('detail', $relatedProduct->id) }}" class="btn">
                                <i class="fas fa-eye"></i> Xem chi tiết
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

            <div class="view-all">
                <a href="{{ route('categories', ['category_id' => $product->category_id]) }}" class="btn-view-all">
                    <i class="fas fa-arrow-right"></i> Xem tất cả {{ $product->category->name ?? 'sản phẩm' }}
                </a>
            </div>
        </div>
    </div>
</section>

<script>
    // Function to change main image when clicking thumbnails
    function changeMainImage(imageSrc, clickedElement) {
        // Change main image
        document.getElementById('mainProductImage').src = imageSrc;

        // Update active thumbnail
        const thumbnails = document.querySelectorAll('.thumbnail-item');
        thumbnails.forEach(thumb => {
            thumb.classList.remove('active');
        });

        clickedElement.classList.add('active');
    }

    // Add event listeners to thumbnails
    document.addEventListener('DOMContentLoaded', function() {
                const thumbnails = document.querySelectorAll('.thumbnail-item');
                thumbnails.forEach(thumbnail => {
                    thumbnail.addEventListener('click', function() {
                        const imageSrc = this.getAttribute('data-image');
                        changeMainImage(imageSrc, this);
                    });
                });



                    // Video Player Controls
                    const videoPlayer = document.getElementById('productVideoPlayer');
                    const playBtn = document.getElementById('videoPlayBtn');
                    const currentTimeEl = document.getElementById('currentTime');
                    const durationEl = document.getElementById('duration');
                    const volumeBtn = document.getElementById('volumeBtn');
                    const volumeSlider = document.getElementById('volumeSlider');
                    const fullscreenBtn = document.getElementById('fullscreenBtn');

                    // Format time (seconds to MM:SS)
                    function formatTime(seconds) {
                        const mins = Math.floor(seconds / 60);
                        const secs = Math.floor(seconds % 60);
                        return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
                    }

                    // Update time display
                    function updateTime() {
                        currentTimeEl.textContent = formatTime(videoPlayer.currentTime);
                        durationEl.textContent = formatTime(videoPlayer.duration);
                    }

                    // Play/Pause video
                    playBtn.addEventListener('click', () => {
                        if (videoPlayer.paused) {
                            videoPlayer.play();
                            playBtn.innerHTML = '<i class="fas fa-pause"></i>';
                        } else {
                            videoPlayer.pause();
                            playBtn.innerHTML = '<i class="fas fa-play"></i>';
                        }
                    });

                    // Video events
                    videoPlayer.addEventListener('loadedmetadata', () => {
                        updateTime();
                    });

                    videoPlayer.addEventListener('timeupdate', () => {
                        updateTime();
                    });

                    videoPlayer.addEventListener('ended', () => {
                        playBtn.innerHTML = '<i class="fas fa-play"></i>';
                    });

                    // Volume controls
                    volumeSlider.addEventListener('input', (e) => {
                        videoPlayer.volume = e.target.value;
                        updateVolumeIcon();
                    });

                    function updateVolumeIcon() {
                        if (videoPlayer.volume === 0 || videoPlayer.muted) {
                            volumeBtn.innerHTML = '<i class="fas fa-volume-mute"></i>';
                        } else if (videoPlayer.volume < 0.5) {
                            volumeBtn.innerHTML = '<i class="fas fa-volume-down"></i>';
                        } else {
                            volumeBtn.innerHTML = '<i class="fas fa-volume-up"></i>';
                        }
                    }

                    volumeBtn.addEventListener('click', () => {
                        videoPlayer.muted = !videoPlayer.muted;
                        if (videoPlayer.muted) {
                            videoPlayer.volume = 0;
                            volumeSlider.value = 0;
                        } else {
                            videoPlayer.volume = 0.5;
                            volumeSlider.value = 0.5;
                        }
                        updateVolumeIcon();
                    });

                    // Fullscreen
                    fullscreenBtn.addEventListener('click', () => {
                        const videoContainer = document.querySelector('.video-container');

                        if (!document.fullscreenElement) {
                            if (videoContainer.requestFullscreen) {
                                videoContainer.requestFullscreen();
                            } else if (videoContainer.webkitRequestFullscreen) {
                                videoContainer.webkitRequestFullscreen();
                            } else if (videoContainer.msRequestFullscreen) {
                                videoContainer.msRequestFullscreen();
                            }
                            fullscreenBtn.innerHTML = '<i class="fas fa-compress"></i>';
                        } else {
                            if (document.exitFullscreen) {
                                document.exitFullscreen();
                            } else if (document.webkitExitFullscreen) {
                                document.webkitExitFullscreen();
                            } else if (document.msExitFullscreen) {
                                document.msExitFullscreen();
                            }
                            fullscreenBtn.innerHTML = '<i class="fas fa-expand"></i>';
                        }
                    });

                    // Fullscreen change event
                    document.addEventListener('fullscreenchange', () => {
                        if (!document.fullscreenElement) {
                            fullscreenBtn.innerHTML = '<i class="fas fa-expand"></i>';
                        }
                    });

                    // YouTube Modal functions
                    function openYouTubeModal() {
                        const modal = document.getElementById('youtubeVideoModal');
                        modal.classList.add('active');
                        document.body.style.overflow = 'hidden';
                    }

                    function closeYouTubeModal() {
                        const modal = document.getElementById('youtubeVideoModal');
                        const iframe = document.getElementById('youtubeVideo');
                        modal.classList.remove('active');
                        document.body.style.overflow = 'auto';

                        // Stop video
                        iframe.src = iframe.src;
                    }

                    // Close modal when clicking outside
                    document.getElementById('youtubeVideoModal').addEventListener('click', function(e) {
                        if (e.target === this) {
                            closeYouTubeModal();
                        }
                    });

                    // Close modal with Escape key
                    document.addEventListener('keydown', function(e) {
                        if (e.key === 'Escape') {
                            closeYouTubeModal();
                        }
                    });

                    // Tab switching function
                    window.openTab = function(tabName, element) {
                        // Hide all tab panels
                        const tabPanels = document.querySelectorAll('.tab-panel');
                        tabPanels.forEach(panel => {
                            panel.classList.remove('active');
                        });

                        // Remove active class from all tab headers
                        const tabHeaders = document.querySelectorAll('.tab-header');
                        tabHeaders.forEach(header => {
                            header.classList.remove('active');
                        });

                        // Show selected tab panel
                        const selectedPanel = document.getElementById(tabName);
                        if (selectedPanel) {
                            selectedPanel.classList.add('active');
                        }

                        // Add active class to clicked tab header
                        if (element) {
                            element.classList.add('active');
                        }
                        
                        console.log('Tab switched to:', tabName);
                    }

                    // Quantity controls
                    const minusBtn = document.querySelector('.btn-minus');
                    const plusBtn = document.querySelector('.btn-plus');
                    const quantityInput = document.getElementById('quantity');
                    const hiddenQuantity = document.getElementById('hidden-quantity');

                    function updateHiddenQuantity() {
                        if (hiddenQuantity && quantityInput) {
                            hiddenQuantity.value = quantityInput.value;
                        }
                    }

                    if (minusBtn) {
                        minusBtn.addEventListener('click', function() {
                            if (quantityInput && parseInt(quantityInput.value) > 1) {
                                quantityInput.value = parseInt(quantityInput.value) - 1;
                                updateHiddenQuantity();
                            }
                        });
                    }

                    if (plusBtn) {
                        plusBtn.addEventListener('click', function() {
                            if (quantityInput) {
                                const maxQuantity = parseInt(quantityInput.getAttribute('max')) || 10;
                                if (parseInt(quantityInput.value) < maxQuantity) {
                                    quantityInput.value = parseInt(quantityInput.value) + 1;
                                    updateHiddenQuantity();
                                }
                            }
                        });
                    }

                    // Update hidden quantity when input changes directly
                    if (quantityInput) {
                        quantityInput.addEventListener('input', updateHiddenQuantity);
                    };
                });
</script>
@endsection