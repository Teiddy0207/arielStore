@extends('layouts.app')

@section('title', 'Quản lý đơn hàng')

@section('content')

<style>
    /* Ô status canh giữa bằng flex */
    td.status-cell {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    /* Màu các trạng thái */
    .badge {
        padding: 5px 10px;
        border-radius: 12px;
        font-size: 0.85rem;
        font-weight: 500;
        color: white;
    }

    .status-donmoi {
        background-color: #3B82F6;
    }

    .status-xacnhan {
        background-color: #A0522D;
        /* Màu nâu */
    }

    .status-danggiao {
        background-color: purple;
    }

    .status-dagiao {
        background-color: #22C55E;
        /* Xanh lá */
    }

    .status-dahuy {
        background-color: #E40B0B
    }
</style>
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
    $(document).ready(function() {
        $('#ordersTable').DataTable({
            searching: false,
            ajax: {
                url: '/api/get-orders',
                dataSrc: '' // API trả về mảng JSON
            },
            columns: [{
                    data: 'id'
                },
                {
                    data: 'customer_name'
                },
                {
                    data: 'product_name'
                },
                {
                    data: 'total_amount'
                },
                {
                    data: 'status',
                    className: 'status-cell',
                    render: function(data, type, row) {
                        let badge = '';

                        switch (data) {
                            case 'Đơn mới':
                                badge = `<span class="badge status-donmoi">${data}</span>`;
                                break;
                            case 'Đang xử lý':
                                badge = `<span class="badge status-xacnhan">${data}</span>`;
                                break;
                            case 'Đang giao':
                                badge = `<span class="badge status-danggiao">${data}</span>`;
                                break;
                            case 'Hoàn thành':
                                badge = `<span class="badge status-dagiao">${data}</span>`;
                                break;
                            case 'Đã hủy':
                                badge = `<span class="badge status-dahuy">${data}</span>`;
                                break;
                            default:
                                badge = `<span class="badge">${data}</span>`;
                        }

                        return badge;
                    }
                },

                {
                    data: 'created_at'
                },
                {
                    data: null,
                    render: function(data, type, row) {
                        let button = '';
                        let icon = `<i class="fa-solid fa-circle-info  fs-5 me-2"></i>`;

                        switch (row.status) {
                            case 'Đơn mới':
                                button = `<button class="btn btn-sm text-white fw-bold shadow-sm btn-action" 
                            style="background-color: #3B82F6; border-radius: 12px;"
                            data-id="${row.id}" data-status="2">
                            Xác nhận
                          </button>`;
                                break;

                            case 'Đang xử lý':
                                button = `<button class="btn btn-sm text-white fw-bold shadow-sm btn-action" 
                            style="background-color: #A0522D; border-radius: 12px; margin-left: 20px"
                            data-id="${row.id}" data-status="3">
                            Giao hàng
                          </button>`;
                                break;

                            case 'Đang giao':
                                button = `<button class="btn btn-sm text-white fw-bold shadow-sm btn-action" 
                            style="background-color: #22C55E; border-radius: 12px;"
                            data-id="${row.id}" data-status="4">
                            Hoàn thành
                          </button>`;
                                break;

                            default:
                                return `
                    <div class="d-flex justify-content-center align-items-center" style="height: 100%;">
                        ${icon}
                    </div>
                `;
                        }

                        return `
            <div class="d-flex justify-content-between align-items-center gap-2">
                ${icon}
                ${button}
            </div>
        `;
                    }
                }


            ]
        });

        $(document).on('click', '.btn-action', function() {

            let id = $(this).data('id');
            let status = $(this).data('status');

            $.ajax({
                url: '/api/update-status',
                type: 'POST',
                data: {
                    order_id: id,
                    status: status,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert(response.message);
                    $('#ordersTable').DataTable().ajax.reload(); // reload lại bảng
                }
            });
        });
    });
</script>