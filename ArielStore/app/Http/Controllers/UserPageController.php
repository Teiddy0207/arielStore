<?php

namespace App\Http\Controllers;
use App\Models\ShowProduct;

use Illuminate\Http\Request;

class UserPageController extends Controller
{
    public function index()
    {
        return view('userpage.index');
    }

    public function showShirt()
    {
        return view ('userpage.shirt');
    }

    public function showPant()
    {
        return view('userpage.pant');
    }

    public function showSkirt() 
    {
        return view('userpage.skirt');
    }

    public function showAccessories() 
    {
        return view('userpage.accessories');
    }

    public function showAll() 
    {
        return view('userpage.all');
    }

    public function showSale() 
    {
        return view('userpage.sale');
    }

    public function showNew() 
    {
        return view('userpage.new');
    }

    public function showProduct($id)
    {
        $product = ShowProduct::find($id);
        if (!$product) {
            abort(404);
        }
        return view('userpage.product_detail', compact('product'));
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart(Request $request, $id)
{
    // Tìm sản phẩm theo ID
    $product = ShowProduct::find($id);
    if (!$product) {
        return redirect()->back()->with('error', 'Sản phẩm không tồn tại.');
    }

    // Lấy giỏ hàng hiện tại từ session
    $cart = session()->get('cart', []);

    // Số lượng sản phẩm muốn thêm (nếu không có thì mặc định là 1)
    $quantity = $request->input('quantity', 1);

    // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
    if (isset($cart[$id])) {
        $cart[$id]['quantity'] += $quantity; // Tăng số lượng sản phẩm
    } else {
        // Thêm sản phẩm mới vào giỏ hàng
        $cart[$id] = [
            'name' => $product->name,
            'price' => $product->price,
            'original_price' => $product->original_price,
            'image' => $product->image,
            'quantity' => $quantity, // Số lượng mặc định là 1
        ];
    }

    // Lưu giỏ hàng vào session
    session()->put('cart', $cart);
    
    return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
}
    public function viewCart()
{
    // Lấy giỏ hàng từ session
    $cart = session()->get('cart', []);

    // Tính tổng thanh toán
    $total = array_reduce($cart, function ($carry, $item) {
        return $carry + ($item['price'] * $item['quantity']);
    }, 0);

    return view('userpage.cart', compact('cart', 'total'));
}
public function showcheckout()
{
    $cart = session()->get('cart', []);

    // Kiểm tra giỏ hàng có sản phẩm hay không
    if (empty($cart)) {
        return redirect()->route('userpage.cart')->with('error', 'Giỏ hàng của bạn đang trống.');
    }

    $total = array_reduce($cart, function ($sum, $item) {
        return $sum + $item['price'] * $item['quantity'];
    }, 0);
    // Tạo mã đơn hàng ngẫu nhiên (ví dụ)
    $orderId = rand(1000000000, 9999999999);

    // Xóa giỏ hàng khỏi session
    session()->forget('cart');

    // Chuyển hướng đến trang "Đặt hàng thành công"
   
    return view('userpage.checkout', compact('cart', 'total'));

}

public function checkout(Request $request)
{
    // Lấy giỏ hàng từ session
    $cart = session()->get('cart', []);

    // Kiểm tra giỏ hàng có sản phẩm hay không
    if (empty($cart)) {
        return redirect()->route('userpage.cart')->with('error', 'Giỏ hàng của bạn đang trống.');
    }

    // Xử lý logic lưu thông tin đơn hàng
    $total = array_reduce($cart, function ($sum, $item) {
        return $sum + $item['price'] * $item['quantity'];
    }, 0);

    // Tạo mã đơn hàng ngẫu nhiên (giả lập)
    $orderId = rand(1000000000, 9999999999);

    // Sau khi xử lý, xóa giỏ hàng khỏi session
    session()->forget('cart');

    // Chuyển hướng đến trang "Đặt hàng thành công"
    return redirect()->route('userpage.order-success', ['orderId' => $orderId]);
}


 
public function orderSuccess($orderId)
{
    return view('userpage.order_success', compact('orderId'));
}

public function search(Request $request)
{
    $query = $request->input('query'); // Lấy từ khóa tìm kiếm từ form

    // Tìm kiếm sản phẩm theo tên (bạn có thể tùy chỉnh theo yêu cầu)
    $products = ShowProduct::where('name', 'like', '%' . $query . '%')->get();

    // Trả về view kèm danh sách sản phẩm tìm được
    return view('userpage.search_results', compact('products', 'query'));
}


}
