@extends('layouts.app')
@section('title', 'Quản Lý Nhân Viên')
@push('css')
<style>
    /* 3 màu chính mới (không tính trắng và xám nhạt):
           1. Xanh dương đậm (#2c3e50) - Màu chủ đạo
           2. Xanh ngọc (#1abc9c) - Màu nhấn mạnh tích cực
           3. Cam đỏ (#e74c3c) - Màu cảnh báo
        */

    body {
        background-color: #f8f9fa;
    }

    .header-section {
        background-color: #2c3e50;
        color: #ffffff;
        padding: 13px 0;
        margin-bottom: 1.5rem;
    }

    .card {
        background-color: #ffffff;
        border: 1px solid #f8f9fa;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .btn-action {
        padding: 0.25rem 0.5rem;
        margin: 0 0.125rem;
    }

    .table th {
        background-color: #f8f9fa;
        border-top: none;
        font-weight: 600;
        color: #2c3e50;
    }

    .form-label {
        font-weight: 500;
        color: #2c3e50;
    }

    .btn-primary {
        background-color: #2c3e50;
        border-color: #2c3e50;
    }

    .btn-primary:hover {
        background-color: #1e2b37;
        border-color: #1e2b37;
    }

    .btn-outline-secondary {
        border-color: #2c3e50;
        color: #2c3e50;
    }

    .btn-outline-secondary:hover {
        background-color: #2c3e50;
        border-color: #2c3e50;
        color: #ffffff;
    }

    .btn-outline-danger {
        border-color: #e74c3c;
        color: #e74c3c;
    }

    .btn-outline-danger:hover {
        background-color: #e74c3c;
        border-color: #e74c3c;
        color: #ffffff;
    }

    .btn-outline-primary {
        border-color: #2c3e50;
        color: #2c3e50;
    }

    .btn-outline-primary:hover {
        background-color: #2c3e50;
        border-color: #2c3e50;
        color: #ffffff;
    }

    .btn-success {
        background-color: #1abc9c;
        border-color: #1abc9c;
    }

    .btn-success:hover {
        background-color: #16a085;
        border-color: #16a085;
    }

    .btn-danger {
        background-color: #e74c3c;
        border-color: #e74c3c;
    }

    .btn-danger:hover {
        background-color: #c0392b;
        border-color: #c0392b;
    }

    .btn-secondary {
        background-color: #f8f9fa;
        border-color: #f8f9fa;
        color: #2c3e50;
    }

    .alert-success {
        background-color: #f8f9fa;
        border-color: #1abc9c;
        color: #1abc9c;
    }

    .alert-danger {
        background-color: #f8f9fa;
        border-color: #e74c3c;
        color: #e74c3c;
    }

    .text-danger {
        color: #e74c3c !important;
    }

    .text-muted {
        color: #7f8c8d !important;
    }

    .modal-header {
        background-color: #ffffff;
        border-bottom: 1px solid #f8f9fa;
    }

    .modal-body {
        background-color: #ffffff;
    }

    .modal-footer {
        background-color: #ffffff;
        border-top: 1px solid #f8f9fa;
    }

    .alert-light {
        background-color: #f8f9fa;
        border-color: #2c3e50;
        color: #2c3e50;
    }

    .card-header {
        background-color: #f8f9fa !important;
        border-bottom: 1px solid #e9ecef;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #2c3e50;
        box-shadow: 0 0 0 0.25rem rgba(44, 62, 80, 0.25);
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fa;
    }

    .avatar-sm {
        background-color: #2c3e50 !important;
    }

    /* Màu cho các badge vai trò */
    .badge-role.manager {
        background-color: #e74c3c !important;
    }

    .badge-role.leader {
        background-color: #2c3e50 !important;
    }

    .badge-role.employee {
        background-color: #1abc9c !important;
    }

    .badge {
        font-weight: 500;
        padding: 0.35em 0.65em;
    }

    .bg-primary {
        background-color: #2c3e50 !important;
    }

    .bg-danger {
        background-color: #e74c3c !important;
    }

    .bg-success {
        background-color: #1abc9c !important;
    }

    .btn-lock {
        transition: all 0.2s ease;
    }

    .btn-lock.locked {
        background-color: #e74c3c;
        border-color: #e74c3c;
        color: white;
    }

    .btn-lock.locked:hover {
        background-color: #1abc9c;
        border-color: #1abc9c;
    }

    .btn-lock.unlocked {
        background-color: #1abc9c;
        border-color: #1abc9c;
        color: white;
    }

    .btn-lock.unlocked:hover {
        background-color: #e74c3c;
        border-color: #e74c3c;
    }
</style>
@endpush
@section('content')
<!-- Header -->
<div class="header-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="mb-0">
                    <i class="fas fa-users me-2"></i>
                    Quản Lý Nhân Viên
                </h4>
            </div>
        </div>
    </div>
</div>

