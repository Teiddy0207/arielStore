@extends('layouts.client')

@section('title', 'Đặt hàng thành công')

@section('content')
<main class="container mx-auto px-4 py-8 text-center">
    <div class="max-w-md mx-auto bg-white p-8 rounded-lg shadow">
        <img src="{{ asset('images/logo.png') }}" alt="Ariel Store" class="mx-auto mb-4">
        <h1 class="text-2xl font-bold mb-2">Đặt hàng thành công!</h1>
        <p class="text-lg mb-4">Mã đơn hàng: <span class="font-semibold">{{ $orderId }}</span></p>
        <a href="{{ route('userpage.index') }}" 
           class="inline-block mt-4 px-6 py-3 bg-black text-white text-lg font-bold rounded-lg hover:bg-gray-700">
           Tiếp tục mua sắm
        </a>
    </div>
</main>
@endsection
