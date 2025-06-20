@extends('layouts.client')

@section('title', 'Áo')

@section('content')
<main class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6 text-left">ÁO</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Product Card 1 -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden relative">
            <img src="{{ asset('images/d&g.jpg') }}" alt="Áo Sơ Mi Trắng" class="w-full h-64 object-cover">
            <div class="p-4">
                <h3 class="text-lg font-semibold">Áo Sơ Mi Trắng</h3>
                <p class="text-black font-bold text-2xl">320,000đ</p>
                <a href="{{ route('userpage.product', 4) }}" 
                    class="mt-4 block w-full px-4 py-2 bg-black text-white text-center text-base font-semibold rounded-lg hover:bg-gray-700">
                    Xem chi tiết
                </a>
            </div>
        </div>

        <!-- Product Card 2 -->
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
                    <a href="{{ route('userpage.product', 3) }}" 
                    class="mt-4 block w-full px-4 py-2 bg-black text-white text-center text-base font-semibold rounded-lg hover:bg-gray-700">
                    Xem chi tiết
                </a>
            </div>
        </div>


        <!-- Add more product cards as needed -->
    </div>
</main>
@endsection