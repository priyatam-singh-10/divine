<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShopCart;
use Illuminate\Support\Facades\Log;
use App\Models\Order;
use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use App\Models\Coupon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class ShopCartController extends Controller
{
    public function addToCart(Request $request)
{
    $request->validate([
        'book_id' => 'required|integer|exists:books,id',
    ]);

    $book_id = $request->book_id;
    $book = Book::find($book_id);

    if (!$book || $book->stock <= 0) {
        return back()->with('error', 'This book is out of stock!');
    }

    if (Auth::check()) {
        // Logged-in user
        $user_id = Auth::id();

        $exists = ShopCart::where('user_id', $user_id)
                          ->where('item_id', $book_id)
                          ->first();

        if ($exists) {
            return back()->with('message', 'Book already in cart');
        }

        ShopCart::create([
            'user_id' => $user_id,
            'item_id' => $book_id,
        ]);

    } else {
        // Guest user: store in session
        $guestCart = session()->get('guest_cart', []);

        if (in_array($book_id, $guestCart)) {
            return back()->with('message', 'Book already in cart');
        }

        $guestCart[] = $book_id;
        session()->put('guest_cart', $guestCart);
    }

    return back()->with('success', 'Book added to cart');
}


public function index(Request $request)
{
    // Merge guest cart into user cart after login
    if (Auth::check() && session()->has('guest_cart')) {
        $user_id = Auth::id();
        $guestCart = session()->pull('guest_cart', []);
        foreach ($guestCart as $book_id) {
            ShopCart::firstOrCreate([
                'user_id' => $user_id,
                'item_id' => $book_id,
            ]);
        }
    }

    // Handle coupon logic (optional)
    $couponDiscount = 0;
    $coupon = null;

    $code = trim($request->query('coupon', ''));
    if (!empty($code)) {
        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            Session::flash('error', 'This coupon is not valid.');
            return redirect()->back();
        }

        if ($coupon->status && (time() >= $coupon->expiry)) {
            Session::flash('error', 'Oops! Coupon is expired.');
            return redirect()->back();
        }

        $couponDiscount = $coupon->discount;
    }

    // Fetch cart items
    if (Auth::check()) {
        $user_id = Auth::id();
        $cartItems = ShopCart::where('user_id', $user_id)
            ->with('book')
            ->get();
    } else {
        $guestCart = session()->get('guest_cart', []);
        $cartItems = collect();
        if (!empty($guestCart)) {
            $books = Book::whereIn('id', $guestCart)->get();
            foreach ($books as $book) {
                $cartItems->push((object)[
                    'id' => $book->id,
                    'book' => $book,
                    'quantity' => 1,
                ]);
            }
        }
    }

    return view('frontend.default.cart.index', compact('cartItems', 'couponDiscount', 'coupon'));
}





public function updateQty(Request $request)
{
    $request->validate([
        'item_id' => 'required|integer',
        'quantity' => 'required|integer|min:1'
    ]);

    if (Auth::check()) {
        $cartItem = ShopCart::where('id', $request->item_id)
                    ->where('user_id', auth()->id())
                    ->with('book')
                    ->firstOrFail();

        $cartItem->quantity = $request->quantity;
        $cartItem->save();

        $book = $cartItem->book;
        $discount = $book->discount_percentage ?? 0;
        $discountedPrice = $book->price - ($book->price * ($discount / 100));

        $itemTotal = $discountedPrice * $request->quantity;
    } else {
        // Guest cart in session
        $guestCart = session()->get('guest_cart', []);
        if (!in_array($request->item_id, $guestCart)) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found in cart.'
            ], 404);
        }

        // For guest, quantity is always 1
        $book = Book::findOrFail($request->item_id);
        $discount = $book->discount_percentage ?? 0;
        $discountedPrice = $book->price - ($book->price * ($discount / 100));
        $itemTotal = $discountedPrice * 1; // guest quantity always 1
    }

    return response()->json([
        'success' => true,
        'item_total' => $itemTotal,
    ]);
}


public function destroy($id)
{
    if (Auth::check()) {
        $cartItem = ShopCart::where('id', $id)
                            ->where('user_id', Auth::id())
                            ->firstOrFail();

        $cartItem->delete();
    } else {
        // Guest cart
        $guestCart = session()->get('guest_cart', []);
        if (($key = array_search($id, $guestCart)) !== false) {
            unset($guestCart[$key]);
            session()->put('guest_cart', $guestCart);
        } else {
            return back()->with('error', 'Item not found in cart.');
        }
    }

    return back()->with('success', 'Item removed from cart');
}

    
//      public function handleWebhook(Request $request)
// {
//     $secret = env('RAZORPAY_WEBHOOK_SECRET');
//     $signature = $request->header('x-razorpay-signature');
//     $payload = $request->getContent();
//     $generatedSignature = hash_hmac('sha256', $payload, $secret);

//     if ($generatedSignature !== $signature) {
//         Log::warning('Razorpay Webhook: invalid signature');
//         return response()->json(['status' => 'invalid signature'], 400);
//     }

//     $event = $request->input('event');
//     $payment = $request->input('payload.payment.entity');

