-- ====================================================
-- CAMERA STORE DATABASE - COMPLETE SCHEMA (FIXED)
-- ====================================================

-- 1. Khởi tạo Database
CREATE DATABASE IF NOT EXISTS camera_store
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE camera_store;

-- ====================================================
-- NHÓM 1: DANH MỤC (vừa là Categories vừa là Brands)
-- ====================================================
CREATE TABLE slides (
    id INT PRIMARY KEY AUTO_INCREMENT,
    image VARCHAR(255) NOT NULL
);

CREATE TABLE categories (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL, -- Ví dụ: Canon, Nikon, Sony, Ống kính, Phụ kiện
    type VARCHAR(50) DEFAULT 'brand', -- 'brand' hoặc 'category'
    thumbnail VARCHAR(255), -- Ảnh đại diện cho thương hiệu/danh mục
    description TEXT,
    parent_id INT DEFAULT NULL, -- Cho phép danh mục con (nếu cần)
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (parent_id) REFERENCES categories(id) ON DELETE SET NULL,
    INDEX idx_category_type (type),
    INDEX idx_parent_id (parent_id)
);

-- ====================================================
-- NHÓM 2: SẢN PHẨM & CHI TIẾT (Phục vụ hiển thị Tab)
-- ====================================================

-- 3. Bảng Sản phẩm chính
CREATE TABLE products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    category_id INT NOT NULL, -- Thay cho brand_id và category_id cũ
    name VARCHAR(255) NOT NULL,
    price DECIMAL(15,2) NOT NULL,
    sale_price DECIMAL(15,2) DEFAULT NULL, -- Giá khuyến mãi (nếu có)
    quantity INT DEFAULT 0,
    thumbnail VARCHAR(255),
    description LONGTEXT, -- Nội dung HTML dài cho Tab "Mô tả sản phẩm"
    view_count INT DEFAULT 0, -- Đếm lượt xem
    is_featured BOOLEAN DEFAULT FALSE, -- Đánh dấu sản phẩm nổi bật
    total_sold INT DEFAULT 0, -- Tổng số lượng đã bán
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE,
    INDEX idx_product_category (category_id),
    INDEX idx_product_featured (is_featured),
    INDEX idx_product_sold (total_sold DESC),
    INDEX idx_product_price (price)
);

-- 4. Bảng Hình ảnh sản phẩm
CREATE TABLE product_images (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    image_url VARCHAR(255) NOT NULL,
    is_primary BOOLEAN DEFAULT FALSE,
    sort_order INT DEFAULT 0,
    
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    INDEX idx_product_images (product_id, sort_order)
);

-- 5. Bảng Thông số kỹ thuật (Phục vụ Tab "Thông số kỹ thuật")
CREATE TABLE product_specs (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    spec_name VARCHAR(100) NOT NULL,
    spec_value VARCHAR(255) NOT NULL,
    sort_order INT DEFAULT 0,
    
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    INDEX idx_product_specs (product_id, sort_order)
);

-- 6. Bảng Chính sách (Phục vụ Tab "Chính sách")
CREATE TABLE product_policies (
    id INT PRIMARY KEY AUTO_INCREMENT,
    product_id INT NOT NULL,
    policy_type VARCHAR(100) NOT NULL, -- Tiêu đề chính sách
    policy_content TEXT NOT NULL,      -- Nội dung chi tiết
    sort_order INT DEFAULT 0,
    
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    INDEX idx_product_policies (product_id, sort_order)
);

-- ====================================================
-- NHÓM 3: NGƯỜI DÙNG & TƯƠNG TÁC
-- ====================================================

-- 7. Bảng Người dùng (Khách hàng)
CREATE TABLE users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    full_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    role VARCHAR(20) DEFAULT 'customer', -- customer hoặc admin
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_user_email (email)
);

-- 8. Bảng Đánh giá (Phục vụ Tab "Đánh giá")
CREATE TABLE reviews (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    rating TINYINT NOT NULL CHECK (rating BETWEEN 1 AND 5), -- 1 đến 5 sao
    comment TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    INDEX idx_reviews_product (product_id, created_at DESC),
    INDEX idx_reviews_user (user_id)
);

-- ====================================================
-- NHÓM 4: GIAO DỊCH (ĐƠN HÀNG)
-- ====================================================

-- Bảng orders (đồng bộ INT với users)
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_code VARCHAR(50) UNIQUE,
    user_id INT NULL,
    customer_name VARCHAR(255),
    customer_email VARCHAR(255),
    customer_phone VARCHAR(20),
    customer_address TEXT,
    total_amount DECIMAL(12,2),
    shipping_fee DECIMAL(12,2) DEFAULT 0,
    discount_amount DECIMAL(12,2) DEFAULT 0,
    final_amount DECIMAL(12,2),
    payment_method ENUM('cod','bank','momo','vnpay'),
    payment_status ENUM('unpaid','paid','failed') DEFAULT 'unpaid',
    status ENUM(
        'pending',
        'confirmed',
        'shipping',
        'completed',
        'cancelled'
    ) DEFAULT 'pending',
    note TEXT NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    CONSTRAINT fk_orders_users FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Bảng order_items
CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT,
    product_id INT,
    quantity INT,
    price DECIMAL(12,2),
    total DECIMAL(12,2),
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

-- ====================================================
-- NHÓM 6: HỖ TRỢ & BỔ SUNG
-- ====================================================

-- 12. Bảng Giỏ hàng (Cart)
CREATE TABLE carts (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_cart_item (user_id, product_id),
    INDEX idx_cart_user (user_id)
);

-- 13. Bảng Yêu thích (Wishlist)
CREATE TABLE wishlists (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    added_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_wishlist_item (user_id, product_id),
    INDEX idx_wishlist_user (user_id)
);

-- 14. Bảng Khuyến mãi (Promotions)
CREATE TABLE promotions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(50) UNIQUE NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    discount_type VARCHAR(20) DEFAULT 'percentage', -- percentage or fixed
    discount_value DECIMAL(10,2) NOT NULL,
    min_order_amount DECIMAL(15,2) DEFAULT 0,
    max_discount_amount DECIMAL(15,2) DEFAULT NULL,
    start_date DATETIME NOT NULL,
    end_date DATETIME NOT NULL, -- ĐÃ SỬA LỖI: Bỏ "NOTETIME" thừa
    usage_limit INT DEFAULT NULL,
    used_count INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    INDEX idx_promotion_code (code),
    INDEX idx_promotion_active (is_active, start_date, end_date)
);
-- ==============================================================

