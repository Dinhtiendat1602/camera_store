    <!-- Footer -->
         <link rel="stylesheet" href="{{ asset('/source/assets/css/components/footer.css') }}">

    <footer class="kyron-footer">
        <div class="footer-wave"></div>
        <div class="footer-container">
            <div class="footer-top">
                <div class="footer-brand">
                    <div class="footer-logo">
                        <i class="fas fa-camera logo-icon"></i>
                        <span class="logo-text">KYRON</span>
                    </div>
                    <p class="brand-tagline">Chuyên cung cấp máy ảnh, ống kính và phụ kiện chính hãng chất lượng cao với dịch vụ tư vấn chuyên nghiệp.</p>
                    <div class="social-links">
                        <a href="#" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
                        <a href="#" class="social-icon"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
                
                <div class="footer-links-container">
                    <div class="footer-column">
                        <h3>Sản phẩm</h3>
                        <ul>
                            <li><a href="#"><i class="fas fa-chevron-right"></i> Máy ảnh DSLR</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right"></i> Máy ảnh Mirrorless</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right"></i> Ống kính</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right"></i> Máy quay phim</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right"></i> Phụ kiện</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-column">
                        <h3>Thông tin</h3>
                        <ul>
                            <li><a href="#"><i class="fas fa-chevron-right"></i> Về Kyron</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right"></i> Tin tức & Blog</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right"></i> Hướng dẫn mua hàng</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right"></i> Chính sách bảo hành</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right"></i> Ưu đãi</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-column">
                        <h3>Hỗ trợ</h3>
                        <ul>
                            <li><a href="#"><i class="fas fa-chevron-right"></i> Trung tâm hỗ trợ</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right"></i> Hỏi đáp</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right"></i> Hướng dẫn sử dụng</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right"></i> Tải driver & firmware</a></li>
                            <li><a href="#"><i class="fas fa-chevron-right"></i> Liên hệ</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-column">
                        <h3>Liên hệ</h3>
                        <ul class="footer-contact">
                            <li><i class="fas fa-map-marker-alt"></i> 123 Nguyễn Văn Linh, Quận 7, TP.HCM</li>
                            <li><i class="fas fa-phone"></i> Hotline: 1800 1234</li>
                            <li><i class="fas fa-envelope"></i> support@kyroncamera.vn</li>
                            <li><i class="fas fa-clock"></i> 8:00 - 21:00 (T2 - CN)</li>
                        </ul>
                        
                        <div class="newsletter-form">
                            <p class="newsletter-text">Đăng ký nhận tin khuyến mãi</p>
                            <div class="form-group-footer">
                                <input type="email" placeholder="Email của bạn">
                                <button type="submit"><i class="fas fa-paper-plane"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <div class="copyright">
                    &copy; 2023 <a href="#">Kyron Camera</a>. Tất cả các quyền được bảo lưu.
                </div>
                
                <div class="footer-links-bottom">
                    <a href="#">Điều khoản sử dụng</a>
                    <a href="#">Chính sách bảo mật</a>
                    <a href="#">Chính sách cookie</a>
                </div>
                
                <div class="payment-methods">
                    <i class="fab fa-cc-visa" title="Visa"></i>
                    <i class="fab fa-cc-mastercard" title="Mastercard"></i>
                    <i class="fab fa-cc-paypal" title="Paypal"></i>
                    <i class="fas fa-qrcode" title="QR Code"></i>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Hiệu ứng cho newsletter form
        document.querySelector('.form-group button').addEventListener('click', function() {
            const emailInput = document.querySelector('.form-group input');
            if(emailInput.value) {
                alert('Cảm ơn bạn đã đăng ký nhận tin khuyến mãi từ Kyron!');
                emailInput.value = '';
            } else {
                alert('Vui lòng nhập email của bạn.');
                emailInput.focus();
            }
        });
        
        // Thêm hiệu ứng hover cho các icon thanh toán
        document.querySelectorAll('.payment-methods i').forEach(icon => {
            icon.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px)';
            });
            
            icon.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    </script>