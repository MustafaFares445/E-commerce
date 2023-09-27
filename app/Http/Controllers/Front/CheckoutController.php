<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\CartRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @throws \Throwable
     */
    public function store(Request $request , CartRepository $cart)
    {

        $request->validate([

        ]);

        $items = $cart->get();
        $items = $items->groupBy('product.store_id')->all();

        DB::beginTransaction();
        try {

            foreach ($items as $store_id => $cart_items){
                $order = Order::create([
                    'store_id' => $store_id,
                    'user_id' => Auth::id(),
                    'payment_method' => 'visa',
                ]);
            }

            foreach ($cart->get() as $item) {
                OrderItem::create([
                   'order_id' => $order->id,
                   'product_id' => $item->product_id,
                   'product_name' => $item->product_name,
                   'price' => $item->product->price,
                   'quantity' => $item->quantity
                ]);
            }

            foreach ($request->post('address') as $type => $address){
                $address['type'] = $type;
                $order->addresses()->create($address);
            }

            DB::commit();
        } catch (\Throwable $e){
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CartRepository $cart): JsonResponse
    {
        return $this->successResponse('cart' , $cart);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
