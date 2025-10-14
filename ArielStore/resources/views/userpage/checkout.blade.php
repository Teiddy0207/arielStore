@extends('layouts.client')

@section('title', 'Thanh toán')

@section('content')
<main class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-4">Thanh toán</h1>

    <!-- Sản phẩm trong đơn hàng -->
    <div class="border-b pb-4 mb-4">
        @foreach ($cart as $id => $item)
            <div class="flex justify-between items-center mb-2">
                <span>{{ $item['name'] }} ({{ $item['size'] ?? 'Mặc định' }}) x{{ $item['quantity'] }}</span>
                <span>{{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}đ</span>
            </div>
        @endforeach
    </div>

    <!-- Tổng cộng -->
    <div class="text-right mb-4">
        <span class="text-xl font-bold">Tổng cộng:</span>
        <span class="text-2xl font-bold">{{ number_format($total, 0, ',', '.') }}đ</span>
    </div>

    <!-- Form Thông tin khách hàng -->
    <form action="{{ route('userpage.checkoutpost') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <input type="text" name="name" placeholder="Họ và tên" required 
                   class="px-4 py-2 border rounded w-full">
            <input type="text" name="phone" placeholder="Số điện thoại" required 
                   class="px-4 py-2 border rounded w-full">
        </div>
        <input type="email" name="email" placeholder="Email" required 
               class="px-4 py-2 border rounded w-full mb-4">
        <textarea name="address" placeholder="Địa chỉ giao hàng" required 
                  class="px-4 py-2 border rounded w-full mb-4"></textarea>


        <!-- Nút Xác nhận đặt hàng -->
        <button type="submit" 
                class="block w-full px-6 py-3 bg-black text-white text-center text-lg font-semibold rounded-lg hover:bg-gray-700"
                >
            Xác nhận đặt hàng
        </button>
    </form>
</main>
@endsection
