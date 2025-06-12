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



public function getOrderDetail($id)
{
    $order = DB::table('orders')
        ->join('statuses', 'orders.status', '=', 'statuses.id')
        ->where('orders.id', $id)
        ->select(
            'orders.id',
            'orders.customer_name',
            'orders.product_name',
            'orders.total_amount',
            'statuses.description as status',
            'orders.created_at'
        )
        ->first();

    $orderDetail = DB::table('order_details')
        ->join('statuses', 'order_details.status', '=', 'statuses.id')
        ->where('order_details.order_id', $id)
        ->select(
            'order_details.note',
            'order_details.phone',
            'order_details.quantity',
                        'order_details.address',
                        'order_details.email',
                        'order_details.price',

            'statuses.description as status'
        )
        ->first();

    return response()->json([
        'order' => $order,
        'detail' => $orderDetail
    ]);
}

}
