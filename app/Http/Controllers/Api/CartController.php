<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CartItemRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = Cart::find(1);
        return response()->json($cart->cart_items->map(function ($item) {
            return [
                'product' => [
                    'name' => $item->product->name,
                    'category' => $item->product->category,
                    'price' => $item->product->price,
                    'image' => $item->product->image,
                ],
                'quantity' => $item->quantity
            ];
        }));
    }

    /**
     * добавление товаров в корзину .
     * как это реализовать?
     * надо понять откуда мы получаем данные и провалидировать их
     * после этого надо проверить существует ли этот товар у нас в корзине
     * если да , то добавить количество
     * если нет то добавить товар
     * стоит ли добавлять два ифа для постоянной проверки не увеличени
     * todo авторизация с помощью jwt токена
     */
    public function store(CartItemRequest $request)
    {

       $productValidate = $request ->validated();
       $cart = Cart::find(1);
        $item = $cart->cart_items()->where('product_id', $productValidate['product_id'])->first();

        if ($item) {
            $category = Product::find($productValidate['product_id'])->category;
            $newQuantity = $item->quantity + $productValidate['quantity'];

            if (
                ($category === 'pizza' && $newQuantity <= 10) ||
                ($category === 'drink' && $newQuantity <= 20)
            ) {
                $item->quantity = $newQuantity;
                $item->save();
                return response()->json('Ваш товар успешно добавлен');
            } else {
                return response()->json('Превышен лимит для этой категории', 400);
            }
        } else {

            $cart->cart_items()->create([
                'product_id' => $productValidate['product_id'],
                'quantity' => $productValidate['quantity'],
            ]);
            return response()->json('Товар добавлен в корзину');
        }

    }

    public function show(string $id)
    {
    }

    /**
     * todo добавление или удаление продукта в корзине .
     *
     */
    public function update(Request $request, string $id)
    {
        $productValidate = $request->validated();
        $cart = Cart::find(1);
        $quantity_product = $cart->cart_items()->where('product_id',$productValidate['product_id'])->first();
        $newQuantity = $quantity_product->quantity - $productValidate['quantity'];
        if($newQuantity<=0){
            $quantity_product->delete();
        }
        else{
            $quantity_product->update(['quantity' => $newQuantity]);
        }


    }

     /**
     * todo очистка  корзины полностью .
     */
    public function destroy(string $id)
    {
        $cart = Cart::find($id);
        $cart->cart_items()->where('cart_id',$id)->delete();
    }
}
