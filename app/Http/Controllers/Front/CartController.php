<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\Cart\CartModelRepository;
use App\Repositories\CartRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class CartController extends Controller
{

    private  CartModelRepository $cart;

    public function __construct(CartRepository $cart)
    {
        //App::make('cart');
        $this->cart = $cart;
    }


    public function index(): JsonResponse
    {
        $item = $this->cart->get();

        $total = $this->cart->total();

        return  $this->successResponse('item' , ItemResource::make($item->product , $total));

    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' =>  'required|int|exists:products,id',
            'quantity' => 'nullable|int|min:1',
        ]);

        $product = Product::find($request->post('product_id'));

        $item =  $this->cart->add($product , $request->quantity);

        $total = $this->cart->total();

        return $this->successResponse('item' , ItemResource::make($item , $total));
    }

    /**
     * Display the specified resource.
     */

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): JsonResponse
    {
        $request->validate([
            'product_id' =>  'required|int|exists:products,id',
            'quantity' => 'nullable|int|min:1',
        ]);

        $product = Product::find($request->id);

        $this->cart->update($product , $request->quantity);

        return  $this->showMessage('item has been added successfully') ;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->cart->delete($id);
    }
}