USE camera_store;

SET FOREIGN_KEY_CHECKS=0;

-- SLIDES
INSERT INTO slides (image) VALUES
('slide2.png'),
('slide3.png'),
('slide4.png'),
('slide1.png'),
('slide5.png');

-- CATEGORIES
INSERT INTO categories (id, name, type, thumbnail, description, parent_id, created_at) VALUES
(1, 'Sony', 'brand', 'sony.png', 'Thương hiệu Sony', NULL, NOW()),
(2, 'Canon', 'brand', 'canon.png', 'Thương hiệu Canon', NULL, NOW()),
(3, 'Nikon', 'brand', 'nikon.png', 'Thương hiệu Nikon', NULL, NOW()),
(4, 'Fujifilm', 'brand', 'fujifilm.png', 'Thương hiệu Fujifilm', NULL, NOW()),
(5, 'Leica', 'brand', 'leica.png', 'Thương hiệu Leica', NULL, NOW()),
(6, 'Lumix', 'brand', 'lumix.png', 'Thương hiệu Lumix', NULL, NOW()),
(7, 'Pentax', 'brand', 'pentax.png', 'Thương hiệu Pentax', NULL, NOW());

-- PRODUCTS
INSERT INTO products (id, category_id, name, price, sale_price, quantity, thumbnail, description, view_count, is_featured, total_sold, created_at, updated_at) VALUES
-- SONY (category 1) products 1..10
(1,1,'Sony A6000', 18000000, NULL, 60, 'sony1.png', 'Sony A6000 - body compact', 120, 0, 180, NOW(), NOW()),
(2,1,'Sony A6100', 22000000, NULL, 45, 'sony2.png', 'Sony A6100 - great for beginners', 95, 0, 140, NOW(), NOW()),
(3,1,'Sony A6400', 28000000, NULL, 40, 'sony3.png', 'Sony A6400 - autofocus', 110, 1, 160, NOW(), NOW()),
(4,1,'Sony A6600', 35000000, NULL, 32, 'sony4.png', 'Sony A6600 - IBIS', 130, 1, 130, NOW(), NOW()),
(5,1,'Sony A7 II', 32000000, NULL, 28, 'sony5.png', 'Sony A7 II - full-frame', 80, 0, 120, NOW(), NOW()),
(6,1,'Sony A7 III', 45000000, NULL, 22, 'sony6.png', 'Sony A7 III - popular hybrid', 210, 1, 200, NOW(), NOW()),
(7,1,'Sony A7 IV', 52000000, NULL, 20, 'sony7.png', 'Sony A7 IV - modern features', 170, 1, 180, NOW(), NOW()),
(8,1,'Sony A7S III', 78000000, NULL, 12, 'sony8.png', 'Sony A7S III - video oriented', 90, 1, 90, NOW(), NOW()),
(9,1,'Sony A9', 90000000, NULL, 10, 'sony9.png', 'Sony A9 - pro sports', 60, 1, 70, NOW(), NOW()),
(10,1,'Sony FX3', 100000000, NULL, 6, 'sony10.png', 'Sony FX3 - cinema camera', 40, 1, 50, NOW(), NOW()),

-- CANON (category 2) products 11..20
(11,2,'Canon EOS R1', 72000000, NULL, 20, 'canon1.png', 'Canon flagship mirrorless', 140, 1, 120, NOW(), NOW()),
(12,2,'Canon EOS R2', 45000000, NULL, 30, 'canon2.png', 'Canon R2 - fast AF', 80, 0, 60, NOW(), NOW()),
(13,2,'Canon EOS R3', 65000000, NULL, 15, 'canon3.png', 'Canon R3 - sport pro', 100, 1, 90, NOW(), NOW()),
(14,2,'Canon EOS R4', 32000000, NULL, 40, 'canon4.png', 'Canon R4 - allrounder', 75, 0, 70, NOW(), NOW()),
(15,2,'Canon EOS R5', 58000000, NULL, 25, 'canon5.png', 'Canon R5 - high res', 180, 1, 150, NOW(), NOW()),
(16,2,'Canon EOS R6', 36000000, NULL, 35, 'canon6.png', 'Canon R6 - low light', 130, 0, 110, NOW(), NOW()),
(17,2,'Canon EOS R7', 29000000, NULL, 50, 'canon7.png', 'Canon R7 - crop sensor', 95, 0, 80, NOW(), NOW()),
(18,2,'Canon EOS R8', 41000000, NULL, 20, 'canon8.png', 'Canon R8 - versatile', 160, 1, 140, NOW(), NOW()),
(19,2,'Canon EOS R9', 51000000, NULL, 18, 'canon9.png', 'Canon R9 - pro level', 70, 0, 60, NOW(), NOW()),
(20,2,'Canon EOS R10', 27000000, NULL, 60, 'canon10.png', 'Canon R10 - entry pro', 100, 0, 95, NOW(), NOW()),

-- NIKON (category 3) products 21..30
(21,3,'Nikon Z30', 19000000, NULL, 50, 'nikon1.png', 'Nikon Z30 - vlogging', 140, 0, 120, NOW(), NOW()),
(22,3,'Nikon Z50', 24000000, NULL, 40, 'nikon2.png', 'Nikon Z50 - mirrorless', 120, 0, 110, NOW(), NOW()),
(23,3,'Nikon Z5', 33000000, NULL, 32, 'nikon3.png', 'Nikon Z5 - fullframe entry', 150, 1, 140, NOW(), NOW()),
(24,3,'Nikon Z6', 46000000, NULL, 26, 'nikon4.png', 'Nikon Z6 - hybrid', 130, 1, 155, NOW(), NOW()),
(25,3,'Nikon Z7', 70000000, NULL, 14, 'nikon5.png', 'Nikon Z7 - high res', 95, 1, 90, NOW(), NOW()),
(26,3,'Nikon Z8', 92000000, NULL, 8, 'nikon6.png', 'Nikon Z8 - pro', 60, 1, 60, NOW(), NOW()),
(27,3,'Nikon D7500', 26000000, NULL, 44, 'nikon7.png', 'Nikon D7500 - DSLR', 145, 0, 135, NOW(), NOW()),
(28,3,'Nikon D850', 68000000, NULL, 12, 'nikon8.png', 'Nikon D850 - studio', 120, 1, 110, NOW(), NOW()),
(29,3,'Nikon Coolpix P1000', 25000000, NULL, 30, 'nikon9.png', 'Nikon P1000 - superzoom', 75, 0, 70, NOW(), NOW()),
(30,3,'Nikon Z9', 120000000, NULL, 6, 'nikon10.png', 'Nikon Z9 - flagship', 50, 1, 40, NOW(), NOW()),

