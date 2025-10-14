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


    protected function validateSearchOrder(?string $search)
{
    
    if ($search === '') {
        throw new \Exception('Vui lòng nhập mã đơn hàng.');
    }

    if (!ctype_digit($search) && (int)$search <= 0) {
        throw new \Exception('Mã đơn hàng phải là số nguyên dương.');
    }

    return (int)$search; 
}
protected function validateOrderStatus(?string $status)
{//1
    if ($status === null) {//2
        return null; //3 
    }

    $status = trim($status);//4

    if (!ctype_digit($status) || (int)$status <= 0) { //5,6
        throw new \Exception('Trạng thái đơn hàng không hợp lệ.');//7
    }
    return (int)$status; //8
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


    protected function validateOrderId(?string $orderId)
{
    if ($orderId === null) {
        throw new \Exception('Vui lòng nhập mã đơn hàng.');
    }

    $orderId = trim($orderId);

    if (!ctype_digit($orderId) || (int)$orderId <= 0) {
        throw new \Exception('Mã đơn hàng phải là số nguyên dương.');
    }

    return (int)$orderId;
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
            ->select('product_name','price')
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
