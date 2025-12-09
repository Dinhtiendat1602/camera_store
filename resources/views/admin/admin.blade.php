
<link rel="stylesheet" href="{{ asset('source/assets/css/page/admin.css') }}">
        <div class="container">
        <!-- Header -->
        <header class="header">
            <div class="logo">
                <i class="fas fa-camera"></i>
                <div>
                    <h1>Camera<span>Store</span></h1>
                    <p>Hệ thống quản lý nâng cao</p>
                </div>
            </div>
            <div class="admin-info">
                <div class="admin-avatar">AD</div>
                <div class="admin-details">
                    <h3>Admin System</h3>
                    <p>Quản trị viên</p>
                </div>
            </div>
        </header>

        <!-- Main Layout -->
        <div class="admin-layout">
            <!-- Sidebar -->
            <nav class="sidebar">
                <div class="nav-section">
                    <div class="nav-title">Tổng quan</div>
                    <a class="nav-item active" data-target="dashboard">
                        <i class="fas fa-th-large"></i>
                        <span>Dashboard</span>
                    </a>
                    <a class="nav-item" data-target="statistics">
                        <i class="fas fa-chart-bar"></i>
                        <span>Thống kê</span>
                    </a>
                </div>
                
                <div class="nav-section">
                    <div class="nav-title">Quản lý Sản phẩm</div>
                    <a class="nav-item" data-target="products">
                        <i class="fas fa-box"></i>
                        <span>Tất cả sản phẩm</span>
                        <span class="badge" id="productCountBadge">70</span>
                    </a>
                    <a class="nav-item" data-target="categories">
                        <i class="fas fa-tags"></i>
                        <span>Danh mục</span>
                    </a>
                    <a class="nav-item" data-target="add-product">
                        <i class="fas fa-plus-circle"></i>
                        <span>Thêm sản phẩm</span>
                    </a>
                </div>
                
                <div class="nav-section">
                    <div class="nav-title">Quản lý Đơn hàng</div>
                    <a class="nav-item" data-target="orders">
                        <i class="fas fa-shopping-cart"></i>
                        <span>Đơn hàng</span>
                        <span class="badge" id="orderCountBadge">6</span>
                    </a>
                    <a class="nav-item" data-target="checkouts">
                        <i class="fas fa-credit-card"></i>
                        <span>Thanh toán</span>
                    </a>
                </div>
                
                <div class="nav-section">
                    <div class="nav-title">Quản lý Người dùng</div>
                    <a class="nav-item" data-target="users">
                        <i class="fas fa-users"></i>
                        <span>Người dùng</span>
                    </a>
                    <a class="nav-item" data-target="reviews">
                        <i class="fas fa-star"></i>
                        <span>Đánh giá</span>
                    </a>
                </div>
                
                <div class="nav-section">
                    <div class="nav-title">Hệ thống</div>
                    <a class="nav-item" data-target="settings">
                        <i class="fas fa-cog"></i>
                        <span>Cài đặt</span>
                    </a>
                    <a class="nav-item" data-target="database">
                        <i class="fas fa-database"></i>
                        <span>Database</span>
                    </a>
                </div>
            </nav>

            <!-- Content Areas -->
            
            <!-- Dashboard -->
            <section id="dashboard" class="content-area active">
                <div class="dashboard-grid">
                    <div class="dashboard-card">
                        <div class="card-icon icon-1">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="card-info">
                            <h3 id="totalProducts">70</h3>
                            <p>Tổng sản phẩm</p>
                        </div>
                    </div>
                    
                    <div class="dashboard-card">
                        <div class="card-icon icon-2">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="card-info">
                            <h3 id="totalOrders">6</h3>
                            <p>Đơn hàng</p>
                        </div>
                    </div>
                    
                    <div class="dashboard-card">
                        <div class="card-icon icon-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="card-info">
                            <h3 id="totalUsers">5</h3>
                            <p>Người dùng</p>
                        </div>
                    </div>
                    
                    <div class="dashboard-card">
                        <div class="card-icon icon-4">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="card-info">
                            <h3 id="totalRevenue">321.5M</h3>
                            <p>Doanh thu</p>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-clock"></i>
                            Đơn hàng gần đây
                        </h2>
                        <button class="btn btn-primary" onclick="showContent('orders')">
                            <i class="fas fa-eye"></i>
                            Xem tất cả
                        </button>
                    </div>
                    
                    <div class="table-container">
                        <table class="data-table" id="recentOrdersTable">
                            <thead>
                                <tr>
                                    <th>Mã đơn</th>
                                    <th>Khách hàng</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="recentOrdersBody">
                                <!-- Data will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Top Products -->
                <div class="section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-chart-line"></i>
                            Sản phẩm bán chạy
                        </h2>
                        <button class="btn btn-primary" onclick="showContent('products')">
                            <i class="fas fa-eye"></i>
                            Xem tất cả
                        </button>
                    </div>
                    
                    <div class="table-container">
                        <table class="data-table" id="topProductsTable">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Thương hiệu</th>
                                    <th>Đã bán</th>
                                    <th>Tồn kho</th>
                                    <th>Giá</th>
                                    <th>Doanh thu</th>
                                </tr>
                            </thead>
                            <tbody id="topProductsBody">
                                <!-- Data will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Products Management -->
            <section id="products" class="content-area">
                <div class="section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-box"></i>
                            Quản lý Sản phẩm
                        </h2>
                        <div class="btn-group">
                            <button class="btn btn-success" onclick="showContent('add-product')">
                                <i class="fas fa-plus"></i>
                                Thêm sản phẩm
                            </button>
                            <button class="btn btn-primary" id="refreshProducts">
                                <i class="fas fa-sync-alt"></i>
                                Làm mới
                            </button>
                        </div>
                    </div>
                    
                    <div class="table-container">
                        <table class="data-table" id="productsTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Sản phẩm</th>
                                    <th>Thương hiệu</th>
                                    <th>Giá</th>
                                    <th>Tồn kho</th>
                                    <th>Đã bán</th>
                                    <th>Trạng thái</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="productsTableBody">
                                <!-- Data will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Add/Edit Product -->
            <section id="add-product" class="content-area">
                <div class="section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-plus-circle"></i>
                            Thêm sản phẩm mới
                        </h2>
                        <button class="btn btn-secondary" onclick="showContent('products')">
                            <i class="fas fa-arrow-left"></i>
                            Quay lại
                        </button>
                    </div>
                    
                    <form id="productForm">
                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">Tên sản phẩm *</label>
                                <input type="text" class="form-control" id="productName" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Thương hiệu *</label>
                                <select class="form-select" id="productCategory" required>
                                    <option value="">Chọn thương hiệu</option>
                                    <!-- Categories will be loaded here -->
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Giá bán (VNĐ) *</label>
                                <input type="number" class="form-control" id="productPrice" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Giá khuyến mãi (VNĐ)</label>
                                <input type="number" class="form-control" id="productSalePrice">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Số lượng tồn kho *</label>
                                <input type="number" class="form-control" id="productQuantity" required>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Hình ảnh chính (URL)</label>
                                <input type="text" class="form-control" id="productThumbnail">
                            </div>
                            
                            <div class="form-group full-width">
                                <label class="form-label">Mô tả sản phẩm</label>
                                <textarea class="form-control form-textarea" id="productDescription"></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Sản phẩm nổi bật</label>
                                <select class="form-select" id="productFeatured">
                                    <option value="0">Không</option>
                                    <option value="1">Có</option>
                                </select>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">Trạng thái</label>
                                <select class="form-select" id="productStatus">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Product Specs -->
                        <div class="tabs">
                            <button type="button" class="tab active" data-tab="specs">Thông số kỹ thuật</button>
                            <button type="button" class="tab" data-tab="images">Hình ảnh</button>
                            <button type="button" class="tab" data-tab="policies">Chính sách</button>
                        </div>
                        
                        <div class="tab-content active" id="specs-tab">
                            <div id="specsContainer">
                                <div class="spec-row form-grid">
                                    <div class="form-group">
                                        <label class="form-label">Tên thông số</label>
                                        <input type="text" class="form-control spec-name" placeholder="VD: Sensor">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label">Giá trị</label>
                                        <input type="text" class="form-control spec-value" placeholder="VD: APS-C">
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-primary" id="addSpecBtn">
                                <i class="fas fa-plus"></i> Thêm thông số
                            </button>
                        </div>
                        
                        <div class="tab-content" id="images-tab">
                            <div id="imagesContainer">
                                <div class="images-grid">
                                    <!-- Images will be added here -->
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-primary" id="addImageBtn">
                                <i class="fas fa-plus"></i> Thêm hình ảnh
                            </button>
                        </div>
                        
                        <div class="tab-content" id="policies-tab">
                            <div id="policiesContainer">
                                <div class="policy-row form-grid">
                                    <div class="form-group">
                                        <label class="form-label">Loại chính sách</label>
                                        <input type="text" class="form-control policy-type" placeholder="VD: Warranty">
                                    </div>
                                    <div class="form-group full-width">
                                        <label class="form-label">Nội dung</label>
                                        <textarea class="form-control policy-content" placeholder="VD: Bảo hành 12 tháng"></textarea>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-primary" id="addPolicyBtn">
                                <i class="fas fa-plus"></i> Thêm chính sách
                            </button>
                        </div>
                        
                        <div class="form-actions">
                            <button type="button" class="btn btn-secondary" onclick="showContent('products')">Hủy</button>
                            <button type="submit" class="btn btn-primary" id="saveProductBtn">Lưu sản phẩm</button>
                        </div>
                    </form>
                </div>
            </section>

            <!-- Categories Management -->
            <section id="categories" class="content-area">
                <div class="section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-tags"></i>
                            Quản lý Thương hiệu
                        </h2>
                        <button class="btn btn-success" id="addCategoryBtn">
                            <i class="fas fa-plus"></i>
                            Thêm thương hiệu
                        </button>
                    </div>
                    
                    <div class="table-container">
                        <table class="data-table" id="categoriesTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Tên thương hiệu</th>
                                    <th>Loại</th>
                                    <th>Số sản phẩm</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="categoriesTableBody">
                                <!-- Data will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Orders Management -->
            <section id="orders" class="content-area">
                <div class="section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-shopping-cart"></i>
                            Quản lý Đơn hàng
                        </h2>
                        <div class="btn-group">
                            <button class="btn btn-primary" id="exportOrdersBtn">
                                <i class="fas fa-download"></i>
                                Xuất đơn hàng
                            </button>
                        </div>
                    </div>
                    
                    <div class="table-container">
                        <table class="data-table" id="ordersTable">
                            <thead>
                                <tr>
                                    <th>Mã đơn</th>
                                    <th>Khách hàng</th>
                                    <th>Số sản phẩm</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="ordersTableBody">
                                <!-- Data will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Users Management -->
            <section id="users" class="content-area">
                <div class="section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-users"></i>
                            Quản lý Người dùng
                        </h2>
                        <button class="btn btn-success" id="addUserBtn">
                            <i class="fas fa-user-plus"></i>
                            Thêm người dùng
                        </button>
                    </div>
                    
                    <div class="table-container">
                        <table class="data-table" id="usersTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Họ tên</th>
                                    <th>Email</th>
                                    <th>Số điện thoại</th>
                                    <th>Vai trò</th>
                                    <th>Ngày tạo</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="usersTableBody">
                                <!-- Data will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Statistics -->
            <section id="statistics" class="content-area">
                <div class="section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-chart-bar"></i>
                            Thống kê & Báo cáo
                        </h2>
                        <div class="btn-group">
                            <select class="form-select" style="width: auto;" id="timeRange">
                                <option value="week">Tuần này</option>
                                <option value="month">Tháng này</option>
                                <option value="quarter">Quý này</option>
                                <option value="year">Năm nay</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="charts-container">
                        <div class="chart-card">
                            <h3 class="chart-title">Doanh thu theo tháng</h3>
                            <canvas id="revenueChart" height="250"></canvas>
                        </div>
                        
                        <div class="chart-card">
                            <h3 class="chart-title">Sản phẩm bán chạy</h3>
                            <canvas id="topProductsChart" height="250"></canvas>
                        </div>
                        
                        <div class="chart-card">
                            <h3 class="chart-title">Thương hiệu phổ biến</h3>
                            <canvas id="brandsChart" height="250"></canvas>
                        </div>
                        
                        <div class="chart-card">
                            <h3 class="chart-title">Trạng thái đơn hàng</h3>
                            <canvas id="ordersChart" height="250"></canvas>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Database Management -->
            <section id="database" class="content-area">
                <div class="section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-database"></i>
                            Quản lý Database
                        </h2>
                        <button class="btn btn-success" id="backupDbBtn">
                            <i class="fas fa-save"></i>
                            Sao lưu DB
                        </button>
                    </div>
                    
                    <div class="table-container">
                        <table class="data-table" id="databaseTables">
                            <thead>
                                <tr>
                                    <th>Tên bảng</th>
                                    <th>Số bản ghi</th>
                                    <th>Kích thước</th>
                                    <th>Cập nhật cuối</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody id="databaseTablesBody">
                                <!-- Data will be loaded here -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <!-- Settings -->
            <section id="settings" class="content-area">
                <div class="section">
                    <div class="section-header">
                        <h2 class="section-title">
                            <i class="fas fa-cog"></i>
                            Cài đặt hệ thống
                        </h2>
                    </div>
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label class="form-label">Tên cửa hàng</label>
                            <input type="text" class="form-control" id="storeName" value="Camera Store">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Email liên hệ</label>
                            <input type="email" class="form-control" id="storeEmail" value="contact@camerastore.vn">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="storePhone" value="0123 456 789">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Địa chỉ</label>
                            <input type="text" class="form-control" id="storeAddress" value="123 Đường ABC, TP.HCM">
                        </div>
                        
                        <div class="form-group full-width">
                            <label class="form-label">Mô tả cửa hàng</label>
                            <textarea class="form-control form-textarea" id="storeDescription">Chuyên cung cấp các sản phẩm camera chính hãng chất lượng cao</textarea>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Đơn vị tiền tệ</label>
                            <select class="form-select" id="storeCurrency">
                                <option value="VND" selected>VNĐ (Việt Nam Đồng)</option>
                                <option value="USD">USD (Đô la Mỹ)</option>
                                <option value="EUR">EUR (Euro)</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Múi giờ</label>
                            <select class="form-select" id="storeTimezone">
                                <option value="Asia/Ho_Chi_Minh" selected>Asia/Ho_Chi_Minh (GMT+7)</option>
                                <option value="UTC">UTC</option>
                                <option value="America/New_York">America/New_York (GMT-5)</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Số sản phẩm mỗi trang</label>
                            <input type="number" class="form-control" id="itemsPerPage" value="20">
                        </div>
                        
                        <div class="form-group">
                            <label class="form-label">Cho phép đăng ký</label>
                            <select class="form-select" id="allowRegistration">
                                <option value="1" selected>Có</option>
                                <option value="0">Không</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary">Đặt lại</button>
                        <button type="button" class="btn btn-primary" id="saveSettingsBtn">Lưu cài đặt</button>
                    </div>
                </div>
            </section>
        </div>
    </div>

    <!-- Modal for View Details -->
    <div class="modal" id="detailModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="detailModalTitle">Chi tiết</h3>
                <button class="modal-close" id="closeDetailModal">&times;</button>
            </div>
            <div class="modal-body" id="detailModalBody">
                <!-- Content will be loaded here -->
            </div>
        </div>
    </div>

    <!-- Modal for Delete Confirmation -->
    <div class="modal" id="deleteModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Xác nhận xóa</h3>
                <button class="modal-close" id="closeDeleteModal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="delete-confirmation">
                    <div class="delete-icon">
                        <i class="fas fa-exclamation-triangle"></i>
                    </div>
                    <div class="delete-text">
                        <h3 id="deleteItemName">Xóa mục này?</h3>
                        <p id="deleteItemDesc">Bạn có chắc chắn muốn xóa? Hành động này không thể hoàn tác.</p>
                    </div>
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" id="cancelDeleteBtn">Hủy</button>
                        <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Xóa</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