-- FUJIFILM (category 4) products 31..40
(31,4,'Fujifilm X-T1', 28000000, NULL, 40, 'fujifilm1.png', 'Fujifilm X-T1 - classic', 90, 0, 75, NOW(), NOW()),
(32,4,'Fujifilm X-T2', 31000000, NULL, 35, 'fujifilm2.png', 'Fujifilm X-T2 - retro style', 100, 0, 88, NOW(), NOW()),
(33,4,'Fujifilm X-T3', 36000000, NULL, 30, 'fujifilm3.png', 'Fujifilm X-T3 - strong AF', 160, 1, 140, NOW(), NOW()),
(34,4,'Fujifilm X-T4', 42000000, NULL, 22, 'fujifilm4.png', 'Fujifilm X-T4 - IBIS', 150, 1, 120, NOW(), NOW()),
(35,4,'Fujifilm X-T5', 48000000, NULL, 18, 'fujifilm5.png', 'Fujifilm X-T5 - new gen', 170, 1, 160, NOW(), NOW()),
(36,4,'Fujifilm X-S10', 26000000, NULL, 50, 'fujifilm6.png', 'Fujifilm X-S10 - compact', 110, 0, 100, NOW(), NOW()),
(37,4,'Fujifilm X-E4', 23000000, NULL, 55, 'fujifilm7.png', 'Fujifilm X-E4 - slim body', 95, 0, 85, NOW(), NOW()),
(38,4,'Fujifilm GFX50', 90000000, NULL, 10, 'fujifilm8.png', 'Fujifilm GFX50 - medium format', 65, 1, 60, NOW(), NOW()),
(39,4,'Fujifilm GFX100', 150000000, NULL, 5, 'fujifilm9.png', 'Fujifilm GFX100 - high megapixel', 30, 1, 40, NOW(), NOW()),
(40,4,'Fujifilm Instax Pro', 12000000, NULL, 80, 'fujifilm10.png', 'Fujifilm instant camera', 200, 0, 200, NOW(), NOW()),

-- LEICA (category 5) products 41..50
(41,5,'Leica Q1', 95000000, NULL, 10, 'leica1.png', 'Leica Q1 - premium', 40, 1, 30, NOW(), NOW()),
(42,5,'Leica Q2', 120000000, NULL, 8, 'leica2.png', 'Leica Q2 - iconic', 50, 1, 40, NOW(), NOW()),
(43,5,'Leica M10', 180000000, NULL, 6, 'leica3.png', 'Leica M10 - rangefinder', 15, 1, 20, NOW(), NOW()),
(44,5,'Leica M11', 210000000, NULL, 5, 'leica4.png', 'Leica M11 - digital rangefinder', 18, 1, 15, NOW(), NOW()),
(45,5,'Leica SL2', 160000000, NULL, 7, 'leica5.png', 'Leica SL2 - pro mirrorless', 30, 0, 25, NOW(), NOW()),
(46,5,'Leica CL', 80000000, NULL, 15, 'leica6.png', 'Leica CL - compact', 70, 0, 60, NOW(), NOW()),
(47,5,'Leica TL2', 70000000, NULL, 18, 'leica7.png', 'Leica TL2 - stylish', 60, 0, 55, NOW(), NOW()),
(48,5,'Leica D-Lux', 55000000, NULL, 25, 'leica8.png', 'Leica D-Lux - versatile compact', 85, 0, 90, NOW(), NOW()),
(49,5,'Leica V-Lux', 65000000, NULL, 20, 'leica9.png', 'Leica V-Lux - zoom compact', 75, 0, 80, NOW(), NOW()),
(50,5,'Leica S3', 350000000, NULL, 3, 'leica10.png', 'Leica S3 - medium format pro', 10, 1, 5, NOW(), NOW()),

-- LUMIX (category 6) products 51..60
(51,6,'Lumix GH5', 36000000, NULL, 30, 'lumix1.png', 'Lumix GH5 - video favorite', 140, 0, 120, NOW(), NOW()),
(52,6,'Lumix GH6', 52000000, NULL, 22, 'lumix2.png', 'Lumix GH6 - advanced video', 100, 1, 90, NOW(), NOW()),
(53,6,'Lumix G7', 22000000, NULL, 45, 'lumix3.png', 'Lumix G7 - APS-C like', 160, 0, 130, NOW(), NOW()),
(54,6,'Lumix G9', 41000000, NULL, 26, 'lumix4.png', 'Lumix G9 - stills pro', 120, 1, 110, NOW(), NOW()),
(55,6,'Lumix S1', 65000000, NULL, 14, 'lumix5.png', 'Lumix S1 - fullframe', 80, 1, 70, NOW(), NOW()),
(56,6,'Lumix S5', 48000000, NULL, 20, 'lumix6.png', 'Lumix S5 - hybrid', 95, 1, 95, NOW(), NOW()),
(57,6,'Lumix TZ90', 15000000, NULL, 60, 'lumix7.png', 'Lumix TZ90 - travel zoom', 200, 0, 200, NOW(), NOW()),
(58,6,'Lumix LX100', 27000000, NULL, 44, 'lumix8.png', 'Lumix LX100 - compact', 115, 0, 115, NOW(), NOW()),
(59,6,'Lumix G100', 19000000, NULL, 50, 'lumix9.png', 'Lumix G100 - vlogger', 150, 0, 150, NOW(), NOW()),
(60,6,'Lumix BS1H', 85000000, NULL, 8, 'lumix10.png', 'Lumix BS1H - cinema', 40, 1, 40, NOW(), NOW()),

