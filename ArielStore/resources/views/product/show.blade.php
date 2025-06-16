@extends('layouts.app')

@section('content')
<div style="background-color: #2C3E50; padding: 11px;" class="mb-1">
    <h4 style="color: white;">
        <i class="bi bi-box-seam" style="font-size: 24px; padding-left: 20px;"></i>
        Quản lý sản phẩm
    </h4>
</div>
<div class="container">
    <div class="card">
        <div class="card-header fw-bold">
            <h5>Xem chi tiết sản phẩm</h5>
        </div>
        <div class="card-body row">
            {{-- Cột trái: Thông tin sản phẩm --}}
            <div class="col-md-6">
                <h5 class="mb-3 ps-5">{{ $product->name }}</h5>
                <div class="row ps-5">
                    <div class="col-sm-4">
                        <div class="mb-3"><strong>Mã sản phẩm:</strong> {{ $product->id }}</div>
                        <div class="mb-3"><strong>Trạng thái:</strong> {{ $product->status }}</div>
                        <div class="mb-3"><strong>Kích thước:</strong> {{ $product->size }}</div>
                        <div class="mb-3"><strong>Giá bán:</strong> {{ number_format($product->price) }} đồng</div>
                        <div class="mb-3"><strong>Chất liệu:</strong> {{ $product->material }}</div>
                    </div>
                    <div class="col-sm-5 ps-5">
                        <div class="mb-3"><strong>Danh mục:</strong> {{ $product->category }}</div>
                        <div class="mb-3"><strong>Ngày tạo:</strong> {{ $product->created_at->format('d/m/Y') }}</div>
                        <div class="mb-3"><strong>Tồn kho:</strong> {{ $product->quantity }}</div>
                        <div class="mb-3"><strong>Giá nhập:</strong> {{ number_format($product->import_price) }} đồng</div>
                        <div class="mb-3"><strong>Sale:</strong> {{ $product->sale }}%</div>
                    </div>
                </div>

                {{-- Mô tả chiếm cả chiều ngang 2 cột --}}
                <div class="mt-3 ps-5">
                    <strong>Mô tả:</strong> {{ $product->description }}
                </div>
            </div>

            {{-- Cột phải: Hình ảnh --}}
            <div class="col-md-4 text-center">
                @if($product->images->isNotEmpty())
                    <img id="main-image" src="{{ asset('storage/' . $product->images->first()->filename) }}" class="img-fluid rounded border mb-2" style="max-height:300px;">
                    
                    <div class="d-flex justify-content-center gap-2 mt-2 flex-wrap">
                        @foreach($product->images as $img)
                            <img src="{{ asset('storage/' . $img->filename) }}" class="img-thumbnail" style="width: 50px; height: 50px; cursor:pointer;" onclick="changeMainImage(this)">
                        @endforeach
                    </div>
                @else
                    <p class="text-muted">Không có ảnh</p>
                @endif
            </div>
        </div>



        <div class="card-footer text-end">
            <a href="{{ route('products.index') }}" class="btn btn-outline-dark">Quay lại</a>
        </div>
    </div>
</div>

<script>
    function changeMainImage(el) {
        const mainImg = document.getElementById('main-image');
        mainImg.src = el.src;
    }
</script>
@endsection

