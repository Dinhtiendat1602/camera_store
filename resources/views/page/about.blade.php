@extends('master')
@section('content')
    <link rel="stylesheet" href="{{ asset('source/assets/css/page/about.css') }}">
    <div class="about-wrapper">
        <header>
            <h1>🌟 Giới Thiệu Chi Tiết Về Chúng Tôi</h1>
            <p>Hành trình xây dựng thương hiệu, cam kết chất lượng và những cột mốc phát triển của chúng tôi.</p>
        </header>

        <div class="about-container">

            <section class="section-padding story-section section-background">
                <h2>Câu Chuyện Thương Hiệu</h2>
                
                <h3>🔥 Khởi Nguồn Từ Đam Mê và Thách Thức</h3>
                <p>Nền tảng của chúng tôi không chỉ là một ý tưởng, mà là kết quả của sự thất vọng. Chúng tôi nhận thấy thị trường thiếu vắng một đơn vị thực sự đặt **chất lượng sản phẩm và sự minh bạch** lên hàng đầu. Được thành lập vào cuối năm 2018 bởi một nhóm kỹ sư trẻ đầy nhiệt huyết, chúng tôi đã bắt đầu hành trình với nguồn vốn khiêm tốn nhưng một tầm nhìn lớn: thay đổi cách người tiêu dùng trải nghiệm dịch vụ.</p>
                
                <p>Trong những ngày đầu, khó khăn chồng chất từ việc tìm kiếm nguồn cung ứng đáng tin cậy, tối ưu hóa quy trình vận hành phức tạp, cho đến việc xây dựng lòng tin từ những khách hàng đầu tiên. Tuy nhiên, chính những thách thức đó đã tôi luyện chúng tôi, buộc chúng tôi phải sáng tạo và giữ vững cam kết về **dịch vụ khách hàng 24/7**.</p>

                <h3>💡 Triết Lý Kinh Doanh: Đơn Giản & Hiệu Quả</h3>
                <p>Triết lý của chúng tôi xoay quanh hai yếu tố: **Đơn giản hóa trải nghiệm** và **Tối đa hóa giá trị**. Chúng tôi loại bỏ mọi rào cản phức tạp trong quá trình mua sắm và tập trung vào việc mang lại giá trị thực sự, vượt xa kỳ vọng của khách hàng. Chúng tôi tin rằng, thành công của chúng tôi được xây dựng trên sự hài lòng và lòng trung thành của cộng đồng khách hàng.</p>
            </section>
            
            <section class="section-padding milestones">
                <h2>🗺️ Các Cột Mốc Lịch Sử</h2>
                
                <div class="timeline">
                    <div class="milestone-item">
                        <div class="milestone-year">2018</div>
                        <p>Thành lập công ty, ra mắt phiên bản Beta sản phẩm đầu tiên.</p>
                    </div>
                    <div class="milestone-item">
                        <div class="milestone-year">2020</div>
                        <p>Đạt mốc 10.000 khách hàng hoạt động thường xuyên, mở rộng kho bãi tại TP. HCM.</p>
                    </div>
                    <div class="milestone-item">
                        <div class="milestone-year">2022</div>
                        <p>Hoàn thành vòng gọi vốn Series A, nâng cấp hạ tầng công nghệ lõi (Core Tech Stack).</p>
                    </div>
                    <div class="milestone-item">
                        <div class="milestone-year">2024</div>
                        <p>Mở rộng sang thị trường quốc tế đầu tiên (Thái Lan) và ra mắt ứng dụng di động.</p>
                    </div>
                </div>
            </section>

            <section class="section-padding goals-commitments">
                
                <div class="goals-list">
                    <h3>🎯 Mục Tiêu Phát Triển Dài Hạn</h3>
                    <div class="feature-item">
                        <i class="icon">📈</i>
                        <div>
                            <strong>Tăng trưởng Bền vững:</strong> Đạt tốc độ tăng trưởng doanh thu 30% mỗi năm trong 5 năm tới.
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="icon">🌍</i>
                        <div>
                            <strong>Mở rộng Khu vực:</strong> Xâm nhập ít nhất 5 thị trường Đông Nam Á vào năm 2028.
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="icon">🥇</i>
                        <div>
                            <strong>Dẫn đầu Công nghệ:</strong> Áp dụng Trí tuệ nhân tạo (AI) vào 80% quy trình hỗ trợ khách hàng.
                        </div>
                    </div>
                </div>

                <div class="commitments-list">
                    <h3>🔒 Cam Kết Chất Lượng Tuyệt Đối</h3>
                    <div class="feature-item">
                        <i class="icon">✅</i>
                        <div>
                            <strong>Bảo hành Toàn diện:</strong> Chính sách đổi trả 30 ngày không cần lý do.
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="icon">⏱️</i>
                        <div>
                            <strong>Giao hàng Tốc độ:</strong> Đảm bảo giao hàng trong 48 giờ đối với khu vực thành phố lớn.
                        </div>
                    </div>
                    <div class="feature-item">
                        <i class="icon">🛡️</i>
                        <div>
                            <strong>Bảo mật Thông tin:</strong> Cam kết bảo vệ dữ liệu cá nhân khách hàng ở mức cao nhất, tuân thủ tiêu chuẩn quốc tế.
                        </div>
                    </div>
                </div>

            </section>
            
            <section class="section-padding cta-section">
                <h3>Bạn đã sẵn sàng trở thành đối tác của chúng tôi chưa?</h3>
                <p>Khám phá bộ sưu tập sản phẩm của chúng tôi hoặc liên hệ để nhận tư vấn chuyên sâu.</p>
                <a href="#link-to-products" class="cta-button">KHÁM PHÁ NGAY</a>
                <a href="#link-to-contact" class="cta-button" style="background-color: #007bff; margin-left: 20px;">TƯ VẤN</a>
            </section>

        </div>
    </div>

@endsection