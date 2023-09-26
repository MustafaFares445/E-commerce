<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): JsonResponse
    {
        if ($request->category_id){
            $products =  Product::where('category_id' , $request->category_id)->paginate(15);
        }else if ($request->store_id) {
            $products = Product::where('store_id', $request->store_id)->paginate(15);
        }else{
            $products = Product::with(['category' , 'store'])->paginate(15);
        }

        return $this->successResponse('products' , ProductResource::collection($products));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {

       $product = Product::create($request->all());

        $this->uploadFile($request ,  $product->image, 'products-images');

        return $this->showMessage('The Product has been created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product): JsonResponse
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

        $product->update($request->except('tags'));

        $tags = explode(',' , $request->input('tags'));
        $tags_id = [];

        $saved_tags = Tag::all();
        foreach ($tags as $tag_name){
            $slug = Str::slug($tag_name);
            $tag = $saved_tags->where('slug' , $slug)->first();

            if (!$tag){
                $tag  = Tag::create([
                   'name' => $tag_name,
                   'slug' => $slug,
                ]);
            }
            $tags_id[] = $tag->id;
        }

        $product->tags()->sync($tags_id);

        $this->showMessage('Product has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product): JsonResponse
    {
        $this->deleteFile($product , 'image');

        $product->delete();

        return $this->showMessage('Product has been deleted successfully');
    }
}
