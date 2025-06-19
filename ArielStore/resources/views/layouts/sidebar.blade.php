
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
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .sidebar-menu .nav-item {
        border-bottom: 1px solid #e9ecef;
        position: relative;
    }
    .nav-link,
    .report-toggle {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding: 15px 20px;
        font-weight: 500;
        font-size: 0.95rem;
        text-decoration: none;
        color: #495057;
        background: none;
        border: none;
        cursor: pointer;
        transition: all 0.2s ease;
        text-align: left;
    }

    .nav-link:hover,
    .report-toggle:hover {
        background-color: #e9ecef;
        color: #2c3e50;
    }

    .nav-link.active,
    .report-toggle.active {
        background-color: #2c3e50;
        color: #ffffff !important;
        font-weight: 600;
    }

    .dropdown-menu {
        list-style: none;
        padding: 5px 0;
        margin: 0;
        display: none;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 8px 16px rgba(0,0,0,0.1);
        transition: all 0.3s ease;
    }

    .nav-link-sub {
        display: block;
        padding: 10px 30px;
        font-size: 0.9rem;
        font-weight: 500;
        color: #495057;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .nav-link-sub:hover {
        background-color: #e9ecef;
        color: #2c3e50;
        padding-left: 35px;
    }

    .nav-link-sub.active {
        background-color: #2c3e50;
        color: #fff !important;
    }

    .dropdown-toggle-arrow {
        margin-left: auto;
        padding-left: 10px;
        transition: transform 0.3s ease;
    }

    .rotate-180 {
        transform: rotate(180deg);
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
            <a href="{{ route('products.index') }}" class="nav-link {{ Route::is('products.*') ? 'active' : '' }}">
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
            <button id="reportDropdownToggle" class="nav-link report-toggle">
                <span>Báo cáo thống kê</span>
                <i id="dropdownArrow" class="fas fa-chevron-down dropdown-toggle-arrow"></i>
            </button>
            <ul id="reportDropdownMenu" class="dropdown-menu">
                <li>
                    <a href="{{ route('statistic.sales') }}" class="nav-link-sub {{ Route::is('statistic.sales') ? 'active' : '' }}">
                        Báo cáo bán hàng
                    </a>
                </li>
                <li><a href="{{ route('statistic.customer') }}" class="nav-link-sub {{ Route::is('statistic.customer') ? 'active' : '' }}">
                        Khách hàng
                    </a>
                </li>
                <li><a href="{{ route('statistic.inventory.months') }}" class="nav-link-sub {{ Route::is('statistic.inventory') ? 'active' : '' }}">
                        Thống kê kho hàng</a>
                </li>
            </ul>
        </li>
    </ul>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggle = document.getElementById("reportDropdownToggle");
        const menu = document.getElementById("reportDropdownMenu");
        const arrow = document.getElementById("dropdownArrow");

        toggle.addEventListener("click", function () {
            const isOpen = menu.style.display === "block";
            menu.style.display = isOpen ? "none" : "block";
            arrow.classList.toggle("rotate-180", !isOpen);
        });
    });
</script>


