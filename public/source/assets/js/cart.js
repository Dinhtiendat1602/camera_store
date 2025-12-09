// Cart functionality
function addToCartAjax(productId, quantity = 1) {
    return fetch('/cart/add', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: quantity
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Server response:', data);
        if (data.success) {
            // Cập nhật số lượng giỏ hàng trong header
            updateCartCount(data.cartCount);
            
            // Hiển thị thông báo
            showNotification(data.message, 'success');
            return Promise.resolve(data);
        } else {
            // Nếu cần redirect (chưa đăng nhập)
            if (data.redirect) {
                const notification = showNotification(data.message || 'Bạn cần đăng nhập để thêm vào giỏ hàng. Đang chuyển hướng...', 'error', false);
                setTimeout(() => {
                    window.location.href = data.redirect;
                }, 1500);
            } else {
                // Hiển thị thông báo lỗi khác
                showNotification(data.message || 'Có lỗi xảy ra!', 'error');
            }
            
            return Promise.reject(data);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        
        // Kiểm tra nếu là lỗi mạng hoặc server
        if (error.message && error.message.includes('HTTP error')) {
            showNotification('Không thể kết nối đến server. Vui lòng thử lại!', 'error');
        } else if (error.message && error.message.includes('Failed to fetch')) {
            showNotification('Lỗi kết nối mạng. Vui lòng kiểm tra kết nối internet!', 'error');
        } else {
            showNotification('Có lỗi xảy ra. Vui lòng thử lại!', 'error');
        }
        
        return Promise.reject(error);
    });
}

function updateCartCount(count) {
    const cartCountElement = document.querySelector('.cart-count');
    if (cartCountElement) {
        cartCountElement.textContent = count;
        
        // Thêm hiệu ứng bounce
        cartCountElement.style.transform = 'scale(1.3)';
        setTimeout(() => {
            cartCountElement.style.transform = 'scale(1)';
        }, 200);
    }
}

function showNotification(message, type, autoRemove = true) {
    // Xóa notification cũ nếu có
    const existingNotification = document.querySelector('.notification-overlay');
    if (existingNotification) {
        existingNotification.remove();
    }
    
    // Tạo notification mới
    const notificationOverlay = document.createElement('div');
    notificationOverlay.className = 'notification-overlay';
    
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    
    let icon = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
    
    // Nếu message chứa từ "chuyển hướng" thì thêm icon loading
    if (message.includes('chuyển hướng') || message.includes('đang chuyển')) {
        icon = 'fas fa-spinner fa-spin';
    }
    
    notification.innerHTML = `
        <i class="${icon}"></i>
        <span>${message}</span>
    `;
    
    notificationOverlay.appendChild(notification);
    document.body.appendChild(notificationOverlay);
    
    // Tự động xóa sau 3 giây (nếu autoRemove = true)
    if (autoRemove) {
        setTimeout(() => {
            if (notificationOverlay.parentNode) {
                notificationOverlay.remove();
            }
        }, 3000);
    }
    
    return notificationOverlay;
}