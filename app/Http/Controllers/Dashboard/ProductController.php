<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $products = Product::paginate(15);
        return $this->successResponse('products' , $products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

       $product = Product::create($request->all());

        $this->uploadFile($request ,  $product->image, 'products-images');

        return $this->showMessage('The Product has been created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $this->successResponse('product' , $product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $this->deleteFile($product , 'image');

        $this->uploadFile($request ,  $product->image, 'products-images');

        $product->update($request->all());

        $product->save();

        $this->showMessage('Product has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $this->deleteFile($product , 'image');

        $product->delete();

        return $this->showMessage('Product has been deleted successfully');
    }
}
