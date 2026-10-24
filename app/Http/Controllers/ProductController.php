<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    // -------- Public (user) ----------
    public function index(Request $request)
    {
        $q = Product::query()->where('status', true);
        if ($s = $request->get('search')) {
            $q->where(function($x) use ($s){
                $x->where('name','like',"%$s%")->orWhere('description','like',"%$s%");
            });
        }
        if ($cat = $request->get('category')) {
            $q->where('product_category_id',$cat);
        }
        $products = $q->latest()->paginate(12);
        $categories = ProductCategory::where('status',true)->get();
        return view('frontend.default.shop.shop', compact('products','categories'));
    }

    public function show(Product $product)
    {
        abort_if(!$product->is_active, 404);
        return view('shop.show', compact('product'));
    }

    // -------- Admin (CRUD) ----------
    public function adminIndex(Request $request)
    {
       
      
        $this->authorizeAdmin();
        
        $q = Product::query();
        if ($s = $request->get('search')) {
            $q->where('name','like',"%$s%");
        }
        $products = $q->latest()->paginate(20);
          
        return view('admin.product.index', compact('products'));
    }

    public function create()
    {
        $this->authorizeAdmin();
        $categories = ProductCategory::where('status',true)->get();
        return view('admin.product.create', compact('categories'));
    }

  public function store(Request $request)
{
    $this->authorizeAdmin();

    $request->merge([
        'status' => $request->status === 'active' ? 1 : 0
    ]);

    $data = $request->validate([
        'product_category_id' => 'required|exists:product_categories,id',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'sale_price' => 'nullable|numeric|min:0|lte:price',
        'stock' => 'required|integer|min:0',
        'sku' => 'nullable|string|max:100|unique:products,sku',
        'image' => 'nullable|image',
        'status' => 'boolean'
    ]);

    $data['slug'] = Str::slug($data['name']);

    if ($request->hasFile('image')) {
        $filename = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('uploads/products'), $filename);
        $data['image'] = 'uploads/products/' . $filename;
    }

    Product::create($data);

    return redirect()->route('admin.product.index')->with('success', 'Product created.');
}


    public function edit(Product $product)
    {
        $this->authorizeAdmin();
        $categories = ProductCategory::where('status',true)->get();
        return view('admin.product.edit', compact('product','categories'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorizeAdmin();
          $request->merge([
        'status' => $request->status === 'active' ? 1 : 0
        ]);
        $data = $request->validate([
            'product_category_id'=>'required|exists:product_categories,id',
            'name'=>'required|string|max:255',
            'description'=>'nullable|string',
            'price'=>'required|numeric|min:0',
            'sale_price'=>'nullable|numeric|min:0|lte:price',
            'stock'=>'required|integer|min:0',
            'sku'=>"nullable|string|max:100|unique:products,sku,{$product->id}",
            'image'=>'nullable|image',
            'status'=>'boolean'
        ]);
        $data['slug'] = Str::slug($data['name']);
         if ($request->hasFile('image')) {
        $filename = time() . '_' . $request->file('image')->getClientOriginalName();
        $request->file('image')->move(public_path('uploads/products'), $filename);
        $data['image'] = 'uploads/products/' . $filename;
       }
        $product->update($data);
        return redirect()->route('admin.products')->with('success','Updated.');
    }

    public function destroy($id)
    {
      
        $this->authorizeAdmin();
         Product::findOrFail($id)->delete();
        return back()->with('success','Deleted.');
    }

   private function authorizeAdmin()
    {
        if (!auth()->check() || auth()->user()->role !== 'admin') {
            abort(403);
        }
    }
}

