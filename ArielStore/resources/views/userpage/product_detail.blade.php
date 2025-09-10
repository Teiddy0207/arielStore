@extends('layouts.client')

@section('title', $product->name)

@section('content')
<main class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Product Images -->
        <div class="space-y-4">
            <!-- Main Product Image -->
            <img 
                src="{{ $product->images->isNotEmpty() ? asset('storage/' . $product->images->first()->filename) : asset('images/d&g.jpg') }}" 
                alt="{{ $product->name }}" 
                class="w-full h-auto object-cover rounded-lg shadow-md">
            
            <!-- Additional Images -->
            @if($product->images->count() > 1)
            <div class="grid grid-cols-4 gap-2">
                @foreach ($product->images->slice(1) as $img)
                    <img 
                        src="{{ asset('storage/' . $img->filename) }}" 
                        alt="Additional Image" 
                        class="w-full h-auto object-cover rounded-lg shadow">
                @endforeach
            </div>
            @endif
        </div>

        <!-- Product Details -->
        <div>
            <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>
            <p class="text-sm text-gray-600 mb-4">Loại: {{ optional($product->productType)->description ?? 'N/A' }}</p>

            <!-- Pricing -->
            <div class="text-2xl font-semibold text-black mb-4">
                {{ number_format($product->price, 0, ',', '.') }}đ
                @if ($product->sale && $product->import_price)
                    <span class="text-gray-500 line-through text-xl ml-2">
                        {{ number_format($product->import_price, 0, ',', '.') }}đ
                    </span>
                @endif
            </div>

            <!-- Material -->
            @if($product->material)
            <div class="mb-4">
                <span class="font-medium">Chất liệu:</span> {{ $product->material }}
            </div>
            @endif

            <!-- Size (hiển thị kích thước hiện có) -->
            @if($product->size)
            <div class="mb-4">
                <label class="block text-lg font-medium mb-2">Kích thước:</label>
                <span class="inline-block px-4 py-2 border rounded">{{ $product->size }}</span>
            </div>
            @endif

            <!-- Quantity Selector -->
            <div class="mb-4">
                <label class="block text-lg font-medium mb-2">Số lượng:</label>
                <div class="flex items-center">
                    <button id="decrement" class="w-12 h-12 flex items-center justify-center border rounded bg-gray-100 hover:bg-gray-200 text-lg font-bold">-</button>
                    <input 
                        type="number" 
                        id="quantity" 
                        value="1" 
                        min="1" 
                        class="w-16 text-center border rounded mx-2">
                    <button id="increment" class="w-12 h-12 flex items-center justify-center border rounded bg-gray-100 hover:bg-gray-200 text-lg font-bold">+</button>
                </div>
            </div>

            <!-- Add to Cart Button -->
            <form action="{{ route('userpage.add-to-cart', $product->id) }}" method="POST">
    @csrf
    <input type="hidden" name="quantity" id="quantity-input" value="1">
    <button type="submit" class="mt-4 w-full px-6 py-3 bg-black text-white font-bold rounded-lg hover:bg-gray-700">
        Thêm vào giỏ hàng
    </button>
</form>
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Thành công!</strong>
        <span class="block sm:inline">{{ session('success') }}</span>
        <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove();">
            <svg class="fill-current h-6 w-6 text-green-500" role="button" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><title>Close</title><path d="M14.348 5.652a1 1 0 10-1.414-1.414L10 7.586 7.066 4.652a1 1 0 10-1.414 1.414L8.586 10l-2.934 2.934a1 1 0 101.414 1.414L10 12.414l2.934 2.934a1 1 0 001.414-1.414L11.414 10l2.934-2.934z"/></svg>
        </button>
    </div>
@endif



        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const quantityInput = document.getElementById('quantity');
        const hiddenQuantity = document.getElementById('quantity-input');
        document.getElementById('decrement').addEventListener('click', (e) => {
            e.preventDefault();
            const currentValue = parseInt(quantityInput.value);
            if (currentValue > 1) {
                quantityInput.value = currentValue - 1;
                hiddenQuantity.value = quantityInput.value;
            }
        });
        document.getElementById('increment').addEventListener('click', (e) => {
            e.preventDefault();
            const currentValue = parseInt(quantityInput.value);
            quantityInput.value = currentValue + 1;
            hiddenQuantity.value = quantityInput.value;
        });
        quantityInput.addEventListener('change', () => {
            hiddenQuantity.value = quantityInput.value;
        });
    });
</script>
@endsection
