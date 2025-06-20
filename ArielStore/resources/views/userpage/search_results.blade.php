@extends('layouts.client')

@section('title', 'Kết quả tìm kiếm')

@section('content')
<main class="container mx-auto px-4 py-8">
    <h2 class="text-2xl font-bold mb-6 text-left">
        KẾT QUẢ TÌM KIẾM CHO: "{{ $query }}"
    </h2>

    @if ($products->isEmpty())
        <div class="text-center py-12">
            <div class="mb-4">
                <i class="fas fa-search text-gray-400 text-6xl"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-600 mb-2">Không tìm thấy sản phẩm nào</h3>
            <p class="text-gray-500 mb-6">Hãy thử tìm kiếm với từ khóa khác hoặc xem tất cả sản phẩm của chúng tôi</p>
            <a href="{{ route('userpage.all') }}" 
               class="inline-block px-6 py-3 bg-black text-white font-semibold rounded-lg hover:bg-gray-700">
                Xem tất cả sản phẩm
            </a>
        </div>
    @else
        <div class="mb-4">
            <p class="text-gray-600">Tìm thấy {{ $products->count() }} sản phẩm</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($products as $product)
                <div class="bg-white shadow-md rounded-lg overflow-hidden relative">
                    <img src="{{ asset('images/' . $product->image) }}" 
                         alt="{{ $product->name }}" 
                         class="w-full h-64 object-cover">
                    
                    <!-- Badges -->
                    @if(isset($product->is_new) && $product->is_new)
                        <div class="absolute top-2 left-2">
                            <span class="bg-green-500 text-white text-sm font-semibold px-2 py-1 rounded">Mới</span>
                        </div>
                    @endif
                    
                    @if(isset($product->is_sale) && $product->is_sale)
                        <div class="absolute top-2 right-2">
                            <span class="bg-red-500 text-white text-sm font-semibold px-2 py-1 rounded">Sale</span>
                        </div>
                    @endif

                    <div class="p-4">
                        <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                        
                        <!-- Price Display -->
                        @if(isset($product->original_price) && $product->original_price > $product->price)
                            <div class="flex justify-between mt-2">
                                <p class="text-black font-bold text-2xl">{{ number_format($product->price, 0, ',', '.') }}đ</p>
                                <p class="text-gray-500 line-through text-sm">{{ number_format($product->original_price, 0, ',', '.') }}đ</p>
                            </div>
                        @else
                            <p class="text-black font-bold text-2xl mt-2">{{ number_format($product->price, 0, ',', '.') }}đ</p>
                        @endif

                        <a href="{{ route('userpage.product', $product->id) }}" 
                           class="mt-4 block w-full px-4 py-2 bg-black text-white text-center text-base font-semibold rounded-lg hover:bg-gray-700">
                            Xem chi tiết
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination if needed -->
        @if(method_exists($products, 'links'))
            <div class="mt-8 flex justify-center">
                {{ $products->links() }}
            </div>
        @endif
    @endif
</main>
@endsection
