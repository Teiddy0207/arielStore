@extends('layouts.app')
@section('title', 'Báo cáo thống kê')

@push('styles')
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f3f4f6;
        }

        .main-content {
            flex-grow: 1;
            padding: 30px;
            background-color: #f8f9fa;
        }

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .card {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .card h3 {
            font-size: 2rem;
            margin: 0;
            color: #333;
        }

        .card p {
            margin: 0;
            font-size: 1.1rem;
            color: #6c757d;
        }

        .dropdown-container {
            position: relative;
            display: inline-block;
            margin-bottom: 30px;
        }

        .dropdown-toggle {
            background-color: #ffffff;
            border: 1px solid #ced4da;
            border-radius: 6px;
            padding: 12px 20px;
            font-size: 0.95rem;
            font-weight: 500;
            color: #495057;
            cursor: pointer;
            width: 220px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.2s ease;
        }

        .dropdown-toggle:hover {
            background-color: #e9ecef;
        }

        .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 999;
            background-color: #ffffff;
            border-radius: 6px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            margin-top: 5px;
            padding: 10px 0;
            list-style: none;
            width: 100%;
            display: none;
        }

        .dropdown-menu li a {
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 0.9rem;
            color: #495057;
            transition: all 0.2s ease;
        }

        .dropdown-menu li a:hover {
            background-color: #f0f0f0;
            color: #2c3e50;
        }

        .rotate-180 {
            transform: rotate(180deg);
        }

        .charts-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .chart-panel {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        .chart-container {
            position: relative;
            width: 100%;
            height: 300px;
            margin-top: 10px;
        }

        .chart-container canvas {
            width: 100% !important;
            height: 100% !important;
        }

        .table-section {
            background-color: #ffffff;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #dee2e6;
        }

        table th {
            background-color: #e9ecef;
            font-size: 0.85rem;
            font-weight: 600;
            color: #495057;
            text-transform: uppercase;
        }

        table tbody tr:hover {
            background-color: #f0f0f0;
        }

        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 0.8rem;
            font-weight: 600;
            color: #fff;
        }

        .status-badge.success {
            background-color: #28a745;
        }

        .status-badge.pending {
            background-color: #ffc107;
        }

        .status-badge.cancelled {
            background-color: #dc3545;
        }

        .dropdown-toggle {
            height: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .modal-overlay {
            position: fixed;
            top: 0; left: 0;
            width: 100vw; height: 100vh;
            background-color: rgba(0, 0, 0, 0.4);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .modal-box {
            background-color: #eceef1;
            border-radius: 10px;
            width: 500px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            overflow: hidden;
            font-family: 'Inter', sans-serif;
        }

        .modal-header {
            background-color: #2C3E50;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-weight: bold;
        }

        .modal-header .close-btn {
            background: none;
            border: none;
            color: white;
            font-size: 20px;
            cursor: pointer;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-body label {
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
        }

        .modal-content-box {
            background: white;
            border-radius: 10px;
            padding: 40px;
            text-align: center;
            font-weight: bold;
        }

        .modal-footer {
            padding: 15px 20px;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .modal-footer .btn-secondary {
            padding: 8px 16px;
            background-color: #ddd;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }

    </style>
@endpush

@section('content')
    <div style="background-color: #2C3E50; padding: 11px;" class="fixed-header">
        <h4 style="color: white; font-size: 20px">Báo cáo thống kê</h4>
    </div>
    <div class="main-content" >
        <div class="mb-4" style="display: flex; gap: 10px; align-items: center;">
            <input type="text" class="form-control" placeholder="Tìm kiếm theo mã, tên,..." style="flex: 1; padding: 10px 14px; border-radius: 6px; border: 1px solid #ccc;">
            <button class="btn" style="background-color: #3B82F6; color: white; padding: 10px 20px; border: none; border-radius: 6px;">
                <i class="fas fa-search"></i> Tìm kiếm
            </button>
        </div>
        <section class="charts-section">
            <div class="chart-panel">
                <h4>Top 3 mua hàng</h4>
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
            <div class="chart-panel">
                <h4>Tỷ lệ khách Nam/Nữ</h4>
                <div class="chart-container">
                    <canvas id="sexualChart"></canvas>
                </div>
            </div>
            <div class="chart-panel">
                <h4>Tỷ lệ mua lại</h4>
                <div class="chart-container">
                    <canvas id="repeatCustomerChart"></canvas>
                </div>
            </div>
        </section>
        <section class="table-section">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h4 style="margin: 0;">Đơn hàng gần đây</h4>
                <button onclick="openReportModal()" class="btn" style="background-color: #10b981; color: white; padding: 10px 20px; border: none; border-radius: 6px;">
                    <i class="fas fa-file-export"></i> Xuất báo cáo
                </button>
            </div>
            <table>
                <thead>
                <tr>
                    <th>Mã đơn</th>
                    <th>Ngày đặt</th>
                    <th>Trạng thái</th>
                    <th>Mã khách hàng</th>
                    <th>Phương thức thanh toán</th>
                    <th>Tổng tiền</th>
                </tr>
                <tr>
                    <td>001</td>
                    <td>10/05/2025</td>
                    <td><span class="status-badge success">Đã lấy hàng</span></td>
                    <td>KH001</td>
                    <td>Chuyển khoản</td>
                    <td>120,000 VNĐ</td>
                </tr>
                <tr>
                    <td>001</td>
                    <td>10/05/2025</td>
                    <td><span class="status-badge success">Đã lấy hàng</span></td>
                    <td>KH001</td>
                    <td>Chuyển khoản</td>
                    <td>120,000 VNĐ</td>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>001</td>
                    <td>10/05/2025</td>
                    <td><span class="status-badge success">Đã lấy hàng</span></td>
                    <td>KH001</td>
                    <td>Chuyển khoản</td>
                    <td>120,000 VNĐ</td>
                </tr>
                <tr>
                    <td>002</td>
                    <td>11/05/2025</td>
                    <td><span class="status-badge pending">Đang xử lý</span></td>
                    <td>KH002</td>
                    <td>Tiền mặt</td>
                    <td>150,000 VNĐ</td>
                </tr>
                </tbody>
            </table>
        </section>
    </div>
    <!-- Modal Xuất báo cáo -->
    <div id="reportModal" style="display:none;" class="modal-overlay">
        <div class="modal-box">
            <div class="modal-header">
                <div><i class="fas fa-box"></i> Xuất báo cáo</div>
                <button onclick="closeReportModal()" class="close-btn">&times;</button>
            </div>
            <div class="modal-body">
                <label for="reportContent">Nội dung</label>
                <div class="modal-content-box">Nội dung file</div>
            </div>
            <div class="modal-footer">
                <button class="btn-secondary" onclick="closeReportModal()">Huỷ</button>
                <button class="close-btn"
                        style="background-color: #3B82F6;
                        color: white; padding: 10px 20px;
                        border: none; border-radius: 6px;"
                        onclick="closeReportModal()">
                    Xuất file
                </button>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function openReportModal() {
            document.getElementById('reportModal').style.display = 'flex';
        }

        function closeReportModal() {
            document.getElementById('reportModal').style.display = 'none';
        }

        // Toggle dropdown
        document.addEventListener("DOMContentLoaded", function () {
            const toggle = document.getElementById("dropdownToggle");
            const menu = document.getElementById("dropdownMenu");
            const icon = document.getElementById("dropdownIcon");

            toggle.addEventListener("click", function () {
                const isVisible = menu.style.display === "block";
                menu.style.display = isVisible ? "none" : "block";
                icon.classList.toggle("rotate-180", !isVisible);
            });
        });

        new Chart(document.getElementById('revenueChart'), {
            type: 'bar',
            data: {
                labels: ['Hùng', 'Kiên', 'Trang'],
                datasets: [{
                    label: 'Số lần mua hàng',
                    data: [25, 18, 12],
                    backgroundColor: ['#74B72E','#3B82F6', '#85C1E9'],
                    borderRadius: 5
                }]
            },
            options: {
                indexAxis: 'y', // chuyển sang biểu đồ ngang
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    x: {
                        beginAtZero: true
                    }
                }
            }
        });
        new Chart(document.getElementById('sexualChart'), {
            type: 'pie',
            data: {
                labels: ['Nam', 'Nữ'],
                datasets: [{
                    data: [45, 55],
                    backgroundColor: ['#3B82F6', '#74B72E']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
        new Chart(document.getElementById('repeatCustomerChart'), {
            type: 'doughnut',
            data: {
                labels: ['Khách mới', 'Khách quay lại'],
                datasets: [{
                    data: [40, 60],
                    backgroundColor: ['#3B82F6', '#74B72E'],
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });

    </script>
@endpush
