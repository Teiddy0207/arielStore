@extends('layouts.client')

@section('title', 'Áo')

@section('content')
<main class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6 text-left">PHỤ KIỆN</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($products as $product)
        <div class="bg-white shadow-md rounded-lg overflow-hidden relative">
            @if($product->images->isNotEmpty())
                <img src="{{ asset('storage/' . $product->images->first()->filename) }}" alt="{{ $product->name }}" class="w-full h-64 object-cover">
            @else
                <img src="{{ asset('images/d&g.jpg') }}" alt="{{ $product->name }}" class="w-full h-64 object-cover">
            @endif
            
            @if($product->sale > 0)
                <div class="absolute top-2 right-2">
                    <span class="bg-red-500 text-white text-sm font-semibold px-2 py-1 rounded">Sale {{ $product->sale }}%</span>
                </div>
            @endif
            
            <div class="p-4">
                <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                @if($product->sale > 0)
                    <div class="flex justify-between mt-2">
                        <p class="text-black font-bold text-2xl">{{ number_format($product->price, 0, ',', '.') }}đ</p>
                        <p class="text-gray-500 line-through text-sm">{{ number_format($product->import_price, 0, ',', '.') }}đ</p>
                    </div>
                @else
                    <p class="text-black font-bold text-2xl">{{ number_format($product->price, 0, ',', '.') }}đ</p>
                @endif
                <a href="{{ route('userpage.product', $product->id) }}" 
                    class="mt-4 block w-full px-4 py-2 bg-black text-white text-center text-base font-semibold rounded-lg hover:bg-gray-700">
                    Xem chi tiết
                </a>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-8">
            <p class="text-gray-500 text-lg">Không có sản phẩm phụ kiện nào</p>
        </div>
        @endforelse
    </div>
</main>
@endsection