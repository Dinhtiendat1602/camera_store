@extends('admin.layout')

@section('title', 'Quản lý sản phẩm')
@section('page-title', 'Quản lý sản phẩm')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <div>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm sản phẩm
        </a>
    </div>
    <div>
        <form method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Tìm kiếm sản phẩm..." value="{{ request('search') }}">
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
                        <th>ID</th>
                        <th>Hình ảnh</th>
                        <th>Tên sản phẩm</th>
                        <th>Danh mục</th>
                        <th>Giá</th>
                        <th>Giá KM</th>
                        <th>Tồn kho</th>
                        <th>Trạng thái</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products ?? [] as $product)
                    @if(isset($product) && is_object($product))
                    <tr>
                        <td>{{ isset($product->id) ? $product->id : '' }}</td>
                        <td>
                            @if(isset($product->thumbnail) && $product->thumbnail)
                                <img src="{{ asset('source/images/products/' . $product->thumbnail) }}" alt="{{ isset($product->name) ? $product->name : '' }}" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>{{ isset($product->name) ? $product->name : '' }}</td>
                        <td>{{ isset($product->category) && $product->category ? $product->category->name : 'N/A' }}</td>
                        <td>{{ isset($product->price) ? number_format($product->price) : '0' }}₫</td>
                        <td>{{ isset($product->sale_price) && $product->sale_price ? number_format($product->sale_price) . '₫' : '-' }}</td>
                        <td>{{ isset($product->quantity) ? $product->quantity : 0 }}</td>
                        <td>
                            @php $qty = isset($product->quantity) ? $product->quantity : 0; @endphp
                            <span class="badge bg-{{ $qty > 0 ? 'success' : 'danger' }}">
                                {{ $qty > 0 ? 'Còn hàng' : 'Hết hàng' }}
                            </span>
                        </td>
                        <td>
                            @if(isset($product->id))
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.products.show', $product->id) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc muốn xóa?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @endif
                    @empty
                    <tr>
                        <td colspan="9" class="text-center">Không có sản phẩm nào</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if(isset($products) && method_exists($products, 'links'))
            <div class="d-flex justify-content-between align-items-center mt-3">
                <div class="text-muted">
                    Hiển thị {{ $products->firstItem() ?? 0 }} - {{ $products->lastItem() ?? 0 }} 
                    trong tổng số {{ $products->total() ?? 0 }} sản phẩm
                </div>
                <div>
                    {{ $products->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        @endif
    </div>
</div>
@endsection