
@extends('layouts.app')

@section('title', 'Dashboard - Trang chủ')

@push('css')
<style>
    body {
        background-color: #f8f9fa;
    }

    .header-section {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: #ffffff;
        padding: 1.5rem 0;
        margin-bottom: 2rem;
    }

    .stats-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        border: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
    }

    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .stats-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        color: white;
    }

    .stats-revenue { background: linear-gradient(135deg, #1abc9c, #16a085); }
    .stats-orders { background: linear-gradient(135deg, #3498db, #2980b9); }
    .stats-products { background: linear-gradient(135deg, #9b59b6, #8e44ad); }
    .stats-customers { background: linear-gradient(135deg, #e74c3c, #c0392b); }

    .chart-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        border: none;
    }

    .recent-orders-table {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
    }

    .table th {
        background-color: #f8f9fa;
        border: none;
        font-weight: 600;
        color: #2c3e50;
        padding: 1rem;
    }

    .table td {
        border: none;
        padding: 1rem;
        vertical-align: middle;
    }

    .badge-status {
        padding: 0.5rem 1rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.8rem;
    }

    .badge-new { background-color: #3498db; color: white; }
    .badge-processing { background-color: #f39c12; color: white; }
    .badge-shipping { background-color: #9b59b6; color: white; }
    .badge-completed { background-color: #1abc9c; color: white; }
    .badge-cancelled { background-color: #e74c3c; color: white; }

    .welcome-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 12px;
        border: none;
    }

    .activity-item {
        padding: 1rem;
        border-left: 3px solid #1abc9c;
        margin-bottom: 1rem;
        background: #f8f9fa;
        border-radius: 0 8px 8px 0;
    }

    .activity-time {
        color: #7f8c8d;
        font-size: 0.85rem;
    }

    .quick-action-btn {
        background: white;
        border: 2px solid #e9ecef;
        border-radius: 12px;
        padding: 1.5rem;
        text-decoration: none;
        color: #2c3e50;
        transition: all 0.3s ease;
        display: block;
        text-align: center;
    }

    .quick-action-btn:hover {
        border-color: #1abc9c;
        color: #1abc9c;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(26,188,156,0.2);
    }

    .progress-custom {
        height: 8px;
        border-radius: 10px;
    }
</style>
@endpush

@section('content')
<!-- Header -->
<div class="header-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col">
                <h4 class="mb-1">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Dashboard
                </h4>
                <p class="mb-0 opacity-75">Chào mừng trở lại, {{ session('employee_name', 'Admin') }}!</p>
            </div>
            <div class="col-auto">
                <div class="text-end">
                    <div class="h6 mb-0">{{ now()->format('d/m/Y') }}</div>
                    <small class="opacity-75">{{ now()->format('H:i') }}</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <!-- Welcome Card -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card welcome-card">
                <div class="card-body p-4">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="card-title mb-2">Chào mừng đến với ArielStore Dashboard!</h5>
                            <p class="card-text mb-0">Theo dõi và quản lý cửa hàng của bạn một cách hiệu quả nhất.</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <i class="fas fa-chart-line fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stats-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon stats-revenue me-3">
                            <i class="fas fa-coins"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1">Doanh thu tháng</h6>
                            <h4 class="mb-0">125,450,000 ₫</h4>
                            <small class="text-success">
                                <i class="fas fa-arrow-up"></i> +12.5%
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stats-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon stats-orders me-3">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1">Đơn hàng mới</h6>
                            <h4 class="mb-0">284</h4>
                            <small class="text-success">
                                <i class="fas fa-arrow-up"></i> +8.3%
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stats-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon stats-products me-3">
                            <i class="fas fa-box"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1">Sản phẩm</h6>
                            <h4 class="mb-0">1,847</h4>
                            <small class="text-info">
                                <i class="fas fa-minus"></i> Không đổi
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stats-card">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center">
                        <div class="stats-icon stats-customers me-3">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="text-muted mb-1">Khách hàng</h6>
                            <h4 class="mb-0">15,632</h4>
                            <small class="text-success">
                                <i class="fas fa-arrow-up"></i> +15.2%
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Tables Row -->
    <div class="row mb-4">
        <!-- Sales Chart -->
        <div class="col-xl-8 mb-4">
            <div class="card chart-card">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-area me-2"></i>
                        Doanh thu 7 ngày qua
                    </h5>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" style="height: 300px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-xl-4 mb-4">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        Thao tác nhanh
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="{{ route('employee.create') }}" class="quick-action-btn">
                                <i class="fas fa-user-plus fa-2x mb-2 text-primary"></i>
                                <div>Thêm nhân viên</div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('products.create') }}" class="quick-action-btn">
                                <i class="fas fa-plus-circle fa-2x mb-2 text-success"></i>
                                <div>Thêm sản phẩm</div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('orders.index') }}" class="quick-action-btn">
                                <i class="fas fa-list-alt fa-2x mb-2 text-warning"></i>
                                <div>Xem đơn hàng</div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('products.index') }}" class="quick-action-btn">
                                <i class="fas fa-boxes fa-2x mb-2 text-info"></i>
                                <div>Quản lý kho</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders and Activity -->
    <div class="row">
        <!-- Recent Orders -->
        <div class="col-xl-8 mb-4">
            <div class="recent-orders-table">
                <div class="card-header bg-transparent p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="fas fa-clock me-2"></i>
                            Đơn hàng gần đây
                        </h5>
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-primary btn-sm">
                            Xem tất cả
                        </a>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Mã đơn</th>
                                <th>Khách hàng</th>
                                <th>Sản phẩm</th>
                                <th>Tổng tiền</th>
                                <th>Trạng thái</th>
                                <th>Thời gian</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>#OR001</strong></td>
                                <td>Nguyễn Văn A</td>
                                <td>Áo thun Basic</td>
                                <td>360,000 ₫</td>
                                <td><span class="badge badge-status badge-new">Đơn mới</span></td>
                                <td>5 phút trước</td>
                            </tr>
                            <tr>
                                <td><strong>#OR002</strong></td>
                                <td>Trần Thị B</td>
                                <td>Váy hoa vintage</td>
                                <td>450,000 ₫</td>
                                <td><span class="badge badge-status badge-processing">Đang xử lý</span></td>
                                <td>15 phút trước</td>
                            </tr>
                            <tr>
                                <td><strong>#OR003</strong></td>
                                <td>Lê Văn C</td>
                                <td>Quần skinny jeans</td>
                                <td>680,000 ₫</td>
                                <td><span class="badge badge-status badge-shipping">Đang giao</span></td>
                                <td>1 giờ trước</td>
                            </tr>
                            <tr>
                                <td><strong>#OR004</strong></td>
                                <td>Phạm Thị D</td>
                                <td>Kính Balenciaga</td>
                                <td>180,000 ₫</td>
                                <td><span class="badge badge-status badge-completed">Hoàn thành</span></td>
                                <td>2 giờ trước</td>
                            </tr>
                            <tr>
                                <td><strong>#OR005</strong></td>
                                <td>Hoàng Văn E</td>
                                <td>Giày Nike Air Jordan</td>
                                <td>3,600,000 ₫</td>
                                <td><span class="badge badge-status badge-completed">Hoàn thành</span></td>
                                <td>3 giờ trước</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-xl-4 mb-4">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bell me-2"></i>
                        Hoạt động gần đây
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="activity-item">
                        <div class="d-flex justify-content-between">
                            <strong>Đơn hàng mới</strong>
                            <span class="activity-time">5 phút trước</span>
                        </div>
                        <small class="text-muted">Đơn hàng #OR001 từ Nguyễn Văn A</small>
                    </div>
                    
                    <div class="activity-item">
                        <div class="d-flex justify-content-between">
                            <strong>Sản phẩm hết hàng</strong>
                            <span class="activity-time">1 giờ trước</span>
                        </div>
                        <small class="text-muted">Áo thun Basic đã hết hàng</small>
                    </div>
                    
                    <div class="activity-item">
                        <div class="d-flex justify-content-between">
                            <strong>Đánh giá mới</strong>
                            <span class="activity-time">2 giờ trước</span>
                        </div>
                        <small class="text-muted">Khách hàng đánh giá 5 sao cho Váy hoa vintage</small>
                    </div>
                    
                    <div class="activity-item">
                        <div class="d-flex justify-content-between">
                            <strong>Nhân viên mới</strong>
                            <span class="activity-time">1 ngày trước</span>
                        </div>
                        <small class="text-muted">Nhân viên Nguyễn Thị F đã gia nhập</small>
                    </div>
                </div>
            </div>

            <!-- Progress Card -->
            <div class="card mt-4">
                <div class="card-header bg-transparent">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-target me-2"></i>
                        Mục tiêu tháng
                    </h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small>Doanh thu</small>
                            <small>83%</small>
                        </div>
                        <div class="progress progress-custom">
                            <div class="progress-bar bg-success" style="width: 83%"></div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small>Đơn hàng</small>
                            <small>72%</small>
                        </div>
                        <div class="progress progress-custom">
                            <div class="progress-bar bg-primary" style="width: 72%"></div>
                        </div>
                    </div>
                    
                    <div class="mb-0">
                        <div class="d-flex justify-content-between mb-1">
                            <small>Khách hàng mới</small>
                            <small>91%</small>
                        </div>
                        <div class="progress progress-custom">
                            <div class="progress-bar bg-warning" style="width: 91%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('js')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sales Chart
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'CN'],
            datasets: [{
                label: 'Doanh thu (triệu ₫)',
                data: [12, 15, 8, 22, 18, 25, 20],
                borderColor: '#1abc9c',
                backgroundColor: 'rgba(26, 188, 156, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#1abc9c',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 3,
                pointRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0,0,0,0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            return value + 'M';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            },
            elements: {
                point: {
                    hoverRadius: 8
                }
            }
        }
    });

    // Auto refresh time
    setInterval(function() {
        const now = new Date();
        const timeElement = document.querySelector('.col-auto .h6');
        if (timeElement) {
            timeElement.textContent = now.toLocaleDateString('vi-VN');
        }
        const timeSmall = document.querySelector('.col-auto small');
        if (timeSmall) {
            timeSmall.textContent = now.toLocaleTimeString('vi-VN', {
                hour: '2-digit',
                minute: '2-digit'
            });
        }
    }, 60000); // Update every minute
});
</script>
@endpush