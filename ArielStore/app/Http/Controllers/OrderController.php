<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return view('order.index');
    }

    public function getOrder()
    {
        $orders = DB::table('orders')
            ->join('statuses', 'orders.status', '=', 'statuses.id')
            ->select(
                'orders.id',
                'orders.customer_name',
                'orders.product_name',
                'orders.total_amount',
                'statuses.description as status',
                'orders.created_at'
            )
            ->get();

        return response()->json($orders);
    }


    public function updateStatus(Request $request)
{
 

    DB::table('orders')->where('id', $request->order_id)->update([
        'status' => $request->status,
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Cập nhật trạng thái thành công!',
    ]);
}

}
