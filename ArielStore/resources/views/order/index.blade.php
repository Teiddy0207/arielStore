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


    .bg-brown {
    background-color: #A0522D !important; /* nâu */
}

.bg-purple {
    background-color: #6f42c1 !important; /* tím */
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


<!-- modal -->

<div class="modal fade" id="orderDetailModal" tabindex="-1" aria-labelledby="orderDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderDetailModalLabel">Chi tiết đơn hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
            </div>
            <div class="modal-body" id="orderDetailContent">
                <!-- Nội dung chi tiết đơn hàng sẽ được thêm bằng JavaScript -->
            </div>
        </div>
    </div>
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
                        let icon = `<i class="fa-solid fa-circle-info fs-5 me-2  view-order-detail" data-id="${row.id}" style="cursor:pointer;"></i>`;

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


        $('#ordersTable').on('click', '.view-order-detail', function() {
            const orderId = $(this).data('id');

            $.ajax({
                url: `/api/order-detail/${orderId}`,
                method: 'GET',
                success: function(data) {
                    const o = data.order;
                    const d = data.detail ?? {};



    const statusClass = (() => {
        switch (o.status) {
            case "Đơn mới": return "bg-primary";
            case "Đang xử lý": return "bg-brown";
            case "Đang giao": return "bg-purple";
            case "Hoàn thành": return "bg-success";
            case "Đã hủy": return "bg-danger";
            default: return "bg-secondary";
        }
    })();

                    $('#orderDetailContent').html(`
                <h5><strong>Chi tiết đơn hàng ${o.id}</strong></h5>
                <div style="border: 2px solid #2196f3; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
                    <h6><i class="bi bi-person-fill"></i> Thông tin khách hàng</h6>
                    <div class="row">
                        <div class="col-md-6">
                            <p><i class="bi bi-person"></i> ${o.customer_name}</p>
                            <p><i class="bi bi-envelope"></i> ${d?.email ?? 'Không có'}</p>
                            <p><i class="bi bi-geo-alt"></i> ${d?.address ?? 'Không rõ'}</p>
                        </div>
                        <div class="col-md-6">
                            <p><i class="bi bi-telephone"></i> ${d?.phone ?? 'Không có'}</p>
                            <p><i class="bi bi-calendar-event"></i> ${o.created_at}</p>
                            <p><strong>Ghi chú:</strong> ${d?.note ?? 'Không có'}</p>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6> <strong><i class="bi bi-box-seam"></i> Sản phẩm đặt hàng </strong></h6>
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>${o.product_name}</td>
                                <td>${d?.quantity ?? 1}</td>
                                <td>${Number(d.price).toLocaleString()} VND</td>
                                <td>${Number(o.total_amount).toLocaleString()} VND</td>
                            </tr>
                        </tbody>
                    </table>
                    
                            <div class = "d-flex justify-content-between">
                            <div>
                    <p>Tổng cộng: </p>
                    <p>Phương thức thanh toán:</p>
                            </div>
                              <div>

<p> ${Number(o.total_amount ?? 0).toLocaleString()} VND</p>
<p class="text-end">${o.payment_method ?? 'COD'}</p>
   </div>             
</div>
</div>

             <div>
  <h6> 
    <strong><i class="bi bi-arrow-repeat"></i> Cập nhật trạng thái đơn hàng </strong>
  </h6>
 <span class="badge text-white ${statusClass}">${o.status}</span>
<div class="mt-2">
  ${o.status === "Đơn mới" ? `
    <button class="btn btn-success me-2 btn-update-status"
            data-id="${o.id}" data-status="2">
      Xác nhận
    </button>` : ''}

  ${o.status === "Đơn mới" ? `
    <button class="btn btn-danger btn-update-status"
            data-id="${o.id}" data-status="Đã hủy">
      Hủy đơn
    </button>` : ''}
</div>

</div>

            `);

                    $('#orderDetailModal').modal('show');
                },
                error: function() {
                    alert('Không thể tải chi tiết đơn hàng.');
                }
            });
        });

$(document).on('click', '.btn-update-status', function () {
    const id = $(this).data('id');
    const newStatus = $(this).data('status');

    $.ajax({
        url: '/api/update-status',
        method: 'POST',
        data: {
            order_id: id,
            status: newStatus,
            _token: '{{ csrf_token() }}'
        },
        success: function (response) {
            alert(response.message);
            $('#ordersTable').DataTable().ajax.reload();
            $('#orderDetailModal').modal('hide'); 
        },
        error: function () {
            alert('Lỗi khi cập nhật trạng thái!');
        }
    });
});


    });
</script>