<header class="bg-white shadow-sm p-2">
    <div class="container py-4">
        
        <!-- Logo -->
        <div class="d-flex justify-content-center mb-4">
            <img src="{{ asset('images/logoAeriel.png') }}" alt="Logo" style="height: 50px;">
        </div>

        <!-- Navigation + Icons -->
        <div class="d-flex justify-content-between align-items-center">
            
            <!-- Search Icon -->
            <button class="btn btn-link text-secondary p-0">
                <i class="fas fa-search"></i>
            </button>

            <!-- Navigation Menu -->
            <nav class="d-flex gap-4">
                <!-- Dropdown Danh mục -->
                <div class="dropdown">
                    <a class="dropdown-toggle text-secondary text-decoration-none" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Danh mục
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('userpage.shirt') }}">Áo</a></li>
                        <li><a class="dropdown-item" href="{{ route('userpage.pant') }}">Quần</a></li>
                        <li><a class="dropdown-item" href="{{ route('userpage.skirt') }}">Váy</a></li>
                        <li><a class="dropdown-item" href="{{ route('userpage.accessories') }}">Phụ kiện</a></li>
                    </ul>
                </div>

                <!-- Các mục khác -->
                <a href="{{ route('userpage.all') }}" class="text-secondary text-decoration-none">Tất cả sản phẩm</a>
                <a href="{{ route('userpage.sale') }}" class="text-secondary text-decoration-none">Sale off</a>
                <a href="{{ route('userpage.new') }}" class="text-secondary text-decoration-none">Hàng mới về</a>
            </nav>


            <!-- Cart Icon -->
            <button class="btn btn-link text-secondary p-0">
                <i class="fas fa-shopping-cart"></i>
            </button>
        </div>
    </div>
</header>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