-- PENTAX (category 7) products 61..70
(61,7,'Pentax K-70', 21000000, NULL, 40, 'pentax1.png', 'Pentax K-70 - rugged', 150, 0, 130, NOW(), NOW()),
(62,7,'Pentax K-3', 26000000, NULL, 35, 'pentax2.png', 'Pentax K-3 - APS-C pro', 120, 0, 120, NOW(), NOW()),
(63,7,'Pentax K-1', 48000000, NULL, 20, 'pentax3.png', 'Pentax K-1 - fullframe', 90, 1, 90, NOW(), NOW()),
(64,7,'Pentax KP', 30000000, NULL, 30, 'pentax4.png', 'Pentax KP - compact DSLR', 130, 0, 110, NOW(), NOW()),
(65,7,'Pentax MX-1', 17000000, NULL, 60, 'pentax5.png', 'Pentax MX-1 - retro compact', 200, 0, 200, NOW(), NOW()),
(66,7,'Pentax Q-S1', 14000000, NULL, 55, 'pentax6.png', 'Pentax Q-S1 - small system', 180, 0, 180, NOW(), NOW()),
(67,7,'Pentax WG-90', 9200000, NULL, 80, 'pentax7.png', 'Pentax WG-90 - waterproof', 260, 0, 260, NOW(), NOW()),
(68,7,'Pentax K-5', 24000000, NULL, 42, 'pentax8.png', 'Pentax K-5 - classic DSLR', 140, 0, 140, NOW(), NOW()),
(69,7,'Pentax K-50', 20000000, NULL, 47, 'pentax9.png', 'Pentax K-50 - entry DSLR', 125, 0, 125, NOW(), NOW()),
(70,7,'Pentax 645Z', 230000000, NULL, 4, 'pentax10.png', 'Pentax 645Z - medium format', 8, 1, 10, NOW(), NOW());

-- PRODUCT_IMAGES: each product 3 images (primary on sort_order 1)
INSERT INTO product_images (product_id, image_url, is_primary, sort_order) VALUES
-- SONY 1..10
(1,'sony1.png', TRUE, 1),(1,'sony1-2.png', FALSE, 2),(1,'sony1-3.png', FALSE, 3),
(2,'sony2.png', TRUE, 1),(2,'sony2-2.png', FALSE, 2),(2,'sony2-3.png', FALSE, 3),
(3,'sony3.png', TRUE, 1),(3,'sony3-2.png', FALSE, 2),(3,'sony3-3.png', FALSE, 3),
(4,'sony4.png', TRUE, 1),(4,'sony4-2.png', FALSE, 2),(4,'sony4-3.png', FALSE, 3),
(5,'sony5.png', TRUE, 1),(5,'sony5-2.png', FALSE, 2),(5,'sony5-3.png', FALSE, 3),
(6,'sony6.png', TRUE, 1),(6,'sony6-2.png', FALSE, 2),(6,'sony6-3.png', FALSE, 3),
(7,'sony7.png', TRUE, 1),(7,'sony7-2.png', FALSE, 2),(7,'sony7-3.png', FALSE, 3),
(8,'sony8.png', TRUE, 1),(8,'sony8-2.png', FALSE, 2),(8,'sony8-3.png', FALSE, 3),
(9,'sony9.png', TRUE, 1),(9,'sony9-2.png', FALSE, 2),(9,'sony9-3.png', FALSE, 3),
(10,'sony10.png', TRUE, 1),(10,'sony10-2.png', FALSE, 2),(10,'sony10-3.png', FALSE, 3),

-- CANON 11..20
(11,'canon1.png', TRUE, 1),(11,'canon1-2.png', FALSE, 2),(11,'canon1-3.png', FALSE, 3),
(12,'canon2.png', TRUE, 1),(12,'canon2-2.png', FALSE, 2),(12,'canon2-3.png', FALSE, 3),
(13,'canon3.png', TRUE, 1),(13,'canon3-2.png', FALSE, 2),(13,'canon3-3.png', FALSE, 3),
(14,'canon4.png', TRUE, 1),(14,'canon4-2.png', FALSE, 2),(14,'canon4-3.png', FALSE, 3),
(15,'canon5.png', TRUE, 1),(15,'canon5-2.png', FALSE, 2),(15,'canon5-3.png', FALSE, 3),
(16,'canon6.png', TRUE, 1),(16,'canon6-2.png', FALSE, 2),(16,'canon6-3.png', FALSE, 3),
(17,'canon7.png', TRUE, 1),(17,'canon7-2.png', FALSE, 2),(17,'canon7-3.png', FALSE, 3),
(18,'canon8.png', TRUE, 1),(18,'canon8-2.png', FALSE, 2),(18,'canon8-3.png', FALSE, 3),
(19,'canon9.png', TRUE, 1),(19,'canon9-2.png', FALSE, 2),(19,'canon9-3.png', FALSE, 3),
(20,'canon10.png', TRUE, 1),(20,'canon10-2.png', FALSE, 2),(20,'canon10-3.png', FALSE, 3),

-- NIKON 21..30
(21,'nikon1.png', TRUE, 1),(21,'nikon1-2.png', FALSE, 2),(21,'nikon1-3.png', FALSE, 3),
(22,'nikon2.png', TRUE, 1),(22,'nikon2-2.png', FALSE, 2),(22,'nikon2-3.png', FALSE, 3),
(23,'nikon3.png', TRUE, 1),(23,'nikon3-2.png', FALSE, 2),(23,'nikon3-3.png', FALSE, 3),
(24,'nikon4.png', TRUE, 1),(24,'nikon4-2.png', FALSE, 2),(24,'nikon4-3.png', FALSE, 3),
(25,'nikon5.png', TRUE, 1),(25,'nikon5-2.png', FALSE, 2),(25,'nikon5-3.png', FALSE, 3),
(26,'nikon6.png', TRUE, 1),(26,'nikon6-2.png', FALSE, 2),(26,'nikon6-3.png', FALSE, 3),
(27,'nikon7.png', TRUE, 1),(27,'nikon7-2.png', FALSE, 2),(27,'nikon7-3.png', FALSE, 3),
(28,'nikon8.png', TRUE, 1),(28,'nikon8-2.png', FALSE, 2),(28,'nikon8-3.png', FALSE, 3),
(29,'nikon9.png', TRUE, 1),(29,'nikon9-2.png', FALSE, 2),(29,'nikon9-3.png', FALSE, 3),
(30,'nikon10.png', TRUE, 1),(30,'nikon10-2.png', FALSE, 2),(30,'nikon10-3.png', FALSE, 3),