//     if ($event === 'payment.failed') {
//         Log::info('Payment failed webhook triggered', $payment);

//         // Extract notes added when order was created
//         $userId = $payment['notes']['user_id'] ?? null;
//         $cartIds = json_decode($payment['notes']['cart_items'] ?? '[]', true);

//         $user = $userId ? User::find($userId) : null;
//         $cartItems = !empty($cartIds)
//             ? ShopCart::whereIn('id', $cartIds)->with('book')->get()
//             : collect([]);

//         // If cart still exists, log failed attempt per book
//         if ($cartItems->isNotEmpty()) {
//             foreach ($cartItems as $item) {
//                 $book = $item->book;
//                 DB::table('orders')->insert([
//                     'user_id' => $userId,
//                     'book_id' => $book?->id,
//                     'quantity' => $item->quantity ?? 1,
//                     'total_price' => $book
//                         ? ($book->price - ($book->price * ($book->discount_percentage ?? 0) / 100)) * $item->quantity
//                         : $payment['amount'] / 100,
//                     'status' => 'pending',
//                     'payment_status' => 'failed',
//                     'payment_type' => 'online(razorpay)',
//                     'gateway_order_id' => $payment['order_id'],
//                     'gateway_payment_id' => $payment['id'],
//                     'shipping_address' => $user?->address ?? null,
//                     'full_shippingaddress' => $user?->full_address ?? null,
//                     'shipping_contact' => $user?->phone ?? null,
//                     'shipping_status' => 'pending',
//                     'created_at' => now(),
//                     'updated_at' => now(),
//                 ]);
//             }
//         } else {
//             // fallback generic failed entry
//             DB::table('orders')->insert([
//                 'user_id' => $userId,
//                 'book_id' => null,
//                 'quantity' => 0,
//                 'total_price' => $payment['amount'] / 100,
//                 'status' => 'pending',
//                 'payment_status' => 'failed',
//                 'payment_type' => 'online(razorpay)',
//                 'gateway_order_id' => $payment['order_id'],
//                 'gateway_payment_id' => $payment['id'],
//                 'shipping_address' => $user?->address ?? null,
//                 'full_shippingaddress' => $user?->full_address ?? null,
//                 'shipping_contact' => $user?->phone ?? null,
//                 'shipping_status' => 'pending',
//                 'created_at' => now(),
//                 'updated_at' => now(),
//             ]);
//         }
//     }

//     return response()->json(['status' => 'ok']);
//   }


public function handleWebhook(Request $request)
{
    $secret = env('RAZORPAY_WEBHOOK_SECRET');
    $signature = $request->header('x-razorpay-signature');
    $payload = $request->getContent();

    if (hash_hmac('sha256', $payload, $secret) !== $signature) {
        return response()->json(['status' => 'invalid signature'], 400);
    }

    $event = $request->input('event');
    $payment = $request->input('payload.payment.entity');
    $userId = $payment['notes']['user_id'] ?? null;
    $orderId = $payment['notes']['order_id'] ?? null;
    $cartItems = $payment['notes']['cart_items'] ?? null;
    $reference = $payment['notes']['reference'] ?? 'unknown';
    $amount = $payment['amount'] / 100;
    $status = $event === 'payment.failed' ? 'failed' : 'success';

    // Check for existing record
    $exists1 = DB::table('payment_logs')
        ->where('payment_id', $payment['id'])
        ->exists();

        $exists = DB::table('payment_logs')
        ->where('order_id', $orderId)
        ->exists();
        
    if (!$exists1&&!$exists) {
        DB::table('payment_logs')->insert([
            'user_id'    => $userId,
            'order_id'   => $orderId,
            'payment_id' => $payment['id'],
            'refrence'   => $reference,
            'status'     => $status,
            'amount'     => $amount,
            'gateway'    => 'razorpay',
            'cart_items' => $cartItems,
            'response'   => json_encode($payment),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    return response()->json(['status' => 'ok']);
}



public function getCartItemDetails(Request $request)
{
    $items = $request->input('items', []);
    $reference = $request->input('reference'); // book_purchase / course_purchase

    $results = [];

    if ($reference === 'book_purchase') {
        $books = \DB::table('books')->whereIn('id', array_column($items, 'item_id'))->get()->keyBy('id');
        foreach ($items as $item) {
            $book = $books[$item['item_id']] ?? null;
            $results[] = [
                'item_id'  => $item['item_id'],
                'title'    => $book->title ?? 'N/A',
                'quantity' => $item['quantity'],
                'price'    => $item['price'],
                'total'    => ($item['price'] * $item['quantity']),
            ];
        }
    } elseif ($reference === 'course_purchase') {
        $courses = \DB::table('courses')->whereIn('id', array_column($items, 'item_id'))->get()->keyBy('id');
        foreach ($items as $item) {
            $course = $courses[$item['item_id']] ?? null;
            $results[] = [
                'item_id'  => $item['item_id'],
                'title'    => $course->title ?? 'N/A',
                'quantity' => $item['quantity'],
                'price'    => $item['price'],
                'total'    => ($item['price'] * $item['quantity']),
            ];
        }
    }

    return response()->json($results);
}

}
