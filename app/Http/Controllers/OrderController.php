<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['checkout','place']);
        $this->middleware(['auth'])->only(['adminIndex','updateStatus']);
    }

    // User checkout page
    public function checkout()
    {
        $cart = Cart::where('user_id', auth()->id())->where('status','active')
            ->with('items.product')->firstOrFail();
        return view('checkout.index', compact('cart'));
    }

    // Create order from cart
    public function place(Request $request)
    {
        $data = $request->validate([
            'billing_name'    => 'required|string|max:255',
            'billing_email'   => 'required|email',
            'billing_phone'   => 'nullable|string|max:50',
            'billing_address' => 'nullable|string|max:255',
            'billing_city'    => 'nullable|string|max:100',
            'billing_state'   => 'nullable|string|max:100',
            'billing_postcode'=> 'nullable|string|max:50',
            'billing_country' => 'nullable|string|max:100',
        ]);

        $cart = Cart::where('user_id', auth()->id())->where('status','active')
            ->with('items.product')->firstOrFail();

        abort_if($cart->items->count() === 0, 422, 'Cart empty');

        return DB::transaction(function() use ($cart, $data) {

            $subtotal = $cart->items->sum('total');
            $discount = 0; $tax=0; $shipping=0;
            $total = $subtotal - $discount + $tax + $shipping;

            $order = Order::create(array_merge($data, [
                'number' => 'ORD-'.now()->format('Ymd').'-'.Str::upper(Str::random(5)),
                'user_id' => auth()->id(),
                'cart_id' => $cart->id,
                'status' => 'pending',
                'subtotal'=>$subtotal,
                'discount'=>$discount,
                'tax'=>$tax,
                'shipping'=>$shipping,
                'total'=>$total,
                'payment_status'=>'pending',
            ]));

            foreach ($cart->items as $ci) {
                // reduce stock
                if ($ci->quantity > $ci->product->stock) {
                    abort(422, 'Insufficient stock for '.$ci->product->name);
                }
                $ci->product->decrement('stock', $ci->quantity);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $ci->product_id,
                    'product_name' => $ci->product->name,
                    'sku' => $ci->product->sku,
                    'quantity' => $ci->quantity,
                    'price' => $ci->price,
                    'total' => $ci->total,
                ]);
            }

            $cart->update(['status'=>'converted']);
            $cart->items()->delete(); // clear items after conversion

            return redirect()->route('payments.create', $order)->with('success','Order placed. Proceed to payment.');
        });
    }

    // Admin order list
    public function adminIndex(Request $request)
    {
           $q = Order::with([
        'user' => function ($q) {
            $q->withTrashed(); // include soft-deleted users
        },
        'book' => function ($q) {
            $q->withTrashed(); // include soft-deleted books
        },
    ])->latest();

    // Search filter (user name or order id)
    if ($s = $request->get('search')) {
        $q->where(function ($query) use ($s) {
            $query->where('id', 'like', "%$s%")
                  ->orWhereHas('user', function ($q2) use ($s) {
                      $q2->withTrashed()->where('name', 'like', "%$s%");
                  });
        });
    }

    // Status filter
    if ($st = $request->get('status')) {
        $q->where('status', $st);
    }

    $orders = $q->paginate(20)->withQueryString();
        return view('admin.orders.index', compact('orders'));
    }

    // // Admin update order status
    // public function updateStatus(Request $request, Order $order)
    // {
    //     $data = $request->validate([
    //         'status'=>'required|in:pending,paid,processing,shipped,completed,cancelled'
    //     ]);
    //     $order->update($data);
    //     return back()->with('success','Order status updated.');
    // }


    public function destroy($id)
{
    // Find the order by ID
    $order = Order::find($id);

    // Check if the order exists
    if (!$order) {
        return redirect()->route('orders.index')->with('error', 'Order not found.');
    }

    // Delete the order
    $order->delete();

    // Redirect with success message
    return redirect()->route('admin.orders')->with('success', 'Order deleted successfully.');
}


public function updateStatus(Request $request, $id)
{
    $order = Order::findOrFail($id);
    $request->validate(['status' => 'required|in:pending,completed,cancelled']);
    $order->update(['status' => $request->status]);
    return back()->with('success', 'Order status updated successfully.');
}

public function updatePaymentStatus(Request $request, $id)
{
    $order = Order::findOrFail($id);
    $request->validate(['payment_status' => 'required|in:unpaid,paid']);
    $order->update(['payment_status' => $request->payment_status]);
    return back()->with('success', 'Payment status updated successfully.');
}

// public function updateShippingStatus(Request $request, $id)
// {
//     $order = Order::findOrFail($id);
//     $request->validate(['shipping_status' => 'required|in:pending,shipped,delivered,cancelled']);
//     $order->update(['shipping_status' => $request->shipping_status]);
//     try {
//         $user = $order->user; // assuming Order has user relationship
//         $subject = "Your Order #{$order->id} Shipping Status Updated";

