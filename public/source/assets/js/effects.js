// Hiệu ứng cho header tối ưu
document.addEventListener('DOMContentLoaded', function() {
    // Xử lý nút thêm vào giỏ hàng
    const addToCartButtons = document.querySelectorAll('.add-to-cart');
    
    addToCartButtons.forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            addToCart(productId);
        });
    });
    
    // Hiệu ứng cho dropdown menu
    const dropdowns = document.querySelectorAll('.dropdown');
    
    dropdowns.forEach(dropdown => {
        dropdown.addEventListener('mouseenter', function() {
            const menu = this.querySelector('.dropdown-menu');
            menu.style.opacity = '1';
            menu.style.visibility = 'visible';
            menu.style.transform = 'translateY(0)';
        });
        
        dropdown.addEventListener('mouseleave', function() {
            const menu = this.querySelector('.dropdown-menu');
            menu.style.opacity = '0';
            menu.style.visibility = 'hidden';
            menu.style.transform = 'translateY(10px)';
        });
    });
    
    // Cập nhật số lượng sản phẩm trong giỏ hàng
    function updateCartCount() {
        const cartCount = document.querySelector('.cart-count');
        let count = localStorage.getItem('cartCount') || 0;
        cartCount.textContent = count;
    }
    
    // Thêm sản phẩm vào giỏ hàng
    function addToCart(productId) {
        let cartCount = parseInt(localStorage.getItem('cartCount')) || 0;
        cartCount++;
        localStorage.setItem('cartCount', cartCount);
        updateCartCount();
        
        // Hiệu ứng thông báo
        showNotification('Sản phẩm đã được thêm vào giỏ hàng!');
    }
    
    // Hiển thị thông báo
    function showNotification(message) {
        // Tạo element thông báo
        const notification = document.createElement('div');
        notification.className = 'notification';
        notification.textContent = message;
        notification.style.cssText = `
            position: fixed;
            top: 80px;
            right: 20px;
            background: var(--success-color);
            color: white;
            padding: 12px 20px;
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            z-index: 1000;
            transform: translateX(100%);
            transition: transform 0.3s ease;
        `;
        
        document.body.appendChild(notification);
        
        // Hiệu ứng xuất hiện
        setTimeout(() => {
            notification.style.transform = 'translateX(0)';
        }, 100);
        
        // Tự động ẩn sau 3 giây
        setTimeout(() => {
            notification.style.transform = 'translateX(100%)';
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 300);
        }, 3000);
    }
    
    // Khởi tạo số lượng giỏ hàng khi trang được tải
    updateCartCount();
    
    // Xử lý responsive cho menu trên mobile
    function initMobileMenu() {
        const nav = document.querySelector('.main-nav');
        const navUl = nav.querySelector('ul');
        
        // Tạo nút menu mobile
        const mobileMenuBtn = document.createElement('button');
        mobileMenuBtn.className = 'mobile-menu-btn';
        mobileMenuBtn.innerHTML = '☰';
        mobileMenuBtn.style.cssText = `
            display: none;
            background: none;
            border: none;
            font-size: 20px;
            cursor: pointer;
            padding: 5px;
        `;
        
        nav.insertBefore(mobileMenuBtn, navUl);
        
        // Kiểm tra kích thước màn hình
        function checkScreenSize() {
            if (window.innerWidth <= 768) {
                mobileMenuBtn.style.display = 'block';
                navUl.style.display = 'none';
                navUl.style.flexDirection = 'column';
                navUl.style.position = 'absolute';
                navUl.style.top = '100%';
                navUl.style.left = '0';
                navUl.style.right = '0';
                navUl.style.background = 'white';
                navUl.style.boxShadow = '0 4px 6px rgba(0,0,0,0.1)';
                navUl.style.padding = '10px';
            } else {
                mobileMenuBtn.style.display = 'none';
                navUl.style.display = 'flex';
                navUl.style.position = 'static';
                navUl.style.background = 'transparent';
                navUl.style.boxShadow = 'none';
                navUl.style.padding = '0';
            }
        }
        
        // Sự kiện click menu mobile
        mobileMenuBtn.addEventListener('click', function() {
            if (navUl.style.display === 'none' || !navUl.style.display) {
                navUl.style.display = 'flex';
            } else {
                navUl.style.display = 'none';
            }
        });
        
        // Kiểm tra khi resize
        window.addEventListener('resize', checkScreenSize);
        checkScreenSize();
    }
    
    // Khởi tạo menu mobile
    initMobileMenu();
});