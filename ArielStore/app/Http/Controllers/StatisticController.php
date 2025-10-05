<?php

namespace App\Http\Controllers;

use GuzzleHttp\Psr7\Query;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class StatisticController extends Controller
{
    public function index(){

    }
    public function customer(){
        return view('statistic.customer');
    }
    public function inventory(){
        return view('statistic.inventory');
    }
    public function sales(){
        return view('statistic.sales.days');
    }
    public function showDaySales()
    {
        return view('statistic.sales.days');
    }
    public function showMonthSales()
    {
        return view('statistic.sales.months');
    }
    public function showYearSales()
    {
        return view('statistic.sales.years');
    }
    public function showMonthInventory()
    {
        return view('statistic.inventory.months');
    }
    public function showYearInventory()
    {
        return view('statistic.inventory.years');
    }

    public function statisticSaleDay()
    {
        $Query = DB::table('orders')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as total_sales'))
            ->where('status', 4) 
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return response()->json($Query);
    }

    public function statisticSaleMonth()
    {
        $Query = DB::table('orders')
            ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('SUM(total_amount) as total_sales'))
            ->where('status', 4) 
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        return response()->json($Query);
    }

    public function statisticSaleYear()
    {
        $Query = DB::table('orders')
            ->select(DB::raw('YEAR(created_at) as year'), DB::raw('SUM(total_amount) as total_sales'))
            ->where('status', 4) 
            ->groupBy('year')
            ->orderBy('year', 'asc')
            ->get();

        return response()->json($Query);
    }

    public function statisticSaleDayChart()
    {
        $rows = DB::table('product_types as pt')
            ->leftJoin('order_details as od', 'od.product_type_id', '=', 'pt.id')
            ->leftJoin('orders as o', 'o.id', '=', 'od.order_id')
            ->where('o.status', 4)
            ->groupBy('pt.id', 'pt.description')
            ->select(
                'pt.id',
                'pt.description',
                DB::raw('COUNT(od.id) as items')
            )
            ->get();

        $total = max(1, $rows->sum('items'));
        $result = $rows->map(function ($r) use ($total) {
            return [
                'type_id' => (int) $r->id,
                'type_name' => $r->description,
                'items' => (int) $r->items,
                'ratio' => round($r->items / $total, 4),
                'percent' => round($r->items * 100 / $total),
            ];
        });

        return response()->json($result);
    }

    /**
     * Lấy dữ liệu summary cards (tổng đơn hàng, doanh thu, khách hàng)
     */
    public function getSummaryData(Request $request)
    {
        $timeFilter = $request->get('timeFilter', 'today'); // today, month, year
        
        $dateCondition = match($timeFilter) {
            'today' => "DATE(created_at) = CURDATE()",
            'month' => "DATE_FORMAT(created_at, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m')",
            'year' => "YEAR(created_at) = YEAR(CURDATE())",
            default => "DATE(created_at) = CURDATE()"
        };

        $totalOrders = DB::table('orders')
            ->whereRaw($dateCondition)
            ->where('status', 4)
            ->count();

        $totalRevenue = DB::table('orders')
            ->whereRaw($dateCondition)
            ->where('status', 4)
            ->sum('total_amount');

        $totalCustomers = DB::table('orders')
            ->whereRaw($dateCondition)
            ->where('status', 4)
            ->distinct('customer_email')
            ->count('customer_email');

        return response()->json([
            'total_orders' => $totalOrders,
            'total_revenue' => $totalRevenue,
            'total_customers' => $totalCustomers,
            'time_filter' => $timeFilter
        ]);
    }

    /**
     * Thống kê kho hàng (inventory)
     */
    public function inventoryStatistics()
    {
        $inventory = DB::table('products as p')
            ->leftJoin('product_types as pt', 'p.product_type_id', '=', 'pt.id')
            ->select(
                'pt.type_name',
                'pt.description',
                DB::raw('COUNT(p.id) as product_count'),
                DB::raw('SUM(p.quantity) as total_quantity'),
                DB::raw('SUM(CASE WHEN p.quantity = 0 THEN 1 ELSE 0 END) as out_of_stock'),
                DB::raw('SUM(CASE WHEN p.quantity <= 5 THEN 1 ELSE 0 END) as low_stock')
            )
            ->groupBy('pt.id', 'pt.type_name', 'pt.description')
            ->get();

        return response()->json($inventory);
    }

    /**
     * Thống kê khách hàng
     */
    public function customerAnalytics()
    {
        $customerStats = DB::table('orders')
            ->select(
                'customer_name',
                'customer_email', 
                'customer_phone',
                DB::raw('COUNT(*) as total_orders'),
                DB::raw('SUM(total_amount) as total_spent'),
                DB::raw('AVG(total_amount) as avg_order_value'),
                DB::raw('MAX(created_at) as last_order_date')
            )
            ->where('status', 4)
            ->groupBy('customer_email', 'customer_name', 'customer_phone')
            ->orderBy('total_spent', 'desc')
            ->limit(50)
            ->get();

        return response()->json($customerStats);
    }

    /**
     * Top sản phẩm bán chạy
     */
    public function topSellingProducts()
    {
        $topProducts = DB::table('order_details as od')
            ->leftJoin('orders as o', 'o.id', '=', 'od.order_id')
            ->leftJoin('product_types as pt', 'pt.id', '=', 'od.product_type_id')
            ->select(
                'od.product_name',
                'pt.description as product_type',
                DB::raw('SUM(od.quantity) as total_sold'),
                DB::raw('SUM(od.total_price) as total_revenue'),
                DB::raw('COUNT(DISTINCT o.id) as order_count')
            )
            ->where('o.status', 4)
            ->groupBy('od.product_name', 'pt.description')
            ->orderBy('total_sold', 'desc')
            ->limit(20)
            ->get();

        return response()->json($topProducts);
    }

    /**
     * Xu hướng doanh thu theo giờ trong ngày
     */
    public function hourlyRevenueTrend()
    {
        $hourlyData = DB::table('orders')
            ->select(
                DB::raw('HOUR(created_at) as hour'),
                DB::raw('COUNT(*) as order_count'),
                DB::raw('SUM(total_amount) as revenue')
            )
            ->where('status', 4)
            ->whereDate('created_at', '>=', now()->subDays(7))
            ->groupBy(DB::raw('HOUR(created_at)'))
            ->orderBy('hour')
            ->get();

        return response()->json($hourlyData);
    }

    /**
     * Export báo cáo doanh số ra CSV
     */
    public function exportSalesCSV(Request $request)
    {
        try {
            $timeFilter = $request->get('timeFilter', 'month');
            
            $query = DB::table('orders')
                ->select('id', 'customer_name', 'customer_email', 'total_amount', 'payment_method', 'created_at')
                ->where('status', 4);
                
            // Apply time filter
            switch ($timeFilter) {
                case 'today':
                    $query->whereDate('created_at', now()->toDateString());
                    break;
                case 'month':
                    $query->whereMonth('created_at', now()->month)
                          ->whereYear('created_at', now()->year);
                    break;
                case 'year':
                    $query->whereYear('created_at', now()->year);
                    break;
            }
            
            $orders = $query->get();
            
            $filename = 'sales_report_' . $timeFilter . '_' . now()->format('Y-m-d') . '.csv';
            
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ];
            
            return response()->stream(function() use ($orders) {
                $file = fopen('php://output', 'w');
                
                // CSV Headers
                fputcsv($file, ['Mã đơn hàng', 'Tên khách hàng', 'Email', 'Tổng tiền', 'Phương thức thanh toán', 'Ngày tạo']);
                
                // CSV Data
                foreach ($orders as $order) {
                    fputcsv($file, [
                        $order->id,
                        $order->customer_name,
                        $order->customer_email,
                        number_format($order->total_amount),
                        $order->payment_method,
                        date('d/m/Y H:i', strtotime($order->created_at))
                    ]);
                }
                
                fclose($file);
            }, 200, $headers);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi xuất báo cáo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Export báo cáo sản phẩm bán chạy ra JSON
     */
    public function exportTopProductsJSON()
    {
        try {
            $topProducts = $this->topSellingProducts()->getData();
            
            $filename = 'top_products_' . now()->format('Y-m-d') . '.json';
            
            return response()->json($topProducts)
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
                
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi xuất báo cáo: ' . $e->getMessage()
            ], 500);
        }
    }
}
