@extends('admin.layout')

@section('title', 'Chi tiết sản phẩm')
@section('page-title', 'Chi tiết sản phẩm: ' . ($product->name ?? ''))

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Thông tin sản phẩm</h5>
                <div>
                    <a href="{{ route('admin.products.edit', $product->id ?? 0) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Sửa
                    </a>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-arrow-left"></i> Quay lại
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4">
                        @if(isset($product->thumbnail))
                            <img src="{{ asset('source/images/products/' . $product->thumbnail) }}" 
                                 alt="{{ $product->name }}" class="img-fluid rounded">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center rounded" style="height: 200px;">
                                <i class="fas fa-image fa-3x text-muted"></i>
                            </div>
                        @endif
                    </div>
                    <div class="col-md-8">
                        <table class="table table-borderless">
                            <tr>
                                <th width="30%">ID:</th>
                                <td>{{ $product->id ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Tên sản phẩm:</th>
                                <td>{{ $product->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Danh mục:</th>
                                <td>{{ $product->category->name ?? 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Giá gốc:</th>
                                <td class="text-danger fw-bold">{{ number_format($product->price ?? 0) }}₫</td>
                            </tr>
                            @if(isset($product->sale_price))
                            <tr>
                                <th>Giá khuyến mãi:</th>
                                <td class="text-success fw-bold">{{ number_format($product->sale_price) }}₫</td>
                            </tr>
                            @endif
                            <tr>
                                <th>Số lượng:</th>
                                <td>
                                    <span class="badge bg-{{ ($product->quantity ?? 0) > 0 ? 'success' : 'danger' }}">
                                        {{ $product->quantity ?? 0 }} sản phẩm
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Đã bán:</th>
                                <td>{{ $product->total_sold ?? 0 }} sản phẩm</td>
                            </tr>
                            <tr>
                                <th>Lượt xem:</th>
                                <td>{{ $product->view_count ?? 0 }} lượt</td>
                            </tr>
                            <tr>
                                <th>Nổi bật:</th>
                                <td>
                                    <span class="badge bg-{{ ($product->is_featured ?? false) ? 'success' : 'secondary' }}">
                                        {{ ($product->is_featured ?? false) ? 'Có' : 'Không' }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <th>Ngày tạo:</th>
                                <td>{{ isset($product->created_at) ? $product->created_at->format('d/m/Y H:i') : 'N/A' }}</td>
                            </tr>
                            <tr>
                                <th>Cập nhật:</th>
                                <td>{{ isset($product->updated_at) ? $product->updated_at->format('d/m/Y H:i') : 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                @if(isset($product->description) && $product->description)
                <div class="mt-4">
                    <h6>Mô tả sản phẩm:</h6>
                    <div class="border rounded p-3 bg-light">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Thống kê</h6>
            </div>
            <div class="card-body">
                <div class="text-center">
                    <div class="mb-3">
                        <h4 class="text-primary">{{ $product->view_count ?? 0 }}</h4>
                        <small class="text-muted">Lượt xem</small>
                    </div>
                    <div class="mb-3">
                        <h4 class="text-success">{{ $product->total_sold ?? 0 }}</h4>
                        <small class="text-muted">Đã bán</small>
                    </div>
                    <div class="mb-3">
                        <h4 class="text-warning">{{ $product->quantity ?? 0 }}</h4>
                        <small class="text-muted">Tồn kho</small>
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
                    <a href="{{ route('detail', $product->id ?? 0) }}" class="btn btn-info btn-sm" target="_blank">
                        <i class="fas fa-external-link-alt"></i> Xem trên website
                    </a>
                    <a href="{{ route('admin.products.edit', $product->id ?? 0) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Chỉnh sửa
                    </a>
                    <form method="POST" action="{{ route('admin.products.destroy', $product->id ?? 0) }}" 
                          onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm w-100">
                            <i class="fas fa-trash"></i> Xóa sản phẩm
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection