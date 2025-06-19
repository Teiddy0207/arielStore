<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
}
