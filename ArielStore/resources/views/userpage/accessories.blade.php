@extends('layouts.client')

@section('title', 'Phụ kiện')

@section('content')
<main class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6 text-left">PHỤ KIỆN</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Product Card 1 -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden relative">
            <!-- Product Image -->
            <img src="{{ asset('images/glasses.png') }}" alt="Balenciaga Glasses" class="w-full object-cover h-64">
            
            <!-- Labels -->
            <div class="absolute top-2 left-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded">Mới</div>
            <div class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">Sale</div>
            
            <!-- Product Details -->
            <div class="p-4">
                <h3 class="text-lg font-semibold">Balenciaga Glasses</h3>
                <div class="flex items-center justify-between mt-2">
                    <p class="text-black font-bold text-3xl">180,000đ</p>
                    <p class="text-gray-500 text-lg line-through">350,000đ</p>
                </div>
                <button class="mt-4 w-full px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-700 text-center">
                    Xem chi tiết
                </button>
            </div>
        </div>

        <!-- Product Card 2 -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden relative">
            <!-- Product Image -->
            <img src="{{ asset('images/jd1.png') }}" alt="Giày Nike Air Jordan Low 1" class="w-full object-cover h-64">
            
            <!-- Labels -->
            <div class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">Sale</div>
            
            <!-- Product Details -->
            <div class="p-4">
                <h3 class="text-lg font-semibold">Giày Nike Air Jordan Low 1</h3>
                <div class="flex items-center justify-between mt-2">
                    <p class="text-black font-bold text-3xl">3,600,000đ</p>
                    <p class="text-gray-500 text-lg line-through">3,800,000đ</p>
                </div>
                <button class="mt-4 w-full px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-700 text-center">
                    Xem chi tiết
                </button>
            </div>
        </div>

        <!-- Product Card 3 -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden relative">
            <!-- Product Image -->
            <img src="{{ asset('images/bracelet.png') }}" alt="Vivienne Westwood Bracelet 08" class="w-full object-cover h-64">
            
            <!-- Labels -->
            <div class="absolute top-2 left-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded">Mới</div>
            
            <!-- Product Details -->
            <div class="p-4">
                <h3 class="text-lg font-semibold">Vivienne Westwood Bracelet 08</h3>
                <div class="flex items-center justify-between mt-2">
                    <p class="text-black font-bold text-3xl">4,400,000đ</p>
                </div>
                <button class="mt-4 w-full px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-700 text-center">
                    Xem chi tiết
                </button>
            </div>
        </div>

        <!-- Product Card 4 -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden relative">
            <!-- Product Image -->
            <img src="{{ asset('images/bag.png') }}" alt="Prada Bag" class="w-full object-cover h-64">
            
            <!-- Labels -->
            <div class="absolute top-2 right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded">Sale</div>
            
            <!-- Product Details -->
            <div class="p-4">
                <h3 class="text-lg font-semibold">Prada Bag</h3>
                <div class="flex items-center justify-between mt-2">
                    <p class="text-black font-bold text-3xl">2,500,000đ</p>
                    <p class="text-gray-500 text-lg line-through">3,000,000đ</p>
                </div>
                <button class="mt-4 w-full px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-700 text-center">
                    Xem chi tiết
                </button>
            </div>
        </div>

        <!-- Product Card 5 -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden relative">
            <!-- Product Image -->
            <img src="{{ asset('images/hat.png') }}" alt="Rolex Watch" class="w-full object-cover h-64">
            
            <!-- Product Details -->
            <div class="p-4">
                <h3 class="text-lg font-semibold">Burbery Bucket Hat 01</h3>
                <div class="flex items-center justify-between mt-2">
                    <p class="text-black font-bold text-3xl">6,500,000đ</p>
                </div>
                <button class="mt-4 w-full px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-700 text-center">
                    Xem chi tiết
                </button>
            </div>
        </div>
    </div>
</main>
@endsection
