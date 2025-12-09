@extends('master')
@section('content')
    <link rel="stylesheet" href="{{ asset('source/assets/css/page/contact.css') }}">
    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h2>Liên hệ với chúng tôi</h2>
            <p>Chúng tôi luôn sẵn sàng hỗ trợ bạn 24/7. Liên hệ ngay để được tư vấn về sản phẩm camera tốt nhất.</p>
            <div class="breadcrumb">
                <a href="#">Trang chủ</a>
                <span>/</span>
                <span>Liên hệ</span>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="container">
        <div class="contact-container">
            <!-- Contact Info -->
            <div class="contact-info">
                <h3>Thông tin liên hệ</h3>
                <p>Camera Store tự hào là đơn vị phân phối camera chính hãng hàng đầu Việt Nam. Chúng tôi cam kết mang đến sản phẩm chất lượng và dịch vụ tốt nhất.</p>
                
                <div class="info-cards">
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="info-content">
                            <h4>Địa chỉ cửa hàng</h4>
                            <p>123 Đường ABC, Phường XYZ, Quận 1</p>
                            <p>Thành phố Hồ Chí Minh, Việt Nam</p>
                        </div>
                    </div>
                    
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="info-content">
                            <h4>Số điện thoại</h4>
                            <p>Hotline: <strong>0123 456 789</strong></p>
                            <p>Hỗ trợ: 0987 654 321</p>
                            <p>Giờ làm việc: 8:00 - 20:00 (T2 - CN)</p>
                        </div>
                    </div>
                    
                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="info-content">
                            <h4>Email liên hệ</h4>
                            <p>Hỗ trợ: <strong>support@camerastore.vn</strong></p>
                            <p>Kinh doanh: sales@camerastore.vn</p>
                            <p>Đối tác: partner@camerastore.vn</p>
                        </div>
                    </div>
                </div>
                
                <h4 style="margin-bottom: 20px;">Kết nối với chúng tôi</h4>
                <div class="social-links">
                    <a href="#" class="social-link">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="#" class="social-link">
                        <i class="fab fa-tiktok"></i>
                    </a>
                </div>
            </div>
            
            <!-- Contact Form -->
            <div class="contact-form-container">
                <h3>Gửi tin nhắn</h3>
                <p>Điền thông tin bên dưới, chúng tôi sẽ liên hệ lại với bạn trong thời gian sớm nhất.</p>
                
                <form id="contactForm">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">Họ và tên *</label>
                            <input type="text" class="form-control" id="fullName" required>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Số điện thoại *</label>
                            <input type="tel" class="form-control" id="phone" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Email *</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Chủ đề *</label>
                        <select class="form-select" id="subject" required>
                            <option value="">Chọn chủ đề liên hệ</option>
                            <option value="support">Hỗ trợ kỹ thuật</option>
                            <option value="product">Tư vấn sản phẩm</option>
                            <option value="warranty">Bảo hành, sửa chữa</option>
                            <option value="cooperation">Hợp tác kinh doanh</option>
                            <option value="other">Vấn đề khác</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Tin nhắn *</label>
                        <textarea class="form-control form-textarea" id="message" required></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Sản phẩm quan tâm (nếu có)</label>
                        <input type="text" class="form-control" id="productInterest" placeholder="VD: Camera Sony A7 III, Ống kính Canon 50mm">
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 16px;">
                        <i class="fas fa-paper-plane"></i>
                        Gửi tin nhắn
                    </button>
                </form>
            </div>
        </div>
        
        <!-- Map Section -->
        <section class="map-section">
            <div class="section-title">
                <h2>Địa chỉ cửa hàng</h2>
                <p>Ghé thăm cửa hàng của chúng tôi để trải nghiệm trực tiếp các sản phẩm camera chất lượng cao</p>
            </div>
            
            <div class="map-container">
                <div class="map-placeholder">
                    <i class="fas fa-map-marked-alt"></i>
                    <h3>Camera Store HCM</h3>
                    <p>123 Đường ABC, Phường XYZ, Quận 1, TP.HCM</p>
                    <p style="margin-top: 10px; font-size: 14px;">(Bản đồ tích hợp Google Maps)</p>
                </div>
            </div>
        </section>
        
        <!-- FAQ Section -->
        <section class="faq-section">
            <div class="section-title">
                <h2>Câu hỏi thường gặp</h2>
                <p>Giải đáp những thắc mắc phổ biến của khách hàng về camera và dịch vụ của chúng tôi</p>
            </div>
            
            <div class="faq-container">
                <div class="faq-item active">
                    <div class="faq-question">
                        <h4>Chính sách bảo hành sản phẩm như thế nào?</h4>
                        <div class="faq-icon">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                    <div class="faq-answer active">
                        <p>Tất cả sản phẩm tại Camera Store đều được bảo hành chính hãng từ 12-36 tháng tùy sản phẩm. Chúng tôi hỗ trợ 1 đổi 1 trong 7 ngày đầu nếu có lỗi từ nhà sản xuất. Các trung tâm bảo hành của chúng tôi có mặt tại Hà Nội, TP.HCM và Đà Nẵng.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h4>Tôi có thể mua trả góp không?</h4>
                        <div class="faq-icon">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                    <div class="faq-answer">
                        <p>Camera Store hỗ trợ mua trả góp 0% lãi suất qua thẻ tín dụng của các ngân hàng đối tác. Bạn có thể trả trước 30-50% và chia nhỏ số tiền còn lại trong 6-12 tháng. Vui lòng liên hệ hotline để được tư vấn chi tiết về chương trình trả góp.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h4>Thời gian giao hàng là bao lâu?</h4>
                        <div class="faq-icon">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                    <div class="faq-answer">
                        <p>Đối với khu vực nội thành TP.HCM và Hà Nội: Giao hàng trong 2-4 giờ làm việc. Các tỉnh thành khác: 1-3 ngày làm việc tùy khu vực. Miễn phí giao hàng toàn quốc cho đơn hàng từ 3 triệu đồng. Đối với sản phẩm đặt hàng (pre-order), thời gian giao hàng sẽ được thông báo cụ thể khi đặt hàng.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h4>Tôi có được tư vấn kỹ thuật miễn phí không?</h4>
                        <div class="faq-icon">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                    <div class="faq-answer">
                        <p>Chúng tôi có đội ngũ chuyên gia camera với hơn 10 năm kinh nghiệm sẵn sàng tư vấn miễn phí 24/7. Bạn có thể liên hệ qua hotline, chat trực tuyến trên website hoặc đến trực tiếp cửa hàng để được tư vấn chọn sản phẩm phù hợp với nhu cầu và ngân sách.</p>
                    </div>
                </div>
                
                <div class="faq-item">
                    <div class="faq-question">
                        <h4>Có lớp học nhiếp ảnh cho người mới bắt đầu không?</h4>
                        <div class="faq-icon">
                            <i class="fas fa-chevron-down"></i>
                        </div>
                    </div>
                    <div class="faq-answer">
                        <p>Camera Store thường xuyên tổ chức các workshop và lớp học nhiếp ảnh miễn phí cho khách hàng. Các khóa học cơ bản dành cho người mới bắt đầu được tổ chức hàng tháng. Đăng ký tham gia qua website hoặc fanpage để nhận thông báo về lịch học sớm nhất.</p>
                    </div>
                </div>
            </div>
        </section>
    </div>

@endsection