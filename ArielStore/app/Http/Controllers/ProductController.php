<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductType;

class ProductController extends Controller
{
    public function index()
    {
        $query = Product::with('images')->latest();

        if (request('search')) {
            $searchTerm = request('search');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('id', 'like', "%{$searchTerm}%")
                  ->orWhere('name', 'like', "%{$searchTerm}%");
            });
        }

        if (request('status')) {
            $query->where('status', request('status'));
        }

        $products = $query->with('productType')->paginate(4);

        return view('product.index', compact('products'));
    }

    public function create()
    {
        $productTypes = ProductType::all();
        return view('product.create', compact('productTypes'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'import_price' => 'required|integer|min:1',
                'price' => 'required|integer|min:1',
                'material' => 'nullable|string|max:255',
                'sale' => 'nullable|integer|min:0|max:50',
                'description' => 'nullable|string|max:500',
                'quantity' => 'required|integer|min:1',
                'size' => 'required|in:S,M,L,XL,XXL',
                'status' => 'required|in:Đang bán,Hết hàng,Ngừng bán',
                'type_name' => 'required|in:Quần,Áo,Váy,Phụ kiện',
                'images.*' => 'nullable|image|max:5120',
            ]);
            $product = Product::create($validated);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $path = $file->store('products', 'public');
                    $filesize = round($file->getSize() / 1048576, 2) . 'M';
                    $filetype = $file->getClientOriginalExtension();

                    $product->images()->create([
                        'original_name' => $file->getClientOriginalName(),
                        'filename' => $path,
                        'filesize' => $filesize,
                        'filetype' => $filetype,
                    ]);
                }
            }

            return redirect()->route('products.index')->with('success', 'Đã thêm sản phẩm mới thành công!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'Đã thêm sản phẩm mới thất bại!');
        }
    }

    public function show($id)
    {
        $product = Product::with('images')->findOrFail($id);
        return view('product.show', compact('product'));
    }

    public function edit(Product $product) // Sử dụng Route Model Binding
    {
        $product->load('images');
        $productTypes = ProductType::all();
        return view('product.edit', compact('product', 'productTypes'));
    }

    public function update(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'import_price' => 'nullable|numeric|min:0',
                'material' => 'nullable|string|max:255',
                'sale' => 'nullable|numeric|min:0|max:100',
                'quantity' => 'required|integer|min:0',
                'size' => 'required|in:S,M,L,XL,XXL',
                'product_type_id' => 'required|exists:product_types,id',
                'status' => 'required|in:Đang bán,Hết hàng,Ngừng bán',
                'description' => 'nullable|string',
                'new_images.*' => 'nullable|image|max:5120', // 5MB
            ]);

            $product->update($validated);

            // Xử lý ảnh mới
            if ($request->hasFile('new_images')) {
                foreach ($request->file('new_images') as $file) {
                    $path = $file->store('products', 'public');
                    $filesize = round($file->getSize() / 1048576, 2) . 'M';
                    $filetype = $file->getClientOriginalExtension();

                    $product->images()->create([
                        'original_name' => $file->getClientOriginalName(),
                        'filename' => $path,
                        'filesize' => $filesize,
                        'filetype' => $filetype,
                    ]);
                }
            }

            return redirect()->route('products.index')->with('success', 'Đã sửa sản phẩm thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã sửa sản phẩm thất bại!');
        }
    }

    public function destroyImage(ProductImage $productImage)
    {
        try {
            Storage::disk('public')->delete($productImage->filename);
            $productImage->delete();
            return response()->json([
                'success' => true,
                'message' => 'Ảnh đã được xóa thành công.'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa ảnh. Vui lòng thử lại.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $product = Product::with('images')->findOrFail($id);
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->filename);
            }
            $product->delete();
            return redirect()->route('products.index')->with('success', 'Đã xoá sản phẩm thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã xoá sản phẩm thất bại!');
        }
    }
    private function validateProduct(Request $request)
    {
        $data = $request->all();            //1

        if (empty($data['name'])) {         //2
            return back()->withErrors(['name' => 'Tên sản phẩm là bắt buộc.'])->withInput();       //3
        }
        if (!is_string($data['name']) || strlen($data['name']) > 255) {                 //4
            return back()->withErrors(['name' => 'Tên sản phẩm phải là chuỗi, tối đa 255 ký tự.'])->withInput();  //5
        }

        if (!isset($data['import_price']) || !is_numeric($data['import_price']) || $data['import_price'] < 1) {  //6
            return back()->withErrors(['import_price' => 'Giá nhập phải là số nguyên ≥ 1.'])->withInput();  //7
        }

        if (!isset($data['price']) || !is_numeric($data['price']) || $data['price'] < 1) {  //8
            return back()->withErrors(['price' => 'Giá bán phải là số nguyên ≥ 1.'])->withInput();  //9
        }

        if (!empty($data['material']) && strlen($data['material']) > 255) {         //10
            return back()->withErrors(['material' => 'Chất liệu tối đa 255 ký tự.'])->withInput();  //11
        }

        if (isset($data['sale']) && (!is_numeric($data['sale']) || $data['sale'] < 0 || $data['sale'] > 50)) { //12
            return back()->withErrors(['sale' => 'Giảm giá phải từ 0 đến 50%.'])->withInput();  //13
        }

        if (!empty($data['description']) && strlen($data['description']) > 500) {       //14
            return back()->withErrors(['description' => 'Mô tả tối đa 500 ký tự.'])->withInput();  //15
        }

        if (!isset($data['quantity']) || !is_numeric($data['quantity']) || $data['quantity'] < 1) {     //16
            return back()->withErrors(['quantity' => 'Số lượng phải là số nguyên ≥ 1.'])->withInput();      //17
        }

        $validSizes = ['S', 'M', 'L', 'XL', 'XXL'];     //18
        if (empty($data['size']) || !in_array($data['size'], $validSizes)) {        //19
            return back()->withErrors(['size' => 'Kích cỡ phải là S, M, L, XL hoặc XXL.'])->withInput();    //20
        }

        $validStatus = ['Đang bán', 'Hết hàng', 'Ngừng bán'];       //21
        if (empty($data['status']) || !in_array($data['status'], $validStatus)) {       //22
            return back()->withErrors(['status' => 'Trạng thái không hợp lệ.'])->withInput();       //23
        }
        $validTypes = ['Quần', 'Áo', 'Váy', 'Phụ kiện'];        //24
        if (empty($data['type_name']) || !in_array($data['type_name'], $validTypes)) {      //25
            return back()->withErrors(['type_name' => 'Loại sản phẩm không hợp lệ.'])->withInput();     //26
        }
        return $data;
    }

}
