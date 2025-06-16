
<!-- Sidebar -->
<style>
    .sidebar {
        background-color: #f8f9fa;
        border-right: 1px solid #e9ecef;
        width: 220px;
        min-height: 100vh;
        padding: 0;
    }



    .sidebar-menu {
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .sidebar-menu .nav-item {
        border-bottom: 1px solid #e9ecef;
    }

    .sidebar-menu .nav-link {
        display: block;
        padding: 15px 20px;
        text-decoration: none;
        font-weight: 500;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        border: none;
        background: none;
    }

    .sidebar-menu .nav-link:hover {
        background-color: #e9ecef;
        color: #2c3e50;
        text-decoration: none;
    }

    .sidebar-menu .nav-link.active {
        background-color: #2c3e50;
        color: #ffffff !important;
        font-weight: 600;
    }


    .sidebar-menu .nav-item {
        position: relative;
    }
</style>

<div class="sidebar">
    <ul class="sidebar-menu">
        <li class="nav-item">
            <a href="{{ route('dashboard.index') }}" class="nav-link {{ Route::is('dashboard.index') ? 'active' : '' }}">
                Trang chủ
            </a>
        </li>

        <li class="nav-item">
            <a href="" class="nav-link">
                Quản lý sản phẩm
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('orders.index') }}" class="nav-link {{ Route::is('orders.*') ? 'active' : '' }}">
                Quản lý đơn hàng
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('employee.index') }}" class="nav-link {{ Route::is('employee.*') ? 'active' : '' }}">
                Quản lý nhân viên
            </a>
        </li>

        <li class="nav-item">
            <a href="" class="nav-link">
                Báo cáo doanh thu
            </a>
        </li>
    </ul>
</div>