@extends('layouts.app')

@section('title', 'Quản lý đơn hàng')

@section('content')
<div style="background-color: #2C3E50; padding: 11px;">
    <h4 style="color: white;">Quản lý đơn hàng</h4>
</div>

<div class="container mt-5">
    <div class="row">

        <!-- Đơn mới -->
        <div class="col-md-3 mb-3">
            <div class="card text-center shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Đơn mới</h5>
                        <p class="card-text text-primary" style="font-size: 20px;">12</p>
                    </div>
                    <div class="">
                        <i class="fas fa-clock fa-2x mb-2 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Đang xử lý -->
        <div class="col-md-3 mb-3">
            <div class="card text-center shadow-sm">

                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Đang xử lý</h5>
                        <p class="card-text" style="font-size: 20px; color: #f39c12;">12</p>
                    </div>
                    <div class="">
                        <i class="fas fa-box-open fa-2x mb-2 text-warning"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Đang giao -->
        <div class="col-md-3 mb-3">
            <div class="card text-center shadow-sm">

                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Đang giao</h5>
                        <p class="card-text" style="font-size: 20px; color: #9b59b6;">12</p>
                    </div>
                    <div class="">
                        <i class="fas fa-truck fa-2x mb-2 " style="color: #9b59b6"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hoàn thành -->
        <div class="col-md-3 mb-3">
            <div class="card text-center shadow-sm">

                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title">Hoàn thành</h5>
                        <p class="card-text" style="font-size: 20px; color: #2ecc71">12</p>
                    </div>
                    <div class="">
                        <i class="fas fa-check-circle fa-2x mb-2 text-success"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>



<div class="d-flex justify-content-between align-items-center  gap-2 mt-4">
    <!-- Ô tìm kiếm -->
    <div class="flex-grow-1" style="margin-left: 40px">
        <div class="input-group rounded" style="background-color: #eee;">
            <span class="input-group-text bg-transparent border-0">
                <i class="fas fa-search text-dark"></i>
            </span>
            <input type="text" class="form-control border-0 bg-transparent" placeholder="Tìm kiếm theo mã đơn hàng">
        </div>
    </div>

    <!-- Dropdown lọc trạng thái -->
    <div style="margin-right: 40px">
        <div class="dropdown">
            <button class="btn btn-light rounded-pill px-4 py-2 dropdown-toggle border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fas fa-filter me-1"></i> Tất cả trạng thái
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Đơn mới</a></li>
                <li><a class="dropdown-item" href="#">Đang xử lý</a></li>
                <li><a class="dropdown-item" href="#">Đang giao</a></li>
                <li><a class="dropdown-item" href="#">Hoàn thành</a></li>
                <li><a class="dropdown-item" href="#">Đã hủy</a></li>

            </ul>
        </div>
    </div>
</div>

<h4 class="mt-4" style="margin-left: 40px;">Danh sách đơn hàng</h4>



<div class="container mt-4">
    <table id="ordersTable" class="display table table-bordered">
        <thead>
            <tr>
                <th>Mã đơn hàng</th>
                <th>Khách hàng</th>
                <th>Sản phẩm</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Thao tác</th>
            </tr>
        </thead>
    </table>
</div>

@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Trong <head> -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>


<script>
    $(document).ready(function () {
        $('#ordersTable').DataTable({
            ajax: {
                url: '/api/get-orders',
                dataSrc: '' // API trả về mảng JSON
            },
            columns: [
                { data: 'id' },
                { data: 'customer_name' },
                { data: 'product_name' },
                { data: 'total_amount' },
                { data: 'status' },
                { data: 'created_at' },
                {
                    data: null,
                    render: function (data, type, row) {
                        return `<button class="btn btn-sm btn-primary">Xem</button>`;
                    }
                }
            ]
        });
    });
</script>

