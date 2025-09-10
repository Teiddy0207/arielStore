<?php

namespace App\Http\Controllers;
use App\Models\ShowProduct;
use App\Models\Product;

use Illuminate\Http\Request;

class UserPageController extends Controller
{
    public function index()
    {
        return view('userpage.index');
    }

    public function showShirt()
    {
        $products = Product::with('images', 'productType')
            ->where('product_type_id', 1)
            ->where('status', 'Đang bán')
            ->get();
        return view('userpage.shirt', compact('products'));
    }

    public function showPant()
    {
        $products = Product::with('images', 'productType')
            ->where('product_type_id', 2)
            ->where('status', 'Đang bán')
            ->get();
        return view('userpage.pant', compact('products'));
    }

    public function showSkirt() 
    {
         $products = Product::with('images', 'productType')
            ->where('product_type_id', 3)
            ->where('status', 'Đang bán')
            ->get();
        return view('userpage.skirt', compact('products'));
    }

    public function showAccessories() 
    {
          $products = Product::with('images', 'productType')
            ->where('product_type_id', 4)
            ->where('status', 'Đang bán')
            ->get();
        return view('userpage.accessories', compact('products'));
    }

    public function showAll() 
    {
        $products = Product::with('images', 'productType')
            ->where('status', 'Đang bán')
            ->get();
        return view('userpage.all', compact('products'));
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
        $product = Product::with('images', 'productType')->find($id);
        if (!$product) {
            abort(404);
        }
        return view('userpage.product_detail', compact('product'));
    }

    public function addToCart(Request $request, $id)
{
    $product = Product::find($id);
    if (!$product) {
        return redirect()->back()->with('error', 'Sản phẩm không tồn tại.');
    }

    $cart = session()->get('cart', []);

    $quantity = $request->input('quantity', 1);

    if (isset($cart[$id])) {
        $cart[$id]['quantity'] += $quantity; 
    } else {
        $cart[$id] = [
            'name' => $product->name,
            'price' => $product->price,
            'original_price' => $product->import_price,
            'image' => $product->images->isNotEmpty() ? asset('storage/' . $product->images->first()->filename) : asset('images/d&g.jpg'),
            'quantity' => $quantity, // Số lượng mặc định là 1
        ];
    }

    session()->put('cart', $cart);
    
    return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng.');
}
    public function viewCart()
{
    $cart = session()->get('cart', []);

    $total = array_reduce($cart, function ($carry, $item) {
        return $carry + ($item['price'] * $item['quantity']);
    }, 0);

    return view('userpage.cart', compact('cart', 'total'));
}
public function showcheckout()
{
    $cart = session()->get('cart', []);

    if (empty($cart)) {
        return redirect()->route('userpage.cart')->with('error', 'Giỏ hàng của bạn đang trống.');
    }

    $total = array_reduce($cart, function ($sum, $item) {
        return $sum + $item['price'] * $item['quantity'];
    }, 0);

    return view('userpage.checkout', compact('cart', 'total'));

}

public function checkout(Request $request)
{
    $cart = session()->get('cart', []);

    if (empty($cart)) {
        return redirect()->route('userpage.cart')->with('error', 'Giỏ hàng của bạn đang trống.');
    }

    $total = array_reduce($cart, function ($sum, $item) {
        return $sum + $item['price'] * $item['quantity'];
    }, 0);

    $orderId = rand(1000000000, 9999999999);

    session()->forget('cart');

    return redirect()->route('userpage.order-success', ['orderId' => $orderId]);
}


 
public function orderSuccess($orderId)
{
    return view('userpage.order_success', compact('orderId'));
}

public function search(Request $request)
{
    $query = $request->input('query'); 

    $products = ShowProduct::where('name', 'like', '%' . $query . '%')->get();

    return view('userpage.search_results', compact('products', 'query'));
}


}
