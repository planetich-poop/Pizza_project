<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\User;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection(User::all());
    }

    public function store(Request $request)
    {
       $user = request()->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => ['required',  'min:8', 'confirmed'],

        ]);

       User::create($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  User $user)
    {
        $userValidate = request()->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required','email'],
            'password' => ['required',  'min:6', 'confirmed'],
            'phone'=>[ 'min:10', 'max:10'],
            'address'=>[ 'min:3'],

        ]);

        $user->update($userValidate);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        product::destroy($id);
        return response()->json('Your User has been successfully removed', 204);
    }
}
