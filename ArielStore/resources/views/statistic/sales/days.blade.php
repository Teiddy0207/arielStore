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

    </style>
@endpush

@section('content')
    <div style="background-color: #2C3E50; padding: 11px;" class="fixed-header">
        <h4 style="color: white; font-size: 20px">Báo cáo thống kê</h4>
    </div>
    <div class="main-content">
        <section class="summary-cards">
            <div class="card">
                <p>Số đơn hàng</p>
                <h3>124</h3>
            </div>
            <div class="card">
                <p>Doanh thu (VNĐ)</p>
                <h3 style="color: #28a745;">25,120,000</h3>
            </div>
            <div class="card">
                <p>Số lượt khách</p>
                <h3>102</h3>
            </div>
            <div class="card" style="padding: 0">
                <div class="dropdown-container" style="padding: 20px;">
                    <div id="dropdownToggle" class="dropdown-toggle">
                        <span>Thời gian</span>
                    </div>
                    <ul id="dropdownMenu" class="dropdown-menu">
                        <li><a href="{{ route('statistic.sales.days') }}">Theo ngày</a></li>
                        <li><a href="{{ route('statistic.sales.months') }}">Theo tháng</a></li>
                        <li><a href="{{ route('statistic.sales.years') }}">Theo năm</a></li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="charts-section">
            <div class="chart-panel">
                <h4>Doanh thu 7 ngày gần nhất (triệu VNĐ)</h4>
                <div class="chart-container">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
            <div class="chart-panel">
                <h4>Tỷ lệ bán của sản phẩm</h4>
                <div class="chart-container">
                    <canvas id="productChart"></canvas>
                </div>
            </div>
        </section>
        <section class="table-section">
            <h4>Đơn hàng gần đây</h4>
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
                    <td>001</td>
                    <td>10/05/2025</td>
                    <td><span class="status-badge success">Đã lấy hàng</span></td>
                    <td>KH002</td>
                    <td>Chuyển khoản</td>
                    <td>120,000 VNĐ</td>
                </tr>
                <tr>
                    <td>001</td>
                    <td>10/05/2025</td>
                    <td><span class="status-badge success">Đã lấy hàng</span></td>
                    <td>KH003</td>
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
@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
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

        // Chart Doanh thu
        new Chart(document.getElementById('revenueChart'), {
            type: 'bar',
            data: {
                labels: ['10/5', '11/5', '12/5', '13/5', '14/5', '15/5', '16/5'],
                datasets: [{
                    label: 'Doanh thu (triệu VNĐ)',
                    data: [94, 38, 69, 42, 76, 48, 50],
                    backgroundColor: '#1e3a8a',
                    borderRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Chart Pie sản phẩm
        new Chart(document.getElementById('productChart'), {
            type: 'pie',
            data: {
                labels: ['Quần', 'Áo sơ mi', 'Mũ', 'Váy', 'Áo phông'],
                datasets: [{
                    data: [20, 25, 15, 25, 15],
                    backgroundColor: ['#1E40AF', '#5579C6', '#22c55e', '#3B82F6', '#74B72E']
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    </script>
@endpush