-- FUJIFILM 31..40
(31,'fujifilm1.png', TRUE, 1),(31,'fujifilm1-2.png', FALSE, 2),(31,'fujifilm1-3.png', FALSE, 3),
(32,'fujifilm2.png', TRUE, 1),(32,'fujifilm2-2.png', FALSE, 2),(32,'fujifilm2-3.png', FALSE, 3),
(33,'fujifilm3.png', TRUE, 1),(33,'fujifilm3-2.png', FALSE, 2),(33,'fujifilm3-3.png', FALSE, 3),
(34,'fujifilm4.png', TRUE, 1),(34,'fujifilm4-2.png', FALSE, 2),(34,'fujifilm4-3.png', FALSE, 3),
(35,'fujifilm5.png', TRUE, 1),(35,'fujifilm5-2.png', FALSE, 2),(35,'fujifilm5-3.png', FALSE, 3),
(36,'fujifilm6.png', TRUE, 1),(36,'fujifilm6-2.png', FALSE, 2),(36,'fujifilm6-3.png', FALSE, 3),
(37,'fujifilm7.png', TRUE, 1),(37,'fujifilm7-2.png', FALSE, 2),(37,'fujifilm7-3.png', FALSE, 3),
(38,'fujifilm8.png', TRUE, 1),(38,'fujifilm8-2.png', FALSE, 2),(38,'fujifilm8-3.png', FALSE, 3),
(39,'fujifilm9.png', TRUE, 1),(39,'fujifilm9-2.png', FALSE, 2),(39,'fujifilm9-3.png', FALSE, 3),
(40,'fujifilm10.png', TRUE, 1),(40,'fujifilm10-2.png', FALSE, 2),(40,'fujifilm10-3.png', FALSE, 3),

-- LEICA 41..50
(41,'leica1.png', TRUE, 1),(41,'leica1-2.png', FALSE, 2),(41,'leica1-3.png', FALSE, 3),
(42,'leica2.png', TRUE, 1),(42,'leica2-2.png', FALSE, 2),(42,'leica2-3.png', FALSE, 3),
(43,'leica3.png', TRUE, 1),(43,'leica3-2.png', FALSE, 2),(43,'leica3-3.png', FALSE, 3),
(44,'leica4.png', TRUE, 1),(44,'leica4-2.png', FALSE, 2),(44,'leica4-3.png', FALSE, 3),
(45,'leica5.png', TRUE, 1),(45,'leica5-2.png', FALSE, 2),(45,'leica5-3.png', FALSE, 3),
(46,'leica6.png', TRUE, 1),(46,'leica6-2.png', FALSE, 2),(46,'leica6-3.png', FALSE, 3),
(47,'leica7.png', TRUE, 1),(47,'leica7-2.png', FALSE, 2),(47,'leica7-3.png', FALSE, 3),
(48,'leica8.png', TRUE, 1),(48,'leica8-2.png', FALSE, 2),(48,'leica8-3.png', FALSE, 3),
(49,'leica9.png', TRUE, 1),(49,'leica9-2.png', FALSE, 2),(49,'leica9-3.png', FALSE, 3),
(50,'leica10.png', TRUE, 1),(50,'leica10-2.png', FALSE, 2),(50,'leica10-3.png', FALSE, 3),

-- LUMIX 51..60
(51,'lumix1.png', TRUE, 1),(51,'lumix1-2.png', FALSE, 2),(51,'lumix1-3.png', FALSE, 3),
(52,'lumix2.png', TRUE, 1),(52,'lumix2-2.png', FALSE, 2),(52,'lumix2-3.png', FALSE, 3),
(53,'lumix3.png', TRUE, 1),(53,'lumix3-2.png', FALSE, 2),(53,'lumix3-3.png', FALSE, 3),
(54,'lumix4.png', TRUE, 1),(54,'lumix4-2.png', FALSE, 2),(54,'lumix4-3.png', FALSE, 3),
(55,'lumix5.png', TRUE, 1),(55,'lumix5-2.png', FALSE, 2),(55,'lumix5-3.png', FALSE, 3),
(56,'lumix6.png', TRUE, 1),(56,'lumix6-2.png', FALSE, 2),(56,'lumix6-3.png', FALSE, 3),
(57,'lumix7.png', TRUE, 1),(57,'lumix7-2.png', FALSE, 2),(57,'lumix7-3.png', FALSE, 3),
(58,'lumix8.png', TRUE, 1),(58,'lumix8-2.png', FALSE, 2),(58,'lumix8-3.png', FALSE, 3),
(59,'lumix9.png', TRUE, 1),(59,'lumix9-2.png', FALSE, 2),(59,'lumix9-3.png', FALSE, 3),
(60,'lumix10.png', TRUE, 1),(60,'lumix10-2.png', FALSE, 2),(60,'lumix10-3.png', FALSE, 3),

-- PENTAX 61..70
(61,'pentax1.png', TRUE, 1),(61,'pentax1-2.png', FALSE, 2),(61,'pentax1-3.png', FALSE, 3),
(62,'pentax2.png', TRUE, 1),(62,'pentax2-2.png', FALSE, 2),(62,'pentax2-3.png', FALSE, 3),
(63,'pentax3.png', TRUE, 1),(63,'pentax3-2.png', FALSE, 2),(63,'pentax3-3.png', FALSE, 3),
(64,'pentax4.png', TRUE, 1),(64,'pentax4-2.png', FALSE, 2),(64,'pentax4-3.png', FALSE, 3),
(65,'pentax5.png', TRUE, 1),(65,'pentax5-2.png', FALSE, 2),(65,'pentax5-3.png', FALSE, 3),
(66,'pentax6.png', TRUE, 1),(66,'pentax6-2.png', FALSE, 2),(66,'pentax6-3.png', FALSE, 3),
(67,'pentax7.png', TRUE, 1),(67,'pentax7-2.png', FALSE, 2),(67,'pentax7-3.png', FALSE, 3),
(68,'pentax8.png', TRUE, 1),(68,'pentax8-2.png', FALSE, 2),(68,'pentax8-3.png', FALSE, 3),
(69,'pentax9.png', TRUE, 1),(69,'pentax9-2.png', FALSE, 2),(69,'pentax9-3.png', FALSE, 3),
(70,'pentax10.png', TRUE, 1),(70,'pentax10-2.png', FALSE, 2),(70,'pentax10-3.png', FALSE, 3);

