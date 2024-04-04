<?php

namespace App\Http\Controllers\Products;

use App\Http\Controllers\Controller;
use App\Models\Products\Product;
use App\Models\Products\ProductDetail;
use App\Models\Products\ProductImage;
use App\Models\Products\ProductImages;
use App\Models\Products\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller

{
    private $product;
    private $product_detail;
    private $product_image;
    private $product_images;
    private $category;

    public function __construct(Product $product, Category $category, ProductDetail $product_detail, ProductImage $product_image, ProductImages $product_images)
    {
        $this->product = $product;
        $this->product_detail = $product_detail;
        $this->product_image = $product_image;
        $this->product_images = $product_images;
        $this->category = $category;
    }

    public function show()
    {
        $products = $this->product->where('seller_id' ,Auth::guard('seller')->id())->orderBy('created_at', 'desc')->take(5)->get();

        return view('seller.products.dashboard')->with('products', $products);
    }

    public function create()
    {
        $categories = $this->category->orderBy('id', 'asc')->get();

        return view('seller.products.create')->with('categories', $categories);
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|regex:/^[0-9]+(\.[0-9][0-9]?)?$/', //two demical
            'stock' => 'required|integer',
            'desc' => 'required',
            'category' => 'required',
            'size' => 'required',
            'weight' => 'required',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Product Table
        $this->product->name = $request->name;
        $this->product->price = $request->price;
        $this->product->qty_in_stock = $request->stock;
        $this->product->description = $request->desc;
        $this->product->status_id = 2; // ('1:Exhibit request -> 2:Waiting for valuation -> 3:Evaluation -> (7:Suspended ->) 4:Waiting for display(Coming Soon) -> 5:Exhibited -> 6:Sold out')
        $this->product->seller_id = Auth::guard('seller')->id();
        $this->product->category_id = $request->category;

        // Product Detail Table
        $this->product_detail->size = $request->size;
        $this->product_detail->weight = $request->weight;

        if ($request->fragile) {
            $this->product_detail->is_fragile = 1;
        }
        $this->product_detail->save();

        // get product_detail_id and save product table
        $this->product->product_detail_id = $this->product_detail->id;
        $this->product->save();

        // store images to product_images table and pivot product_image tables
        $imageNames = [];
        $product_image_ids = [];

        $cnt = 0;
        foreach ($request->images as $image) {
            $imageName = time() .$cnt. '.' . $image->extension();
            $imageNames[] =
                [
                    "image" => $imageName,
                    "created_at" => now(),
                    "updated_at" => now(),
                ];
            $image->move(public_path('images/items/'), $imageName);
            $cnt++;
        }

        ProductImages::insert($imageNames);

        // get the image_id from the product_images table and define the number of data from the image name array
        $max_image_id = ProductImages::orderBy('id', 'desc')->first()->id;

        $length = count($imageNames);

        for ($i =  $max_image_id - $length + 1; $i <= $max_image_id; $i++) {
            $product_image_ids[] =
                [
                    "product_id" => $this->product->id,
                    "image_id" => $i,
                ];
        }

        ProductImage::insert($product_image_ids);

        return redirect()->route('seller.products.dashboard');
    }

    public function edit($id)
    {
        $product = $this->product->findOrFail($id);
        $categories = $this->category->orderBy('id', 'asc')->get();

        return view('seller.products.edit')
            ->with('product', $product)
            ->with('categories', $categories);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric|regex:/^[0-9]+(\.[0-9][0-9]?)?$/', //two demical
            'stock' => 'required|integer',
            'desc' => 'required',
            'category' => 'required',
            'size' => 'required',
            'weight' => 'required',
            // 'images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = $this->product->findOrfail($id);

        // Product Table
        $product->name = $request->name;
        $product->price = $request->price;
        $product->qty_in_stock = $request->stock;
        $product->description = $request->desc;
        $product->status_id = 2; // ('1:Exhibit request -> 2:Waiting for valuation -> 3:Evaluation -> (7:Suspended ->) 4:Waiting for display(Coming Soon) -> 5:Exhibited -> 6:Sold out')
        $product->seller_id = Auth::guard('seller')->id();
        $product->category_id = $request->category;

        // Product Detail Table
        $product->productDetail->size = $request->size;
        $product->productDetail->weight = $request->weight;

        if ($request->fragile) {
            $product->productDetail->is_fragile = 1;
        }
        $product->productDetail->save();

        // get product_detail_id and save product table
        $product->product_detail_id = $product->productDetail->id;
        $product->save();

        // store images to product_images table and pivot product_image tables
        // $imageNames = [];
        // $product_image_ids = [];

        // foreach ($request->images as $image) {
        //     $imageName = time() . '.' . $image->extension();
        //     $imageNames[] =
        //         [
        //             "image" => $imageName,
        //             "created_at" => now(),
        //             "updated_at" => now(),
        //         ];
        //     $image->move(public_path('images/items/'), $imageName);
        // }

        // ProductImages::insert($imageNames);

        // get the image_id from the product_images table and define the number of data from the image name array
        // $max_image_id = ProductImages::orderBy('id','desc')->first()->id;

        // $length = count($imageNames);

        // for ($i =  $max_image_id - $length + 1; $i <= $max_image_id; $i++) {
        //     $product_image_ids[] =
        //         [
        //             "product_id" => $this->product->id,
        //             "image_id" => $i,
        //         ];
        // }

        // ProductImage::insert($product_image_ids);

        return redirect()->route('seller.products.dashboard');
    }


    public function delete($id)
    {
        $product = $this->product->findOrfail($id);

        return view('seller.products.dashboard')
            ->with('product',$product);
    }

    public function destroy($id)
    {
        $product = $this->product->findOrfail($id);

        $product->delete();

        return redirect()->route('seller.products.dashboard');
    }


    public function imageDestroy($image_id , $product_id)
    {
        $image = $this->product_images->findOrfail($image_id);
        $image->delete();

        $this->product_image
            ->where('product_id' , $product_id)
            ->where('image_id' , $image_id)
            ->delete();

        // or set the ondeletecascade to the migration file

        return redirect()->back();
    }
}
