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

    public function getOrder(Request $request)
    {
        $status = $request->query('status');
        $search = $request->query('search'); 
        $query = DB::table('orders')
            ->join('statuses', 'orders.status', '=', 'statuses.id')
            ->select(
                'orders.id',
                'orders.customer_name',
                'orders.total_amount',
                'statuses.description as status',
                'orders.created_at'
            );

        if ($status) {
            $query->where('statuses.description', $status);
        }

        if ($search) {
            $query->where('orders.id', 'like', "%$search%");
        }

        return response()->json($query->get());
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
                'orders.total_amount',
                'orders.address',
                'orders.note',
                'orders.phone',
                'statuses.description as status',
                'orders.created_at'
            )
            ->first();

        $details = DB::table('order_details')
            ->where('order_id', $id)
            ->select('product_name')
            ->get();

        return response()->json([
            'order' => $order,
            'details' => $details
        ]);
    }


    public function filterStatus()
    {
        
    }
}
