@extends('layouts.client')

@section('title', 'Sản phẩm mới')

@section('content')
<main class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6 text-left">HÀNG MỚI VỀ</h2>

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
                <div class="flex items-center justify-between mt-2">
                    <p class="text-black font-bold text-2xl">450,000đ</p>
                    <p class="text-gray-500 text-xl line-through">550,000đ</p>
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
                <p class="text-black font-bold text-2xl mt-2">680,000đ</p>
                <button class="mt-4 w-full px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-700">Xem chi tiết</button>
            </div>
        </div>

        <!-- Kính -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden relative">
            <img src="{{ asset('images/glasses.png') }}" alt="Kính" class="w-full h-64 object-cover">
            <div class="absolute top-2 left-2">
                <span class="bg-green-500 text-white text-sm font-semibold px-2 py-1 rounded">Mới</span>
            </div>
            <div class="absolute top-2 right-2">
                <span class="bg-red-500 text-white text-sm font-semibold px-2 py-1 rounded">Sale</span>
            </div>
            <div class="p-4">
                <h3 class="text-lg font-semibold">Balenciaga Glasses</h3>
                <div class="flex items-center justify-between mt-2">
                    <p class="text-black font-bold text-2xl">180,000đ</p>
                    <p class="text-gray-500 text-xl line-through">630,000đ</p>
                </div>
                <button class="mt-4 w-full px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-700">Xem chi tiết</button>
            </div>
        </div>

        <!-- Vòng Tay -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden relative">
            <img src="{{ asset('images/bracelet.png') }}" alt="Vòng Tay" class="w-full h-64 object-cover">
            <div class="absolute top-2 left-2">
                <span class="bg-green-500 text-white text-sm font-semibold px-2 py-1 rounded">Mới</span>
            </div>
            <div class="p-4">
                <h3 class="text-lg font-semibold">Vivienne Westwood Bracelet 08</h3>
                <p class="text-black font-bold text-2xl mt-2">4,400,000đ</p>
                <button class="mt-4 w-full px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-700">Xem chi tiết</button>
            </div>
        </div>
    </div>
</main>
@endsection
