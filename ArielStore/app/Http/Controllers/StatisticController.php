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
            ->where('status', 4) // Giả sử trạng thái 4 là "Hoàn thành"
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return response()->json($Query);
    }
}
