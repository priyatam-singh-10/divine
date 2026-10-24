<?php
namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth','is_admin']); // implement is_admin
    }

    public function index(Request $request)
    {
        $q = ProductCategory::query();
        if ($s = $request->get('search')) {
            $q->where('name','like',"%$s%");
        }
        $categories = $q->latest()->paginate(20);
        return view('admin.categories.index', compact('categories'));
    }

    public function create(){ return view('admin.categories.create'); }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'nullable|string',
            'is_active'=>'boolean'
        ]);
        $data['slug'] = Str::slug($data['name']);
        ProductCategory::create($data);
        return redirect()->route('admin.categories.index')->with('success','Category created.');
    }

    public function edit(ProductCategory $category){ return view('admin.categories.edit', compact('category')); }

    public function update(Request $request, ProductCategory $category)
    {
        $data = $request->validate([
            'name'=>'required|string|max:255',
            'description'=>'nullable|string',
            'is_active'=>'boolean'
        ]);
        $data['slug'] = Str::slug($data['name']);
        $category->update($data);
        return redirect()->route('admin.categories.index')->with('success','Updated.');
    }

    public function destroy(ProductCategory $category)
    {
        $category->delete();
        return back()->with('success','Deleted.');
    }
}
