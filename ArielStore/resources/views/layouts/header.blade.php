<!-- Header -->
<div class="header d-flex justify-content-between align-items-center p-5 bg-light shadow-sm" style="height: 80px;">
    {{-- Logo bên trái --}}
    <div class="d-flex align-items-center">
        <img src="{{ asset('images/logoAeriel.png') }}" alt="Logo" style="height: 50px;">
    </div>

    {{-- Thông tin người dùng bên phải --}}
<div class="d-flex align-items-center gap-3 dropdown">
    {{-- Avatar --}}
    <div class="rounded-circle text-white d-flex justify-content-center align-items-center" 
         style="width: 40px; height: 40px; font-weight: bold; background-color: #2C3E50">
        A
    </div>

    <div class="text-end dropdown-toggle" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;">
        <div class="fw-bold">Quang Anh</div>
        <div class="text-muted" style="font-size: small;">Quản trị viên </div>
    </div>

    <!-- Dropdown menu -->
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
        <li>
            <a class="dropdown-item text-danger" href="/logout">
                <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
            </a>
        </li>
    </ul>
</div>

</div>

