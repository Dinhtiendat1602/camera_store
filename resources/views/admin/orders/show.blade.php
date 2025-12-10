@extends('admin.layout')

@section('title', 'Chi tiết đơn hàng')
@section('page-title', 'Chi tiết đơn hàng: ' . ($order->order_code ?? ''))

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Thông tin đơn hàng</h5>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Thông tin khách hàng</h6>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <th width="40%">Họ tên:</th>
                                <td>{{ $order->customer_name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $order->customer_email ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Điện thoại:</th>
                                <td>{{ $order->customer_phone ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Địa chỉ:</th>
                                <td>{{ $order->customer_address ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6>Thông tin đơn hàng</h6>
                        <table class="table table-borderless table-sm">
                            <tr>
                                <th width="40%">Mã đơn hàng:</th>
                                <td><strong>{{ $order->order_code ?? 'N/A' }}</strong></td>
                            </tr>
                            <tr>
                                <th>Ngày đặt:</th>
                                <td>{{ isset($order->created_at) ? $order->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Trạng thái:</th>
                                <td>
                                    <span class="badge bg-{{ 
                                        ($order->status ?? '') == 'completed' ? 'success' : 
                                        (($order->status ?? '') == 'pending' ? 'warning' : 
                                        (($order->status ?? '') == 'cancelled' ? 'danger' : 'info')) 
                                    }}">
                                        {{ ucfirst($order->status ?? 'N/A') }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Thanh toán:</th>
                                <td>
                                    @if(($order->payment_method ?? '') == 'cod')
                                        Thanh toán khi nhận hàng
                                    @elseif(($order->payment_method ?? '') == 'bank')
                                        Chuyển khoản ngân hàng
                                    @else
                                        {{ $order->payment_method ?? 'N/A' }}
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Chi tiết sản phẩm</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Đơn giá</th>
                                <th>Số lượng</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($order->orderItems ?? [] as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if(isset($item->product->thumbnail))
                                            <img src="{{ asset('source/images/products/' . $item->product->thumbnail) }}" 
                                                 alt="{{ $item->product->name }}" 
                                                 style="width: 50px; height: 50px; object-fit: cover;" class="me-3">
                                        @endif
                                        <div>
                                            <strong>{{ $item->product->name ?? 'Sản phẩm đã xóa' }}</strong>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ number_format($item->price ?? 0) }}₫</td>
                                <td>{{ $item->quantity ?? 0 }}</td>
                                <td class="text-danger fw-bold">{{ number_format($item->total ?? 0) }}₫</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Không có sản phẩm nào</td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Tổng cộng:</th>
                                <th class="text-danger">{{ number_format($order->total_amount ?? 0) }}₫</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Cập nhật trạng thái</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.orders.update', $order->id ?? 0) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Trạng thái đơn hàng</label>
                        <select class="form-select" id="status" name="status">
                            <option value="pending" {{ ($order->status ?? '') == 'pending' ? 'selected' : '' }}>Chờ xử lý</option>
                            <option value="confirmed" {{ ($order->status ?? '') == 'confirmed' ? 'selected' : '' }}>Đã xác nhận</option>
                            <option value="shipping" {{ ($order->status ?? '') == 'shipping' ? 'selected' : '' }}>Đang giao hàng</option>
                            <option value="completed" {{ ($order->status ?? '') == 'completed' ? 'selected' : '' }}>Hoàn thành</option>
                            <option value="cancelled" {{ ($order->status ?? '') == 'cancelled' ? 'selected' : '' }}>Đã hủy</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="payment_status" class="form-label">Trạng thái thanh toán</label>
                        <select class="form-select" id="payment_status" name="payment_status">
                            <option value="unpaid" {{ ($order->payment_status ?? '') == 'unpaid' ? 'selected' : '' }}>Chưa thanh toán</option>
                            <option value="paid" {{ ($order->payment_status ?? '') == 'paid' ? 'selected' : '' }}>Đã thanh toán</option>
                            <option value="failed" {{ ($order->payment_status ?? '') == 'failed' ? 'selected' : '' }}>Thanh toán thất bại</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">Ghi chú</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $order->note ?? '') }}</textarea>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save"></i> Cập nhật
                    </button>
                </form>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Tóm tắt đơn hàng</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless table-sm">
                    <tr>
                        <th>Tổng tiền hàng:</th>
                        <td class="text-end">{{ number_format($order->total_amount ?? 0) }}₫</td>
                    </tr>
                    <tr>
                        <th>Phí vận chuyển:</th>
                        <td class="text-end">{{ number_format($order->shipping_fee ?? 0) }}₫</td>
                    </tr>
                    <tr>
                        <th>Giảm giá:</th>
                        <td class="text-end">-{{ number_format($order->discount_amount ?? 0) }}₫</td>
                    </tr>
                    <tr class="border-top">
                        <th>Tổng thanh toán:</th>
                        <th class="text-end text-danger">{{ number_format($order->final_amount ?? $order->total_amount ?? 0) }}₫</th>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection