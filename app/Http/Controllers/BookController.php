<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    // Admin: List all books
    public function index(Request $request)
    {
        $search = $request->input('search');

        $books = Book::when($search, function ($query, $search) {
                return $query->where('title', 'like', "%$search%")
                             ->orWhere('author', 'like', "%$search%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.books.index', compact('books'));
    }

    // Admin: Show add form
    public function create()
    {
        return view('admin.books.create');
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'title'       => 'required|string|max:255',
        'author'      => 'required|string|max:255',
        'author_desc' => 'required|string',
        'description' => 'nullable|string',
        'price'       => 'required|numeric',
        'stock'       => 'required|integer',
        'status'      => 'required|in:active,inactive',
        'language'    => 'required|string',
        'pricing_type' => 'required|in:0,1',
        'images.*'    => 'nullable|image|max:2048',
        'image_type.*'=> 'required|string|in:cover,back,extra_img',
        'video'       => 'nullable|mimes:mp4,mov,avi,wmv|max:20480', // optional file
        'video_url'   => 'nullable|url', // optional URL
        'discount_percentage' => 'nullable|numeric|min:0|max:100',
    ]);

    $allImages = [];

    // Handle dynamic multiple images
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $index => $file) {
            $type = $request->image_type[$index] ?? 'extra_img';
            $folder = $type;
            $destinationPath = public_path("uploads/book-thumbnail/$folder");

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move($destinationPath, $filename);

            $allImages[$type][] = "uploads/book-thumbnail/$folder/$filename";
        }
    }

    $validated['image'] = json_encode($allImages);

    // Handle video upload OR video URL
    if ($request->hasFile('video')) {
        $videoFile = $request->file('video');
        $videoName = time() . '_' . $videoFile->getClientOriginalName();
        $destinationPath = public_path("uploads/book-videos");

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $videoFile->move($destinationPath, $videoName);
        $validated['video'] = "uploads/book-videos/$videoName";
    } elseif ($request->filled('video_url')) {
        $validated['video'] = $request->video_url;
    } else {
        $validated['video'] = null;
    }

    // Add pricing_type and user_id
    $validated['pricing_type'] = $request->input('pricing_type') == 1 ? 'paid' : 'free';
    $validated['user_id'] = Auth::id();
    $validated['language'] = $request->input('language');

    // Generate unique slug
    $slug = Str::slug($validated['title']);
    $originalSlug = $slug;
    $counter = 1;
    while (Book::where('slug', $slug)->exists()) {
        $slug = $originalSlug . '-' . $counter;
        $counter++;
    }
    $validated['slug'] = $slug;

    // Create book
    Book::create($validated);

    return redirect()->route('admin.books')->with('success', 'Book added successfully.');
}




    // Admin: Show edit form
    public function edit($id)
    {
        $book = Book::findOrFail($id);
        return view('admin.books.edit', compact('book'));
    }

  // Admin: Update book
public function update(Request $request, $id)
{
    $book = Book::findOrFail($id);


    $validated = $request->validate([
        'title'       => 'required|string|max:255',
        'author'      => 'required|string|max:255',
        'author_desc' => 'required|string',
        'description' => 'nullable|string',
        'price'       => 'required|numeric',
        'stock'       => 'required|integer',
        'status'      => 'required|in:active,inactive',
        'language'    => 'required|string',
        'pricing_type'     => 'required|in:0,1',
        'images.*'    => 'nullable|image|max:5120',
        'image_type.*'=> 'required|string|in:cover,back,extra_img',
        'video'       => 'nullable|mimes:mp4,mov,avi,wmv|max:5120',
        'video_url'   => 'nullable|url',
        'discount_percentage' => 'nullable|numeric|min:0|max:100',
    ]);

    $allImages = json_decode($book->image, true) ?? [];

    // Handle dynamic multiple images
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $index => $file) {
            $type = $request->image_type[$index] ?? 'extra_img';
            $folder = $type;
            $destinationPath = public_path("uploads/book-thumbnail/$folder");

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move($destinationPath, $filename);

            $allImages[$type][] = "uploads/book-thumbnail/$folder/$filename";
        }
    }

    $validated['image'] = json_encode($allImages);

    // Handle video upload OR video URL
    if ($request->hasFile('video')) {
        $videoFile = $request->file('video');
        $videoName = time() . '_' . $videoFile->getClientOriginalName();
        $destinationPath = public_path("uploads/book-videos");

        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $videoFile->move($destinationPath, $videoName);
        $validated['video'] = "uploads/book-videos/$videoName";
    } elseif ($request->filled('video_url')) {
        $validated['video'] = $request->video_url;
    } else {
        // Keep existing video if nothing new is provided
        $validated['video'] = $book->video;
    }

    // Add/update pricing_type based on is_paid
    $validated['pricing_type'] = $request->input('pricing_type') == 1 ? 'paid' : 'free';
    $validated['user_id'] = Auth::id();
    $validated['language'] = $request->input('language');

    // Generate unique slug if title changed
    if ($book->title !== $validated['title']) {
        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $counter = 1;

        while (Book::where('slug', $slug)->where('id', '!=', $book->id)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $validated['slug'] = $slug;
    }

    // Update the book record
    $book->update($validated);

    return redirect()->route('admin.books')->with('success', 'Book updated successfully.');
}

    // Admin: Delete book
    public function destroy($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();

        return redirect()->route('admin.books')->with('success', 'Book deleted successfully.');
    }
}