-- PRODUCT_SPECS: 3 specs per product
INSERT INTO product_specs (product_id, spec_name, spec_value, sort_order) VALUES
-- We'll add 3 generic specs for each product id 1..70
(1,'Sensor','APS-C',1),(1,'Megapixels','24.3MP',2),(1,'Video','1080p',3),
(2,'Sensor','APS-C',1),(2,'Megapixels','24.2MP',2),(2,'Video','4K',3),
(3,'Sensor','APS-C',1),(3,'Megapixels','24.2MP',2),(3,'Video','4K',3),
(4,'Sensor','APS-C',1),(4,'Megapixels','24.2MP',2),(4,'Video','4K',3),
(5,'Sensor','Full-frame',1),(5,'Megapixels','24.3MP',2),(5,'Video','FullHD',3),
(6,'Sensor','Full-frame',1),(6,'Megapixels','24.2MP',2),(6,'Video','4K',3),
(7,'Sensor','Full-frame',1),(7,'Megapixels','24.2MP',2),(7,'Video','4K',3),
(8,'Sensor','Full-frame',1),(8,'Megapixels','12.1MP',2),(8,'Video','4K',3),
(9,'Sensor','Full-frame',1),(9,'Megapixels','24.2MP',2),(9,'Video','4K',3),
(10,'Sensor','Full-frame',1),(10,'Megapixels','12.1MP',2),(10,'Video','4K',3),

(11,'Sensor','Full-frame',1),(11,'Megapixels','50MP',2),(11,'Video','8K',3),
(12,'Sensor','Full-frame',1),(12,'Megapixels','24MP',2),(12,'Video','4K',3),
(13,'Sensor','Full-frame',1),(13,'Megapixels','24MP',2),(13,'Video','6K',3),
(14,'Sensor','Full-frame',1),(14,'Megapixels','26MP',2),(14,'Video','4K',3),
(15,'Sensor','Full-frame',1),(15,'Megapixels','45MP',2),(15,'Video','8K',3),
(16,'Sensor','Full-frame',1),(16,'Megapixels','20MP',2),(16,'Video','4K',3),
(17,'Sensor','APS-C',1),(17,'Megapixels','32MP',2),(17,'Video','4K',3),
(18,'Sensor','Full-frame',1),(18,'Megapixels','24MP',2),(18,'Video','4K',3),
(19,'Sensor','Full-frame',1),(19,'Megapixels','24MP',2),(19,'Video','8K',3),
(20,'Sensor','APS-C',1),(20,'Megapixels','24MP',2),(20,'Video','4K',3),

(21,'Sensor','APS-C',1),(21,'Megapixels','20MP',2),(21,'Video','4K',3),
(22,'Sensor','APS-C',1),(22,'Megapixels','20MP',2),(22,'Video','4K',3),
(23,'Sensor','Full-frame',1),(23,'Megapixels','24MP',2),(23,'Video','4K',3),
(24,'Sensor','Full-frame',1),(24,'Megapixels','24MP',2),(24,'Video','4K',3),
(25,'Sensor','Full-frame',1),(25,'Megapixels','46MP',2),(25,'Video','4K',3),
(26,'Sensor','Full-frame',1),(26,'Megapixels','45MP',2),(26,'Video','8K',3),
(27,'Sensor','APS-C',1),(27,'Megapixels','20MP',2),(27,'Video','1080p',3),
(28,'Sensor','Full-frame',1),(28,'Megapixels','45MP',2),(28,'Video','4K',3),
(29,'Sensor','1/2.3\"',1),(29,'Megapixels','16MP',2),(29,'Optical Zoom','125x',3),
(30,'Sensor','Full-frame',1),(30,'Megapixels','45MP',2),(30,'Video','8K',3),

(31,'Sensor','APS-C',1),(31,'Megapixels','16MP',2),(31,'Video','1080p',3),
(32,'Sensor','APS-C',1),(32,'Megapixels','24MP',2),(32,'Video','4K',3),
(33,'Sensor','APS-C',1),(33,'Megapixels','26MP',2),(33,'Video','4K',3),
(34,'Sensor','APS-C',1),(34,'Megapixels','26MP',2),(34,'Video','4K',3),
(35,'Sensor','APS-C',1),(35,'Megapixels','40MP',2),(35,'Video','4K',3),
(36,'Sensor','APS-C',1),(36,'Megapixels','26MP',2),(36,'Video','4K',3),
(37,'Sensor','APS-C',1),(37,'Megapixels','26MP',2),(37,'Video','4K',3),
(38,'Sensor','Medium Format',1),(38,'Megapixels','50MP',2),(38,'Video','1080p',3),
(39,'Sensor','Medium Format',1),(39,'Megapixels','100MP',2),(39,'Video','4K',3),
(40,'Type','Instant',1),(40,'Film','Instax',2),(40,'Use','Casual',3),

(41,'Sensor','Full-frame',1),(41,'Megapixels','47MP',2),(41,'Video','4K',3),
(42,'Sensor','Full-frame',1),(42,'Megapixels','47MP',2),(42,'Video','4K',3),
(43,'Sensor','Full-frame',1),(43,'Megapixels','24MP',2),(43,'Video','1080p',3),
(44,'Sensor','Full-frame',1),(44,'Megapixels','60MP',2),(44,'Video','4K',3),
(45,'Sensor','Full-frame',1),(45,'Megapixels','47MP',2),(45,'Video','4K',3),
(46,'Sensor','APS-C',1),(46,'Megapixels','24MP',2),(46,'Video','1080p',3),
(47,'Sensor','APS-C',1),(47,'Megapixels','24MP',2),(47,'Video','1080p',3),
(48,'Sensor','1\"',1),(48,'Megapixels','17MP',2),(48,'Video','4K',3),
(49,'Sensor','1\"',1),(49,'Megapixels','20MP',2),(49,'Video','1080p',3),
(50,'Sensor','Medium Format',1),(50,'Megapixels','64MP',2),(50,'Video','1080p',3),

(51,'Sensor','Micro Four Thirds',1),(51,'Megapixels','20MP',2),(51,'Video','4K',3),
(52,'Sensor','Full-frame',1),(52,'Megapixels','25MP',2),(52,'Video','4K',3),
(53,'Sensor','Micro Four Thirds',1),(53,'Megapixels','16MP',2),(53,'Video','4K',3),
(54,'Sensor','Micro Four Thirds',1),(54,'Megapixels','20MP',2),(54,'Video','4K',3),
(55,'Sensor','Full-frame',1),(55,'Megapixels','24MP',2),(55,'Video','4K',3),
(56,'Sensor','Full-frame',1),(56,'Megapixels','24MP',2),(56,'Video','4K',3),
(57,'Sensor','1/2.3\"',1),(57,'Megapixels','16MP',2),(57,'Optical Zoom','30x',3),
(58,'Sensor','1\"',1),(58,'Megapixels','17MP',2),(58,'Video','4K',3),
(59,'Sensor','Micro Four Thirds',1),(59,'Megapixels','20MP',2),(59,'Video','4K',3),
(60,'Sensor','Full-frame',1),(60,'Megapixels','24MP',2),(60,'Video','6K',3),

