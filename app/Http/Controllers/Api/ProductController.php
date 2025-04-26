<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * показать пользвателю только name description price image
     *
     */
    public function index()
    {
       return ProductResource::collection(Product::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
       $productValidate = request()->validate([
        ]);
        Product::create($productValidate);

    }
    public function show(Product $product)
    {
        return $product;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
       $productUpdate = request()->validate();
        $product->update($productUpdate);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        product::destroy($id);
        return response()->json('Your product has been successfully removed', 204);
    }
}
