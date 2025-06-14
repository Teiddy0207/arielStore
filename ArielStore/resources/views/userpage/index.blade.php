@extends('layouts.client')

@section('title', 'Quản lý đơn hàng')

@section('content')

<body class="font-sans bg-gray-100">
    <!-- Header -->




    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <!-- Product Categories -->
        <section>
         <h2 class="text-2xl font-bold mb-6 text-center">Danh mục sản phẩm</h2>

<div class="grid grid-cols-1 md:grid-cols-2 gap-x-40 gap-y-20  p-5">
    <!-- Product Card 1 -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <img src="{{ asset('images/aoAriel.png') }}" alt="Áo" class="w-full h-150 object-cover">
        <div class="p-4">
            <div class="flex justify-center items-center gap-2">
                <h3 class="text-lg font-semibold">Áo</h3>
                <a href="#" class="text-black hover:underline">
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Product Card 2 -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <img src="{{ asset('images/aoAriel.png') }}" alt="Áo" class="w-full h-150 object-cover">
        <div class="p-4">
            <div class="flex justify-center items-center gap-2">
                <h3 class="text-lg font-semibold">Quần</h3>
                <a href="#" class="text-black hover:underline">
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Product Card 3 -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <img src="{{ asset('images/aoAriel.png') }}" alt="Áo" class="w-full h-150 object-cover">
        <div class="p-4">
            <div class="flex justify-center items-center gap-2">
                <h3 class="text-lg font-semibold">Váy</h3>
                <a href="#" class="text-black hover:underline">
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Product Card 4 -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <img src="{{ asset('images/aoAriel.png') }}" alt="Áo" class="w-full h-150 object-cover">
        <div class="p-4">
            <div class="flex justify-center items-center gap-2">
                <h3 class="text-lg font-semibold">Phụ kiện</h3>
                <a href="#" class="text-black hover:underline">
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>


        </section>

        <!-- Blog Posts -->
        <section class="mt-12">
            <h2 class="text-2xl font-bold mb-6">Blog Posts</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Blog Card -->
                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <img src="image-placeholder.jpg" alt="Blog 1" class="w-full h-32 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold">"Tủ đồ ốp lép của đời độc thân"</h3>
                        <p class="text-gray-500 text-sm">June 12, 2025</p>
                        <a href="#" class="text-blue-500 hover:underline mt-2 block">Đọc thêm</a>
                    </div>
                </div>

                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <img src="image-placeholder.jpg" alt="Blog 2" class="w-full h-32 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold">"Nhà tôi trải nghiệm mua sắm đồ hiệu"</h3>
                        <p class="text-gray-500 text-sm">June 11, 2025</p>
                        <a href="#" class="text-blue-500 hover:underline mt-2 block">Đọc thêm</a>
                    </div>
                </div>

                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                    <img src="image-placeholder.jpg" alt="Blog 3" class="w-full h-32 object-cover">
                    <div class="p-4">
                        <h3 class="text-lg font-semibold">"Điệu cười kỳ quặc của trào lưu"</h3>
                        <p class="text-gray-500 text-sm">June 10, 2025</p>
                        <a href="#" class="text-blue-500 hover:underline mt-2 block">Đọc thêm</a>
                    </div>
                </div>
            </div>
            <div class="mt-6 text-center">
                <button class="px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-700">View All</button>
            </div>
        </section>
    </main>

    <!-- Footer -->


</body>
@endsection