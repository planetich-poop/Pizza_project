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
     * $user = auth()->user();
     *
     * if (!$user) {
     * return response()->json(['message' => 'Unauthorized'], 401);
     * }
     *
     * $cart = $user->cart()->with('cart_items')->first();
     *
     * if (!$cart) {
     * return response()->json(['message' => 'Cart not found'], 404);
     * }
     * return response()->json($cart);
     */
    public function index()
    {
       $user = auth('api')->user();
        return response()->json($user->cart->cart_items->map(function ($item) {
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
        $user = auth('api')->user();
        $item = $user->cart->cart_items()->where('product_id', $productValidate['product_id'])->first();

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

            $user->cart->cart_items()->create([
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
        $user = auth('api')->user();
        $quantity_product = $user->cart->cart_items()->where('product_id',$productValidate['product_id'])->first();
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
    public function destroy()
    {
        $user = auth('api')->user();
        $cart = $user->cart;
        $cart->cart_items()->where('cart_id',)->delete();
        return response()->json('cart deleted');
    }
}
