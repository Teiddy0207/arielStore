@extends('layouts.app')

@section('content')
<div style="background-color: #2C3E50; padding: 11px;" class="mb-1">
    <h4 style="color: white;">
        <i class="bi bi-box-seam" style="font-size: 24px; padding-left: 20px;"></i>
        Quản lý sản phẩm
    </h4>
</div>
<div class="container">
    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="card">
            <div class="card-header fw-bold"><h5>Thêm sản phẩm mới</h5></div>
            
            <div class="card-body">
                <div class="row">
                    {{-- Cột trái --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Tên sản phẩm:</label>
                            <input name="name" class="form-control" value="{{ old('name') }}" required>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col">
                                <label>Giá nhập:</label>
                                <input name="import_price" type="number" class="form-control" value="{{ old('import_price', 0) }}" min="0">
                                @error('import_price') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col">
                                <label>Giá bán:</label>
                                <input name="price" type="number" class="form-control" value="{{ old('price', 0) }}" min="0" required>
                                @error('price') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col">
                                <label>Chất liệu:</label>
                                <input name="material" class="form-control" value="{{ old('material') }}">
                                @error('material') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col">
                                <label>Sale (%):</label>
                                <input name="sale" type="number" min="0" max="100" class="form-control" value="{{ old('sale') }}">
                                @error('sale') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col">
                                <label>Số lượng:</label>
                                <input name="quantity" type="number" class="form-control" value="{{ old('quantity', 0) }}" min="0" required>
                                @error('quantity') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col">
                                <label>Kích thước:</label>
                                <select name="size" class="form-select" required>
                                    <option value="">Chọn kích thước</option>
                                    @foreach(['S', 'M', 'L', 'XL', 'XXL'] as $sz)
                                        <option value="{{ $sz }}" {{ old('size') == $sz ? 'selected' : '' }}>{{ $sz }}</option>
                                    @endforeach
                                </select>
                                @error('size') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col">
                                <label>Danh mục:</label>
                                <select name="category" class="form-select" required>
                                    <option value="">Chọn danh mục</option>
                                    @foreach(['Áo', 'Quần', 'Váy', 'Phụ kiện'] as $cat)
                                        <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                                    @endforeach
                                </select>
                                @error('category') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col">
                                <label>Trạng thái:</label>
                                <select name="status" class="form-select" required>
                                    <option value="">Chọn trạng thái</option>
                                    @foreach(['Đang bán', 'Hết hàng', 'Ngừng bán'] as $s)
                                        <option value="{{ $s }}" {{ old('status') == $s ? 'selected' : '' }}>{{ $s }}</option>
                                    @endforeach
                                </select>
                                @error('status') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- Cột phải --}}
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label>Hình ảnh:</label>
                            <div id="image-upload-box" class="border rounded d-flex justify-content-center align-items-center flex-column"
                                style="height: auto; min-height: 160px; cursor: pointer; padding: 10px;">
                                <div id="upload-hint" class="text-center">
                                    <i class="bi bi-upload" style="font-size: 32px; color: #aaa;"></i><br>
                                    <small>Kéo thả hoặc click để tải ảnh<br>PNG, JPG, GIF tối đa 5MB</small>
                                </div>
                                <table id="image-info-table" class="table table-bordered mt-3" style="display: none;">
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
                            <input id="image-input" name="images[]" type="file" class="form-control mt-2" accept="image/*" multiple style="display: none;">
                            @error('images.*') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Mô tả:</label>
                            <textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea>
                            @error('description') <small class="text-danger">{{ $message }}</small> @enderror
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
    const uploadBox = document.getElementById('image-upload-box');
    const imageInput = document.getElementById('image-input');
    const table = document.getElementById('image-info-table');
    const tbody = table.querySelector('tbody');
    const hint = document.getElementById('upload-hint');

    let storedFiles = [];

    uploadBox.addEventListener('click', () => imageInput.click());

    imageInput.addEventListener('change', function () {
        for (let file of this.files) {
            if (file.size > 5 * 1024 * 1024) {
                alert(`File "${file.name}" vượt quá giới hạn 5MB.`);
                continue;
            }
            if (!storedFiles.some(f => f.name === file.name && f.lastModified === file.lastModified)) {
                storedFiles.push(file);
            }
        }
        renderTable();
        updateInputFiles();
    });

    function renderTable() {
        tbody.innerHTML = '';

        if (storedFiles.length === 0) {
            table.style.display = 'none';
            hint.style.display = 'block';
            return;
        }

        storedFiles.forEach((file, index) => {
            const size = (file.size / (1024 * 1024)).toFixed(2) + "MB";
            const type = file.name.split('.').pop();
            const date = new Date(file.lastModified).toLocaleDateString('vi-VN');

            const row = document.createElement('tr');
            row.innerHTML = `
                <td><a href="#">${file.name}</a></td>
                <td>${date}</td>
                <td>${size}</td>
                <td>${type}</td>
                <td><button type="button" class="btn btn-sm btn-outline-danger" onclick="removeImage(${index})">x</button></td>
            `;
            tbody.appendChild(row);
        });

        table.style.display = 'table';
        hint.style.display = 'none';
    }

    function removeImage(indexToRemove) {
        storedFiles.splice(indexToRemove, 1);
        renderTable();
        updateInputFiles();
    }

    function updateInputFiles() {
        const dataTransfer = new DataTransfer();
        storedFiles.forEach(file => dataTransfer.items.add(file));
        imageInput.files = dataTransfer.files;
    }
</script>
@endsection