<div class="container">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Tìm kiếm và lọc -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title mb-3">
                <i class="fas fa-search me-2"></i>
                Tìm Kiếm & Lọc
            </h5>
            <form method="GET" action="{{ route('employee.index') }}">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="search" class="form-label">
                            <i class="fas fa-search me-1"></i>
                            Tìm kiếm:
                        </label>
                        <input type="text" class="form-control" name="search" id="search"
                            value="{{ request('search') }}"
                            placeholder="Tìm theo ID, tên, email...">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="role" class="form-label">
                            <i class="fas fa-filter me-1"></i>
                            Lọc theo vai trò:
                        </label>
                        <select class="form-select" name="role" id="role">
                            <option value="">Tất cả vai trò</option>
                            <option value="Quản lý" {{ request('role') == 'Quản lý' ? 'selected' : '' }}>Quản lý</option>
                            <option value="Nhân viên kho" {{ request('role') == 'Nhân viên kho' ? 'selected' : '' }}>Nhân viên kho</option>
                            <option value="Nhân viên bán hàng" {{ request('role') == 'Nhân viên bán hàng' ? 'selected' : '' }}>Nhân viên bán hàng</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-outline-secondary w-100">
                            <i class="fas fa-search me-1"></i>
                            Tìm kiếm
                        </button>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Hiển thị {{ $employees->count() }} / {{ $totalCount }} nhân viên
                        </small>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Bảng danh sách nhân viên -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0">
                    <i class="fas fa-list me-2"></i>
                    Danh Sách Nhân Viên
                </h5>
                <div>
                    <span class="badge bg-primary me-2">{{ $totalCount }} nhân viên</span>
                    <a href="{{ route('employee.create') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-user-plus me-1"></i>
                        Thêm Nhân Viên
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Mã NV</th>
                            <th>Tên Nhân Viên</th>
                            <th>Email</th>
                            <th>Ngày Sinh</th>
                            <th>Địa Chỉ</th>
                            <th>Vai Trò</th>
                            <th class="text-center">Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                            <tr>
                                <td><strong>{{ $employee->id }}</strong></td>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->email }}</td>
                                <td>{{ $employee->formatted_birthday }}</td>
                                <td>{{ $employee->address }}</td>
                                <td>
                                    <span class="badge badge-role {{ $employee->role_badge_class }}">
                                        {{ $employee->role }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('employee.edit', $employee) }}" 
                                       class="btn btn-outline-primary btn-sm btn-action" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button class="btn btn-sm btn-action btn-lock {{ $employee->is_active ? 'unlocked' : 'locked' }}" 
                                            onclick="toggleActive({{ $employee->id }}, '{{ $employee->name }}', {{ $employee->is_active ? 'true' : 'false' }})" 
                                            title="{{ $employee->is_active ? 'Tạm khóa' : 'Kích hoạt' }}">
                                        <i class="fas fa-{{ $employee->is_active ? 'lock' : 'unlock' }}"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">
                                    <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                    {{ request()->hasAny(['search', 'role']) ? 'Không tìm thấy nhân viên phù hợp' : 'Chưa có nhân viên nào' }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal xác nhận -->
<form id="toggleForm" action="" method="POST" style="display: none;">
    @csrf
    @method('PATCH')
</form>
<div class="modal fade" id="confirmModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">
                    <i class="fas fa-lock me-2"></i>
                    Xác Nhận
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center">
                <h6 class="mb-3" id="modalQuestion"></h6>
                <div class="alert alert-light border mb-3" id="employeeInfo"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" id="confirmBtn">
                    <i class="fas fa-lock me-1"></i>
                    <span id="confirmText">Khóa</span>
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>
                    Hủy
                </button>
            </div>
        </div>
    </div>
</div>
<!-- Form ẩn để submit -->
<form id="toggleForm" action="" method="POST" style="display: none;">
    @csrf
    @method('PATCH')
</form>
@endsection

@push('js')
<script>
let currentEmployeeId = null;
let currentEmployeeName = '';
let currentIsActive = false;

function toggleActive(employeeId, employeeName, isActive) {
    currentEmployeeId = employeeId;
    currentEmployeeName = employeeName;
    currentIsActive = isActive;
    
    showConfirm();
}

function showConfirm() {
    const modalTitle = document.getElementById('modalTitle');
    const modalQuestion = document.getElementById('modalQuestion');
    const confirmBtn = document.getElementById('confirmBtn');
    const employeeInfo = document.getElementById('employeeInfo');

    if (currentIsActive) {
        modalTitle.innerHTML = '<i class="fas fa-lock me-2"></i>Xác Nhận Khóa';
        modalQuestion.textContent = 'Bạn có chắc chắn muốn khóa tài khoản nhân viên này?';
        confirmBtn.className = 'btn btn-danger';
        confirmBtn.innerHTML = '<i class="fas fa-lock me-1"></i><span>Khóa</span>';
    } else {
        modalTitle.innerHTML = '<i class="fas fa-unlock me-2"></i>Xác Nhận Mở Khóa';
        modalQuestion.textContent = 'Bạn có chắc chắn muốn mở khóa tài khoản nhân viên này?';
        confirmBtn.className = 'btn btn-success';
        confirmBtn.innerHTML = '<i class="fas fa-unlock me-1"></i><span>Mở khóa</span>';
    }

    employeeInfo.innerHTML = `
        <div class="row text-start">
            <div class="col-4"><strong>ID:</strong></div>
            <div class="col-8">#${currentEmployeeId}</div>
            <div class="col-4"><strong>Tên:</strong></div>
            <div class="col-8">${currentEmployeeName}</div>
            <div class="col-4"><strong>Trạng thái:</strong></div>
            <div class="col-8">
                <span class="badge ${currentIsActive ? 'bg-success' : 'bg-danger'}">
                    ${currentIsActive ? 'Hoạt động' : 'Đang khóa'}
                </span>
            </div>
        </div>
    `;

    new bootstrap.Modal(document.getElementById('confirmModal')).show();
}


document.getElementById('confirmBtn').addEventListener('click', function() {
    if (currentEmployeeId) {
        const form = document.getElementById('toggleForm');
        form.action = `/employee/${currentEmployeeId}/toggle-active`;
        form.submit();
        bootstrap.Modal.getInstance(document.getElementById('confirmModal')).hide();
    }
});
</script>
@endpush