//         $message = "Hello {$user->name},\n\n" .
//                   "Your order (Order ID: {$order->id}) shipping status has been updated to: " . ucfirst($order->shipping_status) . ".\n\n" .
//                   "Order Details:\n";

//         // Include ordered books
//         foreach ($order->orderItems as $item) { // assuming orderItems relationship
//             $message .= "- {$item->book->title} (x{$item->quantity})\n";
//         }

//         $message .= "\nYou can track your order from your dashboard.\n\n" .
//                     "Regards,\n" . config('app.name');

//         Mail::raw($message, function ($mail) use ($user, $subject) {
//             $mail->to($user->email)
//                  ->subject($subject);
//         });
//     } catch (\Exception $e) {
//         \Log::error('Failed to send shipping status email: ' . $e->getMessage());
//     }
//     return back()->with('success', 'Shipping status updated successfully.');
// }

public function updateShippingStatus(Request $request, $id)
{
    $order = Order::findOrFail($id);

    $request->validate([
        'shipping_status' => 'required|in:pending,shipped,delivered,cancelled'
    ]);

    // Update shipping status for all items under the same gateway_order_id
    Order::where('gateway_order_id', $order->gateway_order_id)
        ->update(['shipping_status' => $request->shipping_status]);

    try {
        $user = $order->user;
        $subject = "Your Order #{$order->id} Shipping Status Updated";

        // fetch all items under this gateway_order_id
        $orderItems = Order::where('gateway_order_id', $order->gateway_order_id)
                           ->with('book')
                           ->get();

        // build order details
        $messageBody = "";
        $total = 0;
        foreach ($orderItems as $item) {
            $bookTitle = $item->book->title ?? 'Unknown Book';
            $qty = $item->quantity ?? 1;
            $price = $item->total_price ?? 0;
            $total += $price;
            $messageBody .= "<tr>
                <td style='padding:8px;border:1px solid #ddd;'>{$bookTitle}</td>
                <td style='padding:8px;border:1px solid #ddd;'>{$qty}</td>
                <td style='padding:8px;border:1px solid #ddd;'>₹{$price}</td>
            </tr>";
        }

        // eautiful HTML email for status update
      $message = <<<HTML
<html>
<head><meta charset='UTF-8'></head>
<body style='font-family:Arial,sans-serif;background-color:#f6f6f6;padding:20px;'>
<table width='600' align='center' cellpadding='0' cellspacing='0' style='background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 2px 6px rgba(0,0,0,0.1);'>
    <tr>
        <td style='background: linear-gradient(135deg, #7A7A4A 0%, #4F6564 100%); padding: 10px; text-align: center'>
            <img src='https://divinetouch.info/public/uploads/light_logo/lightlogo-1748956508.png' alt='Logo' height='50' style='display:block;margin:0 auto;padding-bottom:4px;'>
            <h1 style='margin:0;color:#ffffff;font-size:26px;font-weight:600;'>Order Shipping Update!</h1>
        </td>
    </tr>
    <tr>
        <td style='padding:20px;'>
            <p>Dear <strong>{$user->name}</strong>,</p>
            <p>Your order <strong>#{$order->id}</strong> status has been updated to 
            <strong style='color:#4F6564;text-transform:capitalize;'>{$request->shipping_status}</strong>.</p>

            <h3 style='color:#4F6564;'>Order Summary:</h3>
            <table width='100%' cellpadding='0' cellspacing='0' style='border-collapse:collapse;margin-bottom:15px;'>
                <tr style='background:#f3f4f6;'>
                    <th style='padding:8px;border:1px solid #ddd;'>Book</th>
                    <th style='padding:8px;border:1px solid #ddd;'>Qty</th>
                    <th style='padding:8px;border:1px solid #ddd;'>Price</th>
                </tr>
                {$messageBody}
                <tr style='background:#f9fafb;font-weight:bold;'>
                    <td colspan='2' style='padding:8px;border:1px solid #ddd;'>Total</td>
                    <td style='padding:8px;border:1px solid #ddd;'>₹{$total}</td>
                </tr>
            </table>

            <p>You can track your order anytime from your dashboard.</p>
            <p style='margin-top:20px;'>Thank you for shopping with <strong>{$appName}</strong>!</p>
        </td>
    </tr>
    <tr>
        <td style='background:#f1f5f9;padding:10px;text-align:center;font-size:12px;color:#777;'>
            &copy; {date('Y')} {$appName}. All rights reserved.
        </td>
    </tr>
</table>
</body>
</html>
HTML;

        // end Email
        Mail::send([], [], function ($mail) use ($user, $subject, $message) {
            $mail->to($user->email)
                 ->subject($subject)
                 ->html($message);
        });

    } catch (\Exception $e) {
        Log::error('Failed to send shipping status email: ' . $e->getMessage());
    }

    return back()->with('success', 'Shipping status updated and email sent successfully.');
}



}
