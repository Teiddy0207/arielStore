@extends('layouts.app')

@section('title', 'Quản lý sản phẩm')

@section('content')
<style>
    .bg-custom {
        background-color: #2C3E50 !important;
        color: white;
    }
</style>
<div style="background-color: #2C3E50; padding: 11px;" class="mb-1">
    <h4 style="color: white;">
        <i class="bi bi-box-seam" style="font-size: 24px; padding-left: 20px;"></i>
        Quản lý sản phẩm
    </h4>
</div>

<div class="container">
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Tìm kiếm & lọc --}}
    <div class="card p-3 mb-1">
        <h5><i class="fas fa-search text-dark"></i> Tìm kiếm & Lọc</h5>
        <form method="GET" action="{{ route('products.index') }}" class="row g-3 align-items-end">
            <div class="col-md-4" style="flex: 1">
                <label for="search" class="form-label"><i class="fas fa-search text-dark"></i> Tìm kiếm:</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" class="form-control" placeholder="Tìm kiếm theo mã, tên,...">
            </div>
            <div class="col-md-4" style="flex: 1">
                <label for="status" class="form-label"><i class="fas fa-filter me-1"></i> Lọc theo trạng thái:</label>
                <select name="status" id="status" class="form-select">
                    <option value="">Tất cả trạng thái</option>
                    <option value="Đang bán" {{ request('status') == 'Đang bán' ? 'selected' : '' }}>Đang bán</option>
                    <option value="Hết hàng" {{ request('status') == 'Hết hàng' ? 'selected' : '' }}>Hết hàng</option>
                    <option value="Ngừng bán" {{ request('status') == 'Ngừng bán' ? 'selected' : '' }}>Ngừng bán</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-outline-dark fw-semibold w-100">Tìm kiếm</button>
            </div>
        </form>
    </div>

    {{-- Bảng danh sách sản phẩm --}}
    <div class="table-responsive card p-3 mb-1">
        <div class="d-flex justify-content-between mb-1">
            <h4 class="mb-0"><i class="bi bi-list-ul"></i> Danh sách sản phẩm</h4>
            <a href="{{ route('products.create') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Thêm sản phẩm
            </a>
        </div>
        
        <table class="table table-bordered table-hover align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>Mã SP</th>
                    <th>Tên sản phẩm</th>
                    <th>Danh mục</th>
                    <th>Giá bán</th>
                    <th>Tồn kho</th>
                    <th>Kích thước</th>
                    <th>Ngày tạo</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->name }}</td>
                    <td>{{ $p->category }}</td>
                    <td>{{ number_format($p->price, 0, ',', '.') }}</td>
                    <td>{{ $p->quantity }}</td>
                    <td>{{ $p->size }}</td>
                    <td>{{ ($p->created_at)->format('d/m/Y') }}</td>
                    <td>
                        @if($p->status === 'Đang bán')
                            <span class="badge bg-success">{{ $p->status }}</span>
                        @elseif($p->status === 'Hết hàng')
                            <span class="badge bg-danger">{{ $p->status }}</span>
                        @else
                            <span class="badge bg-custom">{{ $p->status }}</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('products.show', $p->id) }}" class="btn btn-sm btn-primary ">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('products.edit', $p->id) }}" class="btn btn-sm btn-warning ms-3 me-3">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <button class="btn btn-danger btn-sm delete-btn " data-id="{{ $p->id }}" data-name="{{ $p->name }}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-4 text-gray-500">Không tìm thấy sản phẩm nào</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Modal Xác nhận xóa -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">
                            <i class="bi bi-trash btn" style="font-size: 2rem; "></i> Xác nhận xóa sản phẩm
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="ps-3"><strong>Bạn có chắc chắn muốn xóa sản phẩm này?</strong></p>
                            <div class="card p-3 bg-light">
                            <p class="mb-2 ps-3">
                                <strong>Mã sản phẩm:</strong> <strong><span id="modal-product-id"></span></strong>
                            </p>
                            <p class="mb-2 ps-3">
                                <strong>Tên sản phẩm:</strong> <span id="modal-product-name"></span>
                            </p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <form id="deleteForm" action="" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Xóa</button>
                        </form>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Phân trang -->
        <div class="d-flex justify-content-end">
            {{ $products->links('pagination::bootstrap-4') }}
        </div>
        
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.querySelectorAll('.delete-btn').forEach(button => {
        button.addEventListener('click', function () {
            const productId = this.getAttribute('data-id');
            const productName = this.getAttribute('data-name');
            
            // Cập nhật nội dung modal
            document.getElementById('modal-product-id').textContent = productId;
            document.getElementById('modal-product-name').textContent = productName;
            document.getElementById('deleteForm').action = `/products/${productId}`;

            // Hiển thị modal
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        });
    });
</script>
@endsection
