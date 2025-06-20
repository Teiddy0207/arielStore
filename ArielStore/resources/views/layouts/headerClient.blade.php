<header class="bg-white shadow-sm p-2">
    <div class="container py-4">
        
        <!-- Logo -->
        <div class="d-flex justify-content-center mb-4">
            <a href="{{ route('userpage.index') }}"> 
                <img src="{{ asset('images/logoAeriel.png') }}" alt="Logo" style="height: 50px;">
            </a>
        </div>

        <!-- Navigation + Icons -->
        <div class="d-flex justify-content-between align-items-center">
            
            <!-- Search Form -->
            <div class="d-flex align-items-center" style="flex: 1;">
                <form action="{{ route('userpage.search') }}" method="GET" class="d-flex align-items-center gap-2">
                    <input 
                        type="text" 
                        name="query" 
                        placeholder="Tìm kiếm sản phẩm..." 
                        class="form-control"
                        style="width: 250px;">
                    <button type="submit" class="btn btn-dark">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>

            <!-- Navigation Menu - Centered -->
            <nav class="d-flex justify-content-center gap-4" style="flex: 2;">
                <!-- Dropdown Danh mục -->
                <div class="dropdown">
                    <a class="dropdown-toggle text-secondary text-decoration-none fw-semibold" 
                       href="#" 
                       role="button" 
                       data-bs-toggle="dropdown" 
                       aria-expanded="false">
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
                <a href="{{ route('userpage.all') }}" 
                   class="text-secondary text-decoration-none fw-semibold">
                   Tất cả sản phẩm
                </a>
                <a href="{{ route('userpage.sale') }}" 
                   class="text-secondary text-decoration-none fw-semibold">
                   Sale off
                </a>
                <a href="{{ route('userpage.new') }}" 
                   class="text-secondary text-decoration-none fw-semibold">
                   Hàng mới về
                </a>
            </nav>

            <!-- Cart Icon -->
            <div class="d-flex justify-content-end" style="flex: 1;">
                <a href="{{ route('userpage.cart') }}" 
                   class="btn btn-dark">
                    <i class="fas fa-shopping-cart"></i>
                </a>
            </div>
        </div>
    </div>
</header>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
