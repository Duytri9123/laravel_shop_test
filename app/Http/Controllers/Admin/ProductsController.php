<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Inertia\Inertia;
use LDAP\Result;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ProductsController extends Controller
{
    public function index()
    {
        $products = Product::with('category', 'brand', 'product_images')->get();
        $brands = Brand::get();
        $categories = Category::get();


        return Inertia::render(
            'Admin/Products/Index',
            [
                'products' => $products,
                'brands' => $brands,
                'categories' => $categories
            ]
        );
    }


    public function store(Request $request)
    {
        // dd($request->file('product_images'));
        $product = new Product;

        $product->title       = $request->title;
        $product->price       = $request->price;
        $product->quantity    = $request->quantity;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->brand_id    = $request->brand_id;

        $product->save();

        // Nếu có ảnh thì xử lý upload
        if ($request->hasFile('product_images')) {

            $productImages = $request->file('product_images');

            // Tạo thư mục nếu chưa có
            $uploadPath = public_path('product_images');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            foreach ($productImages as $image) {
                $uniqueName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();

                $image->move($uploadPath, $uniqueName); // lưu file vào public/product_images

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'product_images/' . $uniqueName, // lưu đường dẫn tương đối
                ]);
            }
        }

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $product->title       = $request->title;
        $product->price       = $request->price;
        $product->quantity    = $request->quantity;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->brand_id    = $request->brand_id;

        if ($request->hasFile('product_images')) {
            $productImages = $request->file('product_images');

            // Tạo thư mục nếu chưa có
            // Tạo thư mục nếu chưa có
            $uploadPath = public_path('product_images');
            if (!File::exists($uploadPath)) {
                File::makeDirectory($uploadPath, 0755, true);
            }

            foreach ($productImages as $image) {
                $uniqueName = time() . '-' . Str::random(10) . '.' . $image->getClientOriginalExtension();

                $image->move($uploadPath, $uniqueName); // lưu file vào public/product_images

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => 'product_images/' . $uniqueName, // lưu đường dẫn tương đối
                ]);
            }
        }

        $product->save();

        return redirect()->back()->with('success', 'Product update successfully');
    }


    public function deleteImage($id)
    {
        $image = ProductImage::where('id', $id)->delete();
        return redirect()->route('admin.products.index')->with('success', 'Image delete successfully.');
    }

    public function destory($id){

        $product = Product::findOrFail($id)->delete();
        return redirect()->route('admin.products.index')->with('success','Product deleted successfully.');
    }
}
