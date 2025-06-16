@extends('layouts.client')

@section('title', 'Tất cả sản phẩm')

@section('content')
<main class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6 text-left">TẤT CẢ SẢN PHẨM</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Váy Hoa Vintage -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden relative">
            <img src="{{ asset('images/vayhela.png') }}" alt="Váy Hoa Vintage" class="w-full h-64 object-cover">
            <div class="absolute top-2 left-2">
                <span class="bg-green-500 text-white text-sm font-semibold px-2 py-1 rounded">Mới</span>
            </div>
            <div class="absolute top-2 right-2">
                <span class="bg-red-500 text-white text-sm font-semibold px-2 py-1 rounded">Sale</span>
            </div>
            <div class="p-4">
                <h3 class="text-lg font-semibold">Váy Hoa Vintage</h3>
                <div class="flex justify-between mt-2">
                    <p class="text-black font-bold text-2xl">450,000đ</p>
                    <p class="text-gray-500 line-through text-sm">600,000đ</p>
                </div>
                <button class="mt-4 w-full px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-700">Xem chi tiết</button>
            </div>
        </div>

        <!-- Quần Skinny Jeans -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden relative">
            <img src="{{ asset('images/skinnyjeans.png') }}" alt="Quần Skinny Jeans" class="w-full h-64 object-cover">
            <div class="absolute top-2 left-2">
                <span class="bg-green-500 text-white text-sm font-semibold px-2 py-1 rounded">Mới</span>
            </div>
            <div class="p-4">
                <h3 class="text-lg font-semibold">Quần Skinny Jeans</h3>
                <p class="text-black font-bold text-2xl">680,000đ</p>
                <button class="mt-4 w-full px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-700">Xem chi tiết</button>
            </div>
        </div>

        <!-- Áo Thun Basic -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden relative">
            <img src="{{ asset('images/lv.jpg') }}" alt="Áo Thun Basic" class="w-full h-64 object-cover">
            <div class="absolute top-2 right-2">
                <span class="bg-red-500 text-white text-sm font-semibold px-2 py-1 rounded">Sale</span>
            </div>
            <div class="p-4">
                <h3 class="text-lg font-semibold">Áo Thun Basic</h3>
                <div class="flex justify-between mt-2">
                    <p class="text-black font-bold text-2xl">360,000đ</p>
                    <p class="text-gray-500 line-through text-sm">500,000đ</p>
                </div>
                <button class="mt-4 w-full px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-700">Xem chi tiết</button>
            </div>
        </div>

        <!-- Áo Sơ Mi Trắng -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden relative">
            <img src="{{ asset('images/d&g.jpg') }}" alt="Áo Sơ Mi Trắng" class="w-full h-64 object-cover">
            <div class="p-4">
                <h3 class="text-lg font-semibold">Áo Sơ Mi Trắng</h3>
                <p class="text-black font-bold text-2xl">320,000đ</p>
                <button class="mt-4 w-full px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-700">Xem chi tiết</button>
            </div>
        </div>

        <!-- Kính Balenciaga -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden relative">
            <img src="{{ asset('images/glasses.png') }}" alt="Kính Balenciaga" class="w-full h-64 object-cover">
            <div class="absolute top-2 left-2">
                <span class="bg-green-500 text-white text-sm font-semibold px-2 py-1 rounded">Mới</span>
            </div>
            <div class="absolute top-2 right-2">
                <span class="bg-red-500 text-white text-sm font-semibold px-2 py-1 rounded">Sale</span>
            </div>
            <div class="p-4">
                <h3 class="text-lg font-semibold">Kính Balenciaga</h3>
                <div class="flex justify-between mt-2">
                    <p class="text-black font-bold text-2xl">180,000đ</p>
                    <p class="text-gray-500 line-through text-sm">250,000đ</p>
                </div>
                <button class="mt-4 w-full px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-700">Xem chi tiết</button>
            </div>
        </div>

        <!-- Giày Nike Air Jordan -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden relative">
            <img src="{{ asset('images/shoes.png') }}" alt="Giày Nike Air Jordan" class="w-full h-64 object-cover">
            <div class="absolute top-2 right-2">
                <span class="bg-red-500 text-white text-sm font-semibold px-2 py-1 rounded">Sale</span>
            </div>
            <div class="p-4">
                <h3 class="text-lg font-semibold">Giày Nike Air Jordan Low 1</h3>
                <div class="flex justify-between mt-2">
                    <p class="text-black font-bold text-2xl">3,600,000đ</p>
                    <p class="text-gray-500 line-through text-sm">4,000,000đ</p>
                </div>
                <button class="mt-4 w-full px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-700">Xem chi tiết</button>
            </div>
        </div>

        <!-- Vòng Vivienne Westwood -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden relative">
            <img src="{{ asset('images/bracelet.png') }}" alt="Vòng Vivienne Westwood" class="w-full h-64 object-cover">
            <div class="absolute top-2 left-2">
                <span class="bg-green-500 text-white text-sm font-semibold px-2 py-1 rounded">Mới</span>
            </div>
            <div class="p-4">
                <h3 class="text-lg font-semibold">Vòng Vivienne Westwood</h3>
                <p class="text-black font-bold text-2xl">4,400,000đ</p>
                <button class="mt-4 w-full px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-700">Xem chi tiết</button>
            </div>
        </div>

        <!-- Túi 13 de Marzo -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden relative">
            <img src="{{ asset('images/bag.png') }}" alt="Túi 13 de Marzo Bag" class="w-full h-64 object-cover">
            <div class="absolute top-2 right-2">
                <span class="bg-red-500 text-white text-sm font-semibold px-2 py-1 rounded">Sale</span>
            </div>
            <div class="p-4">
                <h3 class="text-lg font-semibold">Túi 13 de Marzo Bag</h3>
                <div class="flex justify-between mt-2">
                    <p class="text-black font-bold text-2xl">3,500,000đ</p>
                    <p class="text-gray-500 line-through text-sm">4,000,000đ</p>
                </div>
                <button class="mt-4 w-full px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-700">Xem chi tiết</button>
            </div>
        </div>

        <!-- Mũ Bucket Burberry -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden relative">
            <img src="{{ asset('images/hat.png') }}" alt="Mũ Bucket Burberry" class="w-full h-64 object-cover">
            <div class="p-4">
                <h3 class="text-lg font-semibold">Mũ Bucket Burberry</h3>
                <p class="text-black font-bold text-2xl">6,500,000đ</p>
                <button class="mt-4 w-full px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-700">Xem chi tiết</button>
            </div>
        </div>
    </div>
</main>
@endsection
