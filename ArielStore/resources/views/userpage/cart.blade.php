@extends('layouts.client')

@section('title', 'Giỏ hàng của bạn')

@section('content')
<main class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Danh sách sản phẩm trong giỏ hàng -->
        <div class="lg:col-span-2">
            <h1 class="text-2xl font-bold mb-4">Giỏ hàng của bạn</h1>
            <div class="space-y-4">
                @foreach ($cart as $id => $item)
                    <div class="flex items-center border-b pb-4">
                        <img src="{{ asset('images/' . $item['image']) }}" alt="{{ $item['name'] }}" class="w-16 h-16 object-cover mr-4">
                        <div class="flex-grow">
                            <h2 class="font-semibold">{{ $item['name'] }}</h2>
                            <p class="text-gray-600">Size: {{ $item['size'] ?? 'Mặc định' }}</p>
                            <div class="flex items-center mt-2">
                                <label class="mr-2">Số lượng:</label>
                                <button class="px-3 py-1 border rounded">-</button>
                                <input type="number" value="{{ $item['quantity'] }}" min="1" class="w-12 text-center border mx-2">
                                <button class="px-3 py-1 border rounded">+</button>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-semibold">{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Tổng thanh toán và thanh toán giỏ hàng -->
        <div>
            <div class="p-4 bg-gray-100 rounded-lg shadow">
                <h2 class="text-lg font-bold mb-4">Tóm tắt đơn hàng</h2>
                <div class="flex justify-between items-center mb-4">
                    <span class="text-gray-600">Tổng cộng:</span>
                    <span class="text-xl font-bold">{{ number_format($total, 0, ',', '.') }}đ</span>
                </div>
                <a href="{{ route('userpage.checkoutpost') }}" class="block text-center bg-black text-white font-bold py-3 rounded-lg hover:bg-gray-800">
                    Thanh toán giỏ hàng
                </a>
            </div>
        </div>
    </div>
</main>
@endsection
