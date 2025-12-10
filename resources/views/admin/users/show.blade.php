@extends('admin.layout')

@section('title', 'Chi tiết người dùng')
@section('page-title', 'Chi tiết người dùng: ' . ($user->full_name ?? $user->name ?? ''))

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Thông tin người dùng</h5>
                <div>
                    <a href="{{ route('admin.users.edit', $user->id ?? 0) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Sửa
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">ID:</th>
                                <td>{{ $user->id ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Họ và tên:</th>
                                <td>{{ $user->full_name ?? $user->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Email:</th>
                                <td>{{ $user->email ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Số điện thoại:</th>
                                <td>{{ $user->phone ?? 'Chưa cập nhật' }}</td>
                            </tr>
                            <tr>
                                <th>Vai trò:</th>
                                <td>
                                    <span class="badge bg-{{ ($user->role ?? 'customer') == 'admin' ? 'danger' : 'primary' }}">
                                        {{ ucfirst($user->role ?? 'customer') }}
                                    </span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">Ngày tạo:</th>
                                <td>{{ isset($user->created_at) ? $user->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Cập nhật:</th>
                                <td>{{ isset($user->updated_at) ? $user->updated_at->format('d/m/Y H:i') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Trạng thái:</th>
                                <td>
                                    <span class="badge bg-success">Hoạt động</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                @if(isset($user->address) && $user->address)
                <div class="mt-4">
                    <h6>Địa chỉ:</h6>
                    <div class="border rounded p-3 bg-light">
                        {{ $user->address }}
                    </div>
                </div>
                @endif
            </div>
        </div>

        @if(isset($user->orders) && $user->orders->count() > 0)
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="mb-0">Lịch sử đơn hàng ({{ $user->orders->count() }} đơn)</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->orders->take(10) as $order)
                            <tr>
                                <td>{{ $order->order_code }}</td>
                                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                                <td class="text-danger fw-bold">{{ number_format($order->total_amount) }}₫</td>
                                <td>
                                    <span class="badge bg-{{ 
                                        $order->status == 'completed' ? 'success' : 
                                        ($order->status == 'pending' ? 'warning' : 
                                        ($order->status == 'cancelled' ? 'danger' : 'info')) 
                                    }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                @if($user->orders->count() > 10)
                <div class="text-center mt-3">
                    <a href="{{ route('admin.orders.index', ['user_id' => $user->id]) }}" class="btn btn-outline-primary">
                        Xem tất cả đơn hàng
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Thống kê</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="mb-3">
                        <h4 class="text-primary">{{ isset($user->orders) ? $user->orders->count() : 0 }}</h4>
                        <small class="text-muted">Tổng đơn hàng</small>
                    </div>
                    <div class="mb-3">
                        <h4 class="text-success">{{ isset($user->orders) ? number_format($user->orders->sum('total_amount')) : 0 }}₫</h4>
                        <small class="text-muted">Tổng chi tiêu</small>
                    </div>
                    <div class="mb-3">
                        <h4 class="text-info">{{ isset($user->orders) ? $user->orders->where('status', 'completed')->count() : 0 }}</h4>
                        <small class="text-muted">Đơn hoàn thành</small>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Thao tác nhanh</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('admin.users.edit', $user->id ?? 0) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Chỉnh sửa thông tin
                    </a>
                    @if(isset($user->orders) && $user->orders->count() > 0)
                    <a href="{{ route('admin.orders.index', ['search' => $user->email]) }}" class="btn btn-info btn-sm">
                        <i class="fas fa-shopping-cart"></i> Xem đơn hàng
                    </a>
                    @endif
                    @if(($user->role ?? 'customer') != 'admin' || Auth::id() != $user->id)
                    <form method="POST" action="{{ route('admin.users.destroy', $user->id ?? 0) }}" 
                          onsubmit="return confirm('Bạn có chắc muốn xóa người dùng này?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm w-100">
                            <i class="fas fa-trash"></i> Xóa người dùng
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection