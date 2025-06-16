@extends('layouts.app')
@section('title', 'Thêm Nhân Viên Mới')

@push('css')
<style>
    /* CSS giữ nguyên như cũ */
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

    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid #e9ecef;
        color: #2c3e50;
    }

    .form-label {
        font-weight: 500;
        color: #2c3e50;
    }

    .form-control,
    .form-select {
        border-color: #c5c5c5c5;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #2c3e50;
        box-shadow: 0 0 0 0.25rem rgba(44, 62, 80, 0.25);
    }

    .btn-primary {
        background-color: #2c3e50;
        border-color: #2c3e50;
    }

    .btn-primary:hover {
        background-color: #1e2b37;
        border-color: #1e2b37;
    }

    .btn-success {
        background-color: #1abc9c;
        border-color: #1abc9c;
    }

    .btn-success:hover {
        background-color: #16a085;
        border-color: #16a085;
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

    .btn-outline-dark {
        border-color: #2c3e50;
        color: #2c3e50;
    }

    .btn-outline-dark:hover {
        background-color: #2c3e50;
        border-color: #2c3e50;
        color: #ffffff;
    }

    .required-field::after {
        content: "*";
        color: #e74c3c;
        margin-left: 4px;
    }

    .password-toggle {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        background: none;
        border: none;
        color: #2c3e50;
        cursor: pointer;
        z-index: 10;
    }

    .password-toggle:hover {
        color: #1abc9c;
    }

    .invalid-feedback {
        color: #e74c3c;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: #e74c3c;
        box-shadow: 0 0 0 0.25rem rgba(231, 76, 60, 0.25);
    }

    .alert-danger {
        background-color: #f8f9fa;
        border-color: #e74c3c;
        color: #e74c3c;
    }

    .alert-success {
        background-color: #f8f9fa;
        border-color: #1abc9c;
        color: #1abc9c;
    }

    .text-danger {
        color: #e74c3c !important;
    }

    .text-success {
        color: #1abc9c !important;
    }

    .form-text {
        color: #6c757d;
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
                    Thêm Nhân Viên Mới
                </h4>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <!-- Alert Messages -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Form thêm nhân viên -->
    <div class="card mb-4">
        <div class="card-header py-3">
            <h5 class="mb-0">
                <i class="fas fa-info-circle me-2"></i>
                Thông Tin Nhân Viên
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('employee.store') }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label required-field">
                            <i class="fas fa-user me-1"></i>
                            Tên Nhân Viên:
                        </label>
                        <input type="text" 
                               class="form-control @error('name') is-invalid @enderror" 
                               id="name" 
                               name="name" 
                               value="{{ old('name') }}" 
                               >
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label required-field">
                            <i class="fas fa-envelope me-1"></i>
                            Email:
                        </label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               >
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label required-field">
                            <i class="fas fa-lock me-1"></i>
                            Mật Khẩu:
                        </label>
                        <div class="position-relative">
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   
                                   minlength="6">
                            <button type="button" class="password-toggle" onclick="togglePassword('password')">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                        <div class="form-text">Mật khẩu phải có ít nhất 6 ký tự</div>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="birthday" class="form-label required-field">
                            <i class="fas fa-calendar me-1"></i>
                            Ngày Sinh:
                        </label>
                        <input type="date" 
                               class="form-control @error('birthday') is-invalid @enderror" 
                               id="birthday" 
                               name="birthday" 
                               value="{{ old('birthday') }}" 
                               >
                        @error('birthday')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="role" class="form-label required-field">
                            <i class="fas fa-briefcase me-1"></i>
                            Vai Trò:
                        </label>
                        <select class="form-select @error('role') is-invalid @enderror" 
                                id="role" 
                                name="role" 
                                >
                            <option value="">Chọn vai trò</option>
                            <option value="Quản lý" {{ old('role') == 'Quản lý' ? 'selected' : '' }}>Quản lý</option>
                            <option value="Nhân viên bán hàng" {{ old('role') == 'Nhân viên bán hàng' ? 'selected' : '' }}>Nhân viên bán hàng</option>
                            <option value="Nhân viên kho" {{ old('role') == 'Nhân viên kho' ? 'selected' : '' }}>Nhân viên kho</option>
                        </select>
                        @error('role')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="address" class="form-label required-field">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            Địa Chỉ:
                        </label>
                        <input type="text" 
                               class="form-control @error('address') is-invalid @enderror" 
                               id="address" 
                               name="address" 
                               value="{{ old('address') }}" 
                               >
                        @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex gap-2 justify-content-end">
                    <button type="submit" class="btn btn-success">
                        Lưu Nhân Viên
                    </button>
                    <a href="{{ route('employee.index') }}" class="btn btn-outline-dark">
                        Quay Lại
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    function togglePassword(fieldId) {
        const passwordField = document.getElementById(fieldId);
        const toggleIcon = document.getElementById('toggleIcon');

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleIcon.className = 'fas fa-eye-slash';
        } else {
            passwordField.type = 'password';
            toggleIcon.className = 'fas fa-eye';
        }
    }

    // Auto hide alerts after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert-dismissible');
        alerts.forEach(function(alert) {
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 5000);
        });
    });
</script>
@endpush

