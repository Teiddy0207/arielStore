<!-- Sidebar -->
<style>
    .sidebar .nav-link {
        color: #333;
        padding: 10px 15px;
        border-radius: 5px;
        transition: background-color 0.2s;
    }

    .sidebar .nav-link:hover {
        background-color: #2C3E50;
        color: #ffffff;
    }

    .sidebar .nav-link.active {
        background-color: #2C3E50;
        color: #ffffff !important;
    }
</style>

<div class="sidebar bg-white border-end" style="width: 200px; min-height: 100vh; padding: 20px;">
    <ul class="nav flex-column">
        <li class="nav-item mb-2">
            <a href="{{ route('dashboard.index') }}" class="nav-link {{ Route::is('dashboard.index') ? 'active' : '' }}">
                Trang chủ
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('orders.index') }}" class="nav-link {{ Route::is('orders.index') ? 'active' : '' }}">
                Quản lý đơn hàng
            </a>
        </li>

        <li class="nav-item mb-2">
            <a  class="nav-link {{ Route::is('products.*') ? 'active' : '' }}">
                Quản lý sản phẩm
            </a>
        </li>

        <li class="nav-item mb-2">
            <a  class="nav-link {{ Route::is('employees.*') ? 'active' : '' }}">
                Quản lý nhân viên
            </a>
        </li>

        <li class="nav-item">
            <a  class="nav-link {{ Route::is('reports.*') ? 'active' : '' }}">
                Báo cáo doanh thu
            </a>
        </li>
    </ul>
</div>