(61,'Sensor','APS-C',1),(61,'Megapixels','24MP',2),(61,'Video','1080p',3),
(62,'Sensor','APS-C',1),(62,'Megapixels','24MP',2),(62,'Video','1080p',3),
(63,'Sensor','Full-frame',1),(63,'Megapixels','36MP',2),(63,'Video','4K',3),
(64,'Sensor','APS-C',1),(64,'Megapixels','24MP',2),(64,'Video','1080p',3),
(65,'Sensor','Compact',1),(65,'Megapixels','12MP',2),(65,'Video','1080p',3),
(66,'Sensor','1/2.3\"',1),(66,'Megapixels','12MP',2),(66,'Video','1080p',3),
(67,'Sensor','Rugged',1),(67,'Megapixels','16MP',2),(67,'Waterproof','Yes',3),
(68,'Sensor','APS-C',1),(68,'Megapixels','16MP',2),(68,'Video','1080p',3),
(69,'Sensor','APS-C',1),(69,'Megapixels','16MP',2),(69,'Video','1080p',3),
(70,'Sensor','Medium Format',1),(70,'Megapixels','51MP',2),(70,'Video','1080p',3);

-- PRODUCT_POLICIES: 2 policies per product
TRUNCATE TABLE product_policies;

INSERT INTO product_policies (product_id, policy_type, policy_content, sort_order) VALUES
-- PRODUCT 1
(1,'Warranty','Bảo hành chính hãng 12 tháng, đổi mới trong 15 ngày đầu nếu lỗi kỹ thuật',1),
(1,'Return','Đổi trả trong 7 ngày nếu chưa sử dụng',2),
(1,'Shipping','Miễn phí giao hàng toàn quốc',3),

-- PRODUCT 2
(2,'Warranty','Bảo hành chính hãng 24 tháng tại trung tâm ủy quyền',1),
(2,'Return','Đổi trả trong 10 ngày khi còn nguyên tem',2),
(2,'Support','Hỗ trợ kỹ thuật Online trọn đời',3),

-- PRODUCT 3
(3,'Warranty','Bảo hành 18 tháng tại hệ thống Kyron Store',1),
(3,'Return','Đổi trả trong 5 ngày với lỗi nhà sản xuất',2),
(3,'Gift','Tặng thẻ nhớ 64GB chính hãng',3),

-- PRODUCT 4
(4,'Warranty','Bảo hành điện tử 12 tháng toàn quốc',1),
(4,'Return','Đổi trả trong 14 ngày nếu lỗi phần cứng',2),
(4,'Shipping','Giao nhanh trong 2 giờ nội thành',3),

-- PRODUCT 5
(5,'Warranty','Bảo hành VIP 36 tháng tại Kyron Care',1),
(5,'Return','Đổi mới trong 30 ngày nếu có lỗi',2),
(5,'Insurance','Tặng bảo hiểm rơi vỡ 6 tháng',3),

-- PRODUCT 6
(6,'Warranty','Bảo hành chính hãng 12 tháng',1),
(6,'Return','Đổi trả trong 7 ngày nếu chưa kích hoạt',2),
(6,'Gift','Tặng balo máy ảnh cao cấp',3),

-- PRODUCT 7
(7,'Warranty','Bảo hành 24 tháng toàn quốc',1),
(7,'Return','Đổi trả trong 10 ngày với lỗi kỹ thuật',2),
(7,'Support','1 đổi 1 trong 7 ngày đầu',3),

-- PRODUCT 8
(8,'Warranty','Bảo hành tiêu chuẩn 12 tháng',1),
(8,'Return','Đổi trả trong 3 ngày nếu lỗi nhà sản xuất',2),
(8,'Shipping','Miễn phí vận chuyển nội thành',3),

-- PRODUCT 9
(9,'Warranty','Bảo hành 24 tháng + gia hạn 6 tháng',1),
(9,'Return','Đổi trả trong 14 ngày',2),
(9,'Gift','Tặng pin dự phòng chính hãng',3),

-- PRODUCT 10
(10,'Warranty','Bảo hành cao cấp 36 tháng toàn cầu',1),
(10,'Return','Đổi mới trong 15 ngày nếu lỗi phần cứng',2),
(10,'Insurance','Bảo hiểm rơi vỡ & vào nước 12 tháng',3);
-- Thêm chính sách cho các sản phẩm còn lại (ví dụ đơn giản)
INSERT INTO product_policies (product_id, policy_type, policy_content, sort_order)
SELECT id, 'Warranty','Bảo hành 12 tháng',1 FROM products WHERE id NOT IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10);
INSERT INTO product_policies (product_id, policy_type, policy_content, sort_order)
SELECT id, 'Return','Đổi trả 7 ngày',2 FROM products WHERE id NOT IN (1, 2, 3, 4, 5, 6, 7, 8, 9, 10);


-- USERS (sample customers + admin)
INSERT INTO users (id, full_name, email, password, phone, address, role, created_at) VALUES
(1,'Nguyen Van A','nva@example.com','$2y$10$examplehash1','0912345678','Hanoi, VN','customer',NOW()),
(2,'Tran Thi B','ttb@example.com','$2y$10$examplehash2','0987654321','Da Nang, VN','customer',NOW()),
(3,'Le Van C','lvc@example.com','$2y$10$examplehash3','0900111222','Ho Chi Minh, VN','customer',NOW()),
(4,'Pham Thi D','ptd@example.com','$2y$10$examplehash4','0933999888','Hai Phong, VN','customer',NOW()),
(5,'Admin Shop','admin@shop.com','$2y$10$adminhash','0000000000','Store address','admin',NOW());

-- REVIEWS: 1 review per product (simple)
INSERT INTO reviews (user_id, product_id, rating, comment, created_at) VALUES
(1,1,5,'Ảnh đẹp, giao hàng nhanh',NOW()),
(2,2,4,'Tốt cho người mới',NOW()),
(3,3,5,'Autofocus rất ổn',NOW()),
(1,4,4,'Hài lòng',NOW()),
(2,5,5,'Chất lượng tuyệt vời',NOW()),
(3,6,4,'Pin dùng khá lâu',NOW()),
(4,7,4,'Tốc độ chụp tốt',NOW()),
(1,8,5,'Quay phim rất mượt',NOW()),
(2,9,5,'Máy pro',NOW()),
(3,10,4,'Đắt nhưng xứng đáng',NOW()),

