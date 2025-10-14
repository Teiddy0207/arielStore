<?php

namespace App\Http\Controllers;

use App\Models\ShowProduct;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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
            ->where('quantity', '>', 0)

            ->where('status', 'Đang bán')
            ->get();
        return view('userpage.shirt', compact('products'));
    }

    public function showPant()
    {
        $products = Product::with('images', 'productType')
            ->where('product_type_id', 2)
            ->where('quantity', '>', 0)

            ->where('status', 'Đang bán')
            ->get();
        return view('userpage.pant', compact('products'));
    }

    public function showSkirt()
    {
        $products = Product::with('images', 'productType')
            ->where('product_type_id', 3)
            ->where('quantity', '>', 0)

            ->where('status', 'Đang bán')
            ->get();
        return view('userpage.skirt', compact('products'));
    }

    public function showAccessories()
    {
        $products = Product::with('images', 'productType')
            ->where('product_type_id', 4)
            ->where('quantity', '>', 0)
            ->where('status', 'Đang bán')
            ->get();
        return view('userpage.accessories', compact('products'));
    }

    public function showAll()
    {
        $products = Product::with('images', 'productType')
            ->where('status', 'Đang bán')
            ->where('quantity', '>', 0)
            ->get();
        return view('userpage.all', compact('products'));
    }

    public function showSale()
    {
        $products = Product::with('images', 'productType')
            ->where('status', 'Đang bán')
            ->where('quantity', '>', 0)
            ->where('sale', '>', 0)
            ->get();
        return view('userpage.sale', compact('products'));
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


    protected function validateAddToCart($product, $cart, $quantity) //1 
    {
        if (!$product) { //2
            return ['status' => false, 'message' => 'Sản phẩm không tồn tại.']; //3 
        }
        if ($product->quantity <= 0) { //4 
            return ['status' => false, 'message' => 'Sản phẩm hiện không khả dụng.']; //5
        }
        $currentInCart = isset($cart[$product->id]) ? $cart[$product->id]['quantity'] : 0; //6
        if ($currentInCart + $quantity > $product->quantity) { //7
            return ['status' => false, 'message' => "Số lượng đặt cho sản phẩm {$product->name} vượt quá số lượng trong kho ({$product->quantity})."]; //8
        }

        // Hợp lệ
        return ['status' => true]; //9
    }

    public function addToCart(Request $request, $id)
    {
        $product = Product::find($id);
        if (!$product) {
            return redirect()->back()->with('error', 'Sản phẩm không tồn tại.');
        }
        if ($product->status !== 'Đang bán' || $product->quantity <= 0) {
            return redirect()->back()->with('error', 'Sản phẩm hiện không khả dụng.');
        }
        $cart = session()->get('cart', []);
        $quantity = max(1, (int) $request->input('quantity', 1));
        $currentInCart = isset($cart[$id]) ? $cart[$id]['quantity'] : 0;
        if ($currentInCart + $quantity > $product->quantity) {
            return redirect()->back()->with('error', "Số lượng đặt cho sản phẩm {$product->name} vượt quá số lượng trong kho ({$product->quantity}).");
        }

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $quantity;
        } else {
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->sale > 0 ? $product->price - ($product->price * $product->sale / 100) : $product->price,
                'original_price' => $product->price,
                'image' => $product->images->isNotEmpty() ? asset('storage/' . $product->images->first()->filename) : asset('images/d&g.jpg'),
                'quantity' => $quantity,
                'sale' => $product->sale, // lưu info sale nếu có
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

    protected function validateCheckout(Request $request)
    {
        $errors = [];
        $name = trim($request->input('name', ''));
        $phone = trim($request->input('phone', ''));
        $email = trim($request->input('email', ''));
        $address = trim($request->input('address', ''));
        $note = $request->input('note', null); //1
        if ($phone === '') { //2
            $errors['phone'] = 'Vui lòng nhập số điện thoại.'; //3
        } elseif (!preg_match('/^[0-9]{10}$/', $phone)) { //4
            $errors['phone'] = 'Số điện thoại không hợp lệ (phải 10 chữ số).'; //5
        }
        $existingCustomer = User::where('phone', $phone)->exists();//6
        if (!$existingCustomer) {//7
            if ($name === '') { //8
                $errors['name'] = 'Vui lòng nhập họ tên.'; //9
            }
            if ($email === '') { //10
                $errors['email'] = 'Vui lòng nhập email.'; //11
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { //12
                $errors['email'] = 'Email không hợp lệ.'; //13
            }
            if ($address === '') { //14
                $errors['address'] = 'Vui lòng nhập địa chỉ.'; //15 
            }
        }
        return [ //16
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'address' => $address,
            'note' => $note,
        ];
    }

    

protected function calculateDiscount(bool $existingCustomer, float $subtotal)//1
{
    $threshold = 3000000; 
    $nearDelta = 200000;   
    $discountPercent = 0;
    $message = null;
    $near = false;//2

    if (!$existingCustomer && $subtotal >= $threshold) {//3,4 
        $discountPercent = 15; //5
    } else {
        if (!$existingCustomer) {//6
            $discountPercent += 5; //7
        }

        if ($subtotal >= $threshold) {//8 
            $discountPercent += 10; //9 
        } else {
            if ($threshold - $subtotal <= $nearDelta) {//10
                $near = true;//11 
                $message = 'Đơn hàng của bạn gần đạt 3.000.000 VND, sẽ được giảm giá 10% khi đạt mốc.';//12 
            }
        }
    }
    $discountAmount = round($subtotal * $discountPercent / 100, 0);//13
    return [//14
        'discount_percent' => $discountPercent,
        'discount_amount' => $discountAmount,
        'message' => $message,
        'near_threshold' => $near,
    ];
}

    
    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('userpage.cart')->with('error', 'Giỏ hàng của bạn đang trống.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'email' => 'required|email',
            'address' => 'required|string',
            'payment_method' => 'required|string',
            'note' => 'nullable|string'
        ]);

        $total = array_reduce($cart, function ($sum, $item) {
            return $sum + $item['price'] * $item['quantity'];
        }, 0);

        $orderId = DB::transaction(function () use ($validated, $cart, $total) {
            $order = Order::create([
                'customer_name' => $validated['name'],
                'phone' => $validated['phone'],
                'email' => $validated['email'],
                'address' => $validated['address'],
                'note' => $validated['note'] ?? null,
                'total_amount' => $total,
                'status' => 1,
            ]);

            foreach ($cart as $productId => $item) {
                $p = Product::find($productId);
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_name' => $item['name'],
                    'price' => $item['price'],
                    'product_type_id' => $p?->product_type_id,
                ]);
            }

            return $order->id;
        });

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
