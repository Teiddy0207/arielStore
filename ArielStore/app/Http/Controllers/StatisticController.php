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
            ->select(DB::raw('strftime("%Y-%m", created_at) as month'), DB::raw('SUM(total_amount) as total_sales'))
            ->where('status', 4) 
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        return response()->json($Query);
    }

    public function statisticSaleYear()
    {
        $Query = DB::table('orders')
            ->select(DB::raw('strftime("%Y", created_at) as year'), DB::raw('SUM(total_amount) as total_sales'))
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
            ->groupBy('pt.id', 'pt.type_name')
            ->select(
                'pt.id',
                'pt.type_name',
                DB::raw('COUNT(od.id) as items')
            )
            ->get();

        $total = max(1, $rows->sum('items'));
        $result = $rows->map(function ($r) use ($total) {
            return [
                'type_id' => (int) $r->id,
                'type_name' => $r->type_name,
                'items' => (int) $r->items,
                'ratio' => round($r->items / $total, 4),
                'percent' => round($r->items * 100 / $total),
            ];
        });

        return response()->json($result);
    }
}
