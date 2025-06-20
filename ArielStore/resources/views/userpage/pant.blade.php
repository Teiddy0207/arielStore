@extends('layouts.client')

@section('title', 'Quần')

@section('content')
<main class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6 text-left">QUẦN</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Product Card 1 -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden relative">
            <img src="{{ asset('images/skinnyjeans.png') }}" alt="Quần Skinny Jeans" class="w-full h-64 object-cover">
            <div class="absolute top-2 left-2">
                <span class="bg-green-500 text-white text-sm font-semibold px-2 py-1 rounded">Mới</span>
            </div>
            <div class="p-4">
                <h3 class="text-lg font-semibold">Quần Skinny Jeans</h3>
                <p class="text-black font-bold text-2xl">680,000đ</p>
                <a href="{{ route('userpage.product', 2) }}" 
                    class="mt-4 block w-full px-4 py-2 bg-black text-white text-center text-base font-semibold rounded-lg hover:bg-gray-700">
                    Xem chi tiết
                </a>
            </div>
        </div>
    </div>
</main>
@endsection
