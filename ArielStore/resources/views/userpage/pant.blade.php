@extends('layouts.client')

@section('title', 'Quần')

@section('content')
<main class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6 text-left">QUẦN</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Product Card 1 -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden relative">
            <!-- New Label -->
            <div class="absolute top-2 left-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded">Mới</div>
            <!-- Product Image -->
            <img src="{{ asset('images/skinnyjeans.png') }}" alt="Quần Skinny Jeans" class="w-full object-cover h-64">

            <!-- Product Details -->
            <div class="p-4">
                <h3 class="text-lg font-semibold">Quần Skinny Jeans</h3>
                <div class="flex items-center justify-between mt-2">
                    <p class="text-black font-bold text-3xl">600,000đ</p>
                </div>
                <button class="mt-4 w-full px-4 py-2 bg-black text-white rounded-lg hover:bg-gray-700 text-center">
                    Xem chi tiết
                </button>
            </div>
        </div>
    </div>
</main>
@endsection
