@extends('layouts.client')

@section('title', 'Sản phẩm giảm giá')

@section('content')
<main class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6 text-left">SALE OFF</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Váy Hoa Vintage -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden relative">
            <img src="{{ asset('images/vayhela.png') }}" alt="Váy Hoa Vintage" class="w-full h-64 object-cover">
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

        <!-- Vòng Tay -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden relative">
            <img src="{{ asset('images/bracelet.png') }}" alt="Vòng Tay" class="w-full h-64 object-cover">
            <div class="absolute top-2 right-2">
                <span class="bg-red-500 text-white text-sm font-semibold px-2 py-1 rounded">Sale</span>
            </div>
            <div class="p-4">
                <h3 class="text-lg font-semibold">Vòng Tay</h3>
                <div class="flex justify-between mt-2">
                    <p class="text-black font-bold text-2xl">120,000đ</p>
                    <p class="text-gray-500 line-through text-sm">200,000đ</p>
                </div>
                <button class="mt-4 w-full px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-700">Xem chi tiết</button>
            </div>
        </div>

        <!-- Túi Xách -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden relative">
            <img src="{{ asset('images/bag.png') }}" alt="Túi Xách" class="w-full h-64 object-cover">
            <div class="absolute top-2 right-2">
                <span class="bg-red-500 text-white text-sm font-semibold px-2 py-1 rounded">Sale</span>
            </div>
            <div class="p-4">
                <h3 class="text-lg font-semibold">Túi Xách</h3>
                <div class="flex justify-between mt-2">
                    <p class="text-black font-bold text-2xl">650,000đ</p>
                    <p class="text-gray-500 line-through text-sm">850,000đ</p>
                </div>
                <button class="mt-4 w-full px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-700">Xem chi tiết</button>
            </div>
        </div>

        <!-- Giày Thể Thao -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden relative">
            <img src="{{ asset('images/shoes.png') }}" alt="Giày Thể Thao" class="w-full h-64 object-cover">
            <div class="absolute top-2 right-2">
                <span class="bg-red-500 text-white text-sm font-semibold px-2 py-1 rounded">Sale</span>
            </div>
            <div class="p-4">
                <h3 class="text-lg font-semibold">Giày Thể Thao</h3>
                <div class="flex justify-between mt-2">
                    <p class="text-black font-bold text-2xl">990,000đ</p>
                    <p class="text-gray-500 line-through text-sm">1,200,000đ</p>
                </div>
                <button class="mt-4 w-full px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-700">Xem chi tiết</button>
            </div>
        </div>
    </div>
</main>
@endsection