(1,11,5,'Flagship mạnh',NOW()),
(2,12,4,'Ổn cho nhu cầu',NOW()),
(3,13,5,'Tốt cho thể thao',NOW()),
(4,14,4,'Đa dụng',NOW()),
(1,15,5,'Độ phân giải cao',NOW()),
(2,16,4,'Cảm biến tốt',NOW()),
(3,17,4,'Nhỏ gọn',NOW()),
(4,18,5,'Cân bằng tốt',NOW()),
(1,19,4,'Hiệu năng cao',NOW()),
(2,20,4,'Giá hợp lý',NOW()),

(3,21,4,'Vlog tốt',NOW()),
(4,22,4,'Dễ dùng',NOW()),
(1,23,5,'Chất ảnh đẹp',NOW()),
(2,24,5,'Rất ổn',NOW()),
(3,25,4,'Chụp studio ngon',NOW()),
(4,26,5,'Mạnh mẽ',NOW()),
(1,27,4,'DSLR ổn',NOW()),
(2,28,5,'Độ phân giải cao',NOW()),
(3,29,3,'Zoom ấn tượng',NOW()),
(4,30,5,'Flagship Nikon',NOW()),

(1,31,3,'Cũ nhưng tốt',NOW()),
(2,32,4,'Ổn',NOW()),
(3,33,5,'Rất tốt',NOW()),
(4,34,5,'Ưa thích',NOW()),
(1,35,5,'Ảnh đẹp',NOW()),
(2,36,4,'Tiện dụng',NOW()),
(3,37,4,'Nhỏ nhẹ',NOW()),
(4,38,5,'Medium format tuyệt',NOW()),
(1,39,5,'Đắt nhưng tuyệt',NOW()),
(2,40,5,'Vui vẻ',NOW()),

(3,41,4,'Chất lượng Leica',NOW()),
(4,42,5,'Sang',NOW()),
(1,43,4,'Rangefinder classic',NOW()),
(2,44,5,'Đỉnh',NOW()),
(3,45,4,'Gần như hoàn thiện',NOW()),
(4,46,4,'Compact tốt',NOW()),
(1,47,3,'Ổn',NOW()),
(2,48,4,'Thiết kế đẹp',NOW()),
(3,49,4,'Zoom tốt',NOW()),
(4,50,5,'Medium format pro',NOW()),

(1,51,4,'GH5 quay tốt',NOW()),
(2,52,5,'GH6 mạnh',NOW()),
(3,53,4,'G7 ngon',NOW()),
(4,54,4,'G9 xuất sắc',NOW()),
(1,55,5,'S1 chất',NOW()),
(2,56,4,'S5 ổn',NOW()),
(3,57,4,'Dùng khi đi du lịch',NOW()),
(4,58,4,'LX100 nhỏ gọn',NOW()),
(1,59,4,'G100 cho vlogger',NOW()),
(2,60,4,'BS1H chuyên',NOW()),

(3,61,4,'Pentax bền',NOW()),
(4,62,4,'K-3 ngon',NOW()),
(1,63,5,'K-1 tốt',NOW()),
(2,64,4,'KP ổn',NOW()),
(3,65,4,'MX-1 retro',NOW()),
(4,66,3,'Q-S1 nhỏ',NOW()),
(1,67,4,'WG-90 chắc',NOW()),
(2,68,4,'K-5 ổn',NOW()),
(3,69,4,'K-50 hợp lý',NOW()),
(4,70,5,'645Z tuyệt',NOW());

-- CARTS & WISHLISTS (sample)
INSERT INTO carts (user_id, product_id, quantity, added_at) VALUES
(1,6,1,NOW()),
(1,15,1,NOW()),
(2,33,2,NOW()),
(3,59,1,NOW());

INSERT INTO wishlists (user_id, product_id, added_at) VALUES
(1,15,NOW()),
(2,6,NOW()),
(3,39,NOW());

-- PROMOTIONS
INSERT INTO promotions (code, name, description, discount_type, discount_value, min_order_amount, max_discount_amount, start_date, end_date, usage_limit, used_count, is_active, created_at) VALUES
('WELCOME10','Welcome 10%','Giảm 10% cho đơn hàng đầu tiên','percentage',10.00,0.00,500000.00,NOW(),DATE_ADD(NOW(), INTERVAL 90 DAY),NULL,0,TRUE,NOW()),
('SUMMER100','Summer Sale 100k','Giảm 100000 VND cho đơn hàng > 1.000.000','fixed',100000.00,1000000.00,NULL,NOW(),DATE_ADD(NOW(), INTERVAL 30 DAY),NULL,0,TRUE,NOW());

-- ORDERS, ORDER_ITEMS, CHECKOUTS (sample 6 orders)
-- Đã điều chỉnh total_money trong ORDERS để khớp với total_amount trong CHECKOUTS (không tính phí ship và giảm giá) hoặc giá trị ban đầu (nếu không có checkout)
-- INSERT INTO orders (id, user_id, order_code, note, total_money, status, created_at) VALUES
-- (1,1,'ORD-2025001','Ghi chú 1', 45000000.00, 'completed', NOW()),      -- Sản phẩm 45tr
-- (2,2,'ORD-2025002','Ghi chú 2', 28000000.00, 'processing', NOW()),    -- Sản phẩm 28tr
-- (3,1,'ORD-2025003','Ghi chú 3', 150000000.00, 'completed', NOW()),    -- Sản phẩm 150tr (Đã fix giá)
-- (4,3,'ORD-2025004','Ghi chú 4', 36000000.00, 'pending', NOW()),       -- Sản phẩm 36tr
-- (5,4,'ORD-2025005','Ghi chú 5', 15000000.00, 'cancelled', NOW()),     -- Sản phẩm 15tr
-- (6,2,'ORD-2025006','Ghi chú 6', 52000000.00, 'completed', NOW());     -- Sản phẩm 52tr (Giá gốc trước giảm giá)

INSERT INTO order_items (order_id, product_id, quantity, price) VALUES
(1,6,1,45000000.00),
(2,3,1,28000000.00),
(3,39,1,150000000.00),
(4,51,1,36000000.00),
(5,57,1,15000000.00),
(6,52,1,52000000.00);
SET FOREIGN_KEY_CHECKS=1;

-- End of fixed seed file

-- truy vấn 
-- giảm giá cho các sản phẩm nnổibaatj
UPDATE products
SET sale_price = price - (price * 15 / 100)
WHERE is_featured = 1;
