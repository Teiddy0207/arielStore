@extends('layouts.app')

@section('content')
<div style="background-color: #2C3E50; padding: 11px;" class="mb-1">
    <h4 style="color: white;">
        <i class="bi bi-box-seam" style="font-size: 24px; padding-left: 20px;"></i>
        Quản lý sản phẩm
    </h4>
</div>
<div class="container">
    {{-- FORM CHÍNH --}}
    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- Rất quan trọng: Đảm bảo phương thức PUT --}}

        <div class="card">
            <div class="card-header fw-bold"><h5>Cập nhật thông tin sản phẩm</h5></div>
            <div class="card-body">
                <div class="row">
                    {{-- Cột trái: Thông tin sản phẩm cơ bản --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Tên sản phẩm:</label>
                            <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $product->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col">
                                <label for="import_price" class="form-label">Giá nhập:</label>
                                <input type="number" name="import_price" id="import_price" class="form-control @error('import_price') is-invalid @enderror" value="{{ old('import_price', $product->import_price) }}" min="0">
                                @error('import_price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="price" class="form-label">Giá bán:</label>
                                <input type="number" name="price" id="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $product->price) }}" min="0" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col">
                                <label for="material" class="form-label">Chất liệu:</label>
                                <input type="text" name="material" id="material" class="form-control @error('material') is-invalid @enderror" value="{{ old('material', $product->material) }}">
                                @error('material')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="sale" class="form-label">Sale (%):</label>
                                <input type="number" name="sale" id="sale" class="form-control @error('sale') is-invalid @enderror" value="{{ old('sale', $product->sale) }}" min="0" max="100">
                                @error('sale')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col">
                                <label for="quantity" class="form-label">Số lượng:</label>
                                <input type="number" name="quantity" id="quantity" class="form-control @error('quantity') is-invalid @enderror" value="{{ old('quantity', $product->quantity) }}" min="0" required>
                                @error('quantity')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="size" class="form-label">Kích thước:</label>
                                <select name="size" id="size" class="form-select @error('size') is-invalid @enderror" required>
                                    <option value="">Chọn kích thước</option>
                                    @foreach(['S', 'M', 'L', 'XL', 'XXL'] as $sz)
                                        <option value="{{ $sz }}" {{ old('size', $product->size) == $sz ? 'selected' : '' }}>{{ $sz }}</option>
                                    @endforeach
                                </select>
                                @error('size')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col">
                                <label for="category" class="form-label">Danh mục:</label>
                                <select name="category" id="category" class="form-select @error('category') is-invalid @enderror" required>
                                    <option value="">Chọn danh mục</option>
                                    @foreach(['Áo', 'Quần', 'Váy', 'Phụ kiện'] as $cat)
                                        <option value="{{ $cat }}" {{ old('category', $product->category) == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                    @endforeach
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="status" class="form-label">Trạng thái:</label>
                                <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                                    <option value="">Chọn trạng thái</option>
                                    @foreach(['Đang bán', 'Hết hàng', 'Ngừng bán'] as $s)
                                        <option value="{{ $s }}" {{ old('status', $product->status) == $s ? 'selected' : '' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Mô tả:</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" rows="5">{{ old('description', $product->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                </div>

                    {{-- Cột phải: Ảnh--}}
                    <div class="col-md-6">
                        {{-- Ảnh hiện tại --}}
                        <div class="mb-3">
                            <label class="form-label">Ảnh hiện tại:</label>
                            <div class="border rounded p-2">
                                @if($product->images->isEmpty())
                                    <p class="text-muted mb-0">Không có ảnh nào.</p>
                                @else
                                    <table class="table table-bordered mt-2" id="current-images-table">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Tên</th>
                                                <th>Kích thước</th>
                                                <th>Kiểu</th>
                                                <th>Xoá</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($product->images as $img)
                                            <tr id="image-row-{{ $img->id }}">
                                                <td>
                                                    <a href="{{ asset('storage/' . $img->filename) }}" target="_blank">
                                                        {{ $img->original_name ?? basename($img->filename) }}
                                                    </a>
                                                </td>
                                                <td>{{ $img->filesize }}</td>
                                                <td>{{ $img->filetype }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-danger delete-image-btn" data-id="{{ $img->id }}" data-filename="{{ $img->filename }}">×</button>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        </div>

                        {{-- Thêm ảnh mới (giống create) --}}
                        <div class="mb-3">
                            <label for="new-images" class="form-label">Thêm ảnh mới:</label>
                            <div id="image-upload-box" class="border rounded d-flex justify-content-center align-items-center flex-column"
                                 style="height: auto; min-height: 160px; cursor: pointer; padding: 10px;">
                                <div id="upload-hint" class="text-center">
                                    <i class="bi bi-upload" style="font-size: 32px; color: #aaa;"></i><br>
                                    <small>Kéo thả hoặc click để tải ảnh<br>PNG, JPG, GIF tối đa 5MB</small>
                                </div>
                                <table id="new-image-info-table" class="table table-bordered mt-3" style="display: none;">
                                    <thead>
                                        <tr>
                                            <th>Tên file</th>
                                            <th>Ngày đăng</th>
                                            <th>Kích thước</th>
                                            <th>Kiểu</th>
                                            <th>Xóa</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                            <input id="new-images" name="new_images[]" type="file" class="form-control mt-2" accept="image/*" multiple style="display: none;">
                            @error('new_images.*')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>


                    </div>
                </div>
            </div>

            <div class="card-footer d-flex justify-content-end gap-2">
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save"></i> Lưu sản phẩm
                </button>
                <a href="{{ route('products.index') }}" class="btn btn-outline-dark">Quay lại</a>
            </div>
        </div>
    </form>
</div>

<script>
    // Xử lý việc xóa ảnh hiện tại bằng AJAX
    document.addEventListener('DOMContentLoaded', function () {
        const deleteButtons = document.querySelectorAll('.delete-image-btn');
        deleteButtons.forEach(button => {
            button.addEventListener('click', function () {
                const imageId = this.dataset.id;
                const imageFilename = this.dataset.filename;
                const row = document.getElementById('image-row-' + imageId);

                if (confirm(`Bạn có chắc chắn muốn xoá ảnh "${imageFilename}" này?`)) {
                    fetch(`/product-images/${imageId}`, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(errorData => Promise.reject(errorData));
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            alert(data.message);
                            if (row) row.remove();
                            const tableBody = document.querySelector('#current-images-table tbody');
                            if (tableBody && tableBody.children.length === 0) {
                                document.getElementById('current-images-table').style.display = 'none';
                                document.querySelector('#current-images-table + p.text-muted').style.display = 'block';
                            }
                        } else {
                            alert(data.message || 'Xoá ảnh thất bại.');
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi khi xoá ảnh:', error);
                        alert('Đã xảy ra lỗi khi xoá ảnh. Vui lòng thử lại.');
                    });
                }
            });
        });
    });

    // Xử lý thêm ảnh mới (giống create)
    const uploadBox = document.getElementById('image-upload-box');
    const imageInput = document.getElementById('new-images');
    const newTable = document.getElementById('new-image-info-table');
    const newTbody = newTable.querySelector('tbody');
    const hint = document.getElementById('upload-hint');

    let newStoredFiles = [];

    uploadBox.addEventListener('click', () => imageInput.click());

    imageInput.addEventListener('change', function (e) {
        for (let file of this.files) {
            if (file.size > 5 * 1024 * 1024) {
                alert(`File "${file.name}" vượt quá giới hạn 5MB.`);
                continue;
            }
            if (!newStoredFiles.some(f => f.name === file.name && f.lastModified === file.lastModified)) {
                newStoredFiles.push(file);
            }
        }
        renderNewTable();
        updateNewInputFiles();
    });

    function renderNewTable() {
        newTbody.innerHTML = '';

        if (newStoredFiles.length === 0) {
            newTable.style.display = 'none';
            hint.style.display = 'block';
            return;
        }

        newStoredFiles.forEach((file, index) => {
            const size = (file.size / (1024 * 1024)).toFixed(2) + "MB";
            const type = file.name.split('.').pop();
            const date = new Date(file.lastModified).toLocaleDateString('vi-VN');

            const row = document.createElement('tr');
            row.innerHTML = `
                <td><a href="#">${file.name}</a></td>
                <td>${date}</td>
                <td>${size}</td>
                <td>${type}</td>
                <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeNewImage(${index})">x</button></td>
            `;
            newTbody.appendChild(row);
        });

        newTable.style.display = 'table';
        hint.style.display = 'none';
    }

    function removeNewImage(indexToRemove) {
        newStoredFiles.splice(indexToRemove, 1);
        renderNewTable();
        updateNewInputFiles();
    }

    function updateNewInputFiles() {
        const dataTransfer = new DataTransfer();
        newStoredFiles.forEach(file => dataTransfer.items.add(file));
        imageInput.files = dataTransfer.files;
    }
</script>
@endsection