<?php

namespace App\Http\Controllers;

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

        // Tìm kiếm theo mã hoặc tên
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
                'import_price' => 'required|numeric',
                'price' => 'required|numeric',
                'material' => 'nullable|string',
                'sale' => 'nullable|numeric',
                'description' => 'nullable|string',
                'quantity' => 'required|integer|min:0',
                'size' => 'required|in:S,M,L,XL,XXL',
                'status' => 'required|in:Đang bán,Hết hàng,Ngừng bán',
                'product_type_id' => 'required|exists:product_types,id',
                'images.*' => 'image|max:5120',
            ]);

            $product = Product::create($validated);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $file) {
                    $path = $file->store('products', 'public');
                    $filesize = round($file->getSize() / 1048576, 2) . 'M'; // MB
                    $filetype = $file->getClientOriginalExtension();
                    $originalName = $file->getClientOriginalName();

                    $product->images()->create([
                        'original_name' => $file->getClientOriginalName(),
                        'filename' => $path,
                        'filesize' => $filesize,
                        'filetype' => $filetype,
                    ]);
                }
            }

            return redirect()->route('products.index')->with('success', 'Đã thêm sản phẩm mới thành công!');
        } catch (\Exception $e) {
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
        // Laravel sẽ tự động tìm Product dựa trên ID từ URL
        // và eager load images để tránh N+1 query
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
                    $filesize = round($file->getSize() / 1048576, 2) . 'M'; // MB
                    $filetype = $file->getClientOriginalExtension();
                    $originalName = $file->getClientOriginalName();

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

    // Phương thức xóa ảnh riêng lẻ (product-images.destroy)
    public function destroyImage(ProductImage $productImage)
    {
        try {
            Storage::disk('public')->delete($productImage->filename);
            $productImage->delete();
            return response()->json([
                'success' => true,
                'message' => 'Ảnh đã được xóa thành công.'
            ]);
        } catch (\Exception $e) {
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

            // Xoá ảnh vật lý khỏi ổ đĩa
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->filename);
            }

            $product->delete();

            return redirect()->route('products.index')->with('success', 'Đã xoá sản phẩm thành công!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Đã xoá sản phẩm thất bại!');
        }
    }

    
}