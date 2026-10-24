<?php

namespace App\Http\Controllers\frontend;

use App\Models\Book;
use App\Models\SeoField;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BookController extends Controller
{
    public function index(Request $request)
    
    {
       
        $view_path = 'frontend' . '.' . get_frontend_settings('theme') . '.book.index';
               
       // Fetch all active books
       // $books = Book::where('status', 'active')->latest()->get();
          $query = Book::query();
          
     $query->where('status', 'active');
    // search by title / description
    if ($request->filled('search')) {
        $search = $request->input('search');
        $query->where(function($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    // Filter by price type
    // if ($request->filled('price')) {
    //     if ($request->input('price') === 'free') {
    //         $query->where('price', 0);
    //     } elseif ($request->input('price') === 'paid') {
    //         $query->where('price', '>', 0);
    //     }
    // }
    
        if ($request->filled('price')) {
        $query->where('pricing_type', $request->input('price'));
    }

    //  Filter by language
    if ($request->filled('language')) {
        $query->where('language', $request->input('language'));
    }

    //  Pagination (optional)
    $books = $query->latest()->paginate(12)->withQueryString();
               //dd($books);
        return view($view_path, compact('books'));
    }
    public function show($slug)
{
   $book = Book::where('slug', $slug)->firstOrFail();
    // Fetch SEO data for the book details page
    $seo = SeoField::where('route', 'book.details')->first();
           
    $view_path = 'frontend.' . get_frontend_settings('theme') . '.book.details';
         // dd( $view_path);
    return view($view_path, compact('book'));
}
    
}