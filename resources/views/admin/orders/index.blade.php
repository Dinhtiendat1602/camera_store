@extends('admin.layout')

@section('title', 'Quản lý đơn hàng')
@section('page-title', 'Quản lý đơn hàng')



@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <form method="GET" class="d-flex">
            <select name="status" class="form-select me-2">
                <option value="">Tất cả trạng thái</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                <option value="shipping" {{ request('status') == 'shipping' ? 'selected' : '' }}>Đang giao</option>
                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
            </select>
            <input type="text" name="search" class="form-control me-2" placeholder="Tìm kiếm đơn hàng..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-secondary">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Khách hàng</th>
                        <th>Email</th>
                        <th>Điện thoại</th>
                        <th>Tổng tiền</th>
                        <th>Trạng thái</th>
                        <th>Ngày đặt</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders ?? [] as $order)
                    @if(isset($order) && is_object($order))
                    <tr>
                        <td>
                            <strong>{{ $order->order_code ?? 'N/A' }}</strong>
                        </td>
                        <td>{{ $order->customer_name ?? 'N/A' }}</td>
                        <td>{{ $order->customer_email ?? 'N/A' }}</td>
                        <td>{{ $order->customer_phone ?? 'N/A' }}</td>
                        <td class="text-danger fw-bold">{{ number_format($order->total_amount ?? 0) }}₫</td>
                        <td>
                            <select class="form-select form-select-sm status-select" data-order-id="{{ $order->id ?? '' }}">
                                <option value="pending" {{ ($order->status ?? '') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                                <option value="confirmed" {{ ($order->status ?? '') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                                <option value="shipping" {{ ($order->status ?? '') == 'shipping' ? 'selected' : '' }}>Đang giao</option>
                                <option value="completed" {{ ($order->status ?? '') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                                <option value="cancelled" {{ ($order->status ?? '') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                            </select>
                        </td>
                        <td>{{ $order->created_at && method_exists($order->created_at, 'format') ? $order->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.orders.show', $order->id ?? 0) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.orders.destroy', $order->id ?? 0) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endif
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">Không có đơn hàng nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if(isset($orders) && method_exists($orders, 'links'))
            {{ $orders->links() }}
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const statusSelects = document.querySelectorAll('.status-select');
    
    statusSelects.forEach(select => {
        // Store original value for rollback
        select.dataset.originalValue = select.value;
        
        select.addEventListener('change', function() {
            const orderId = this.dataset.orderId;
            const newStatus = this.value;
            
            if (!orderId || !newStatus) {
                alert('Dữ liệu không hợp lệ');
                return;
            }
            
            const csrfToken = '{{ csrf_token() }}';
            
            if (!csrfToken) {
                alert('Lỗi bảo mật: Không tìm thấy CSRF token');
                return;
            }
            
            fetch(`/admin/orders/${orderId}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: `status=${newStatus}&_token=${csrfToken}`
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                const contentType = response.headers.get('content-type');
                if (contentType && contentType.includes('application/json')) {
                    return response.json();
                } else {
                    return response.text().then(text => {
                        throw new Error('Server returned HTML instead of JSON: ' + text.substring(0, 100));
                    });
                }
            })
            .then(data => {
                if (data.success) {
                    // Show success message
                    const alert = document.createElement('div');
                    alert.className = 'alert alert-success alert-dismissible fade show';
                    alert.textContent = data.message || 'Cập nhật thành công';
                    
                    const closeBtn = document.createElement('button');
                    closeBtn.type = 'button';
                    closeBtn.className = 'btn-close';
                    closeBtn.setAttribute('data-bs-dismiss', 'alert');
                    alert.appendChild(closeBtn);
                    
                    const mainElement = document.querySelector('main');
                    if (mainElement) {
                        mainElement.insertBefore(alert, mainElement.firstChild);
                    }
                } else {
                    alert('Cập nhật thất bại: ' + (data.message || 'Lỗi không xác định'));
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi cập nhật trạng thái: ' + error.message);
                // Reset select to original value
                this.value = this.dataset.originalValue || 'pending';
            });
        });
    });
});
</script>
@endsection