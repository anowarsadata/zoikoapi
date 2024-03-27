<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use Auth;
use Illuminate\Http\Request;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //$check_authentication = Auth::user();
        //if ($check_authentication) {
        $validatedData = $this->validate($request, [
            'cart_id' => 'required|int',
            'product_id' => 'required|int',
        ]);
        if ($validatedData) {
            $existing_check = CartItem::where('cart_id', $request->cart_id)->where('product_id', $request->product_id)->exists();
            if (!$existing_check) {
                $result = CartItem::create($request->all());
                return response()->json([
                    'success' => true,
                    'message' => "Record created successfully.",
                    'cart item' => $result,
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Record already exist',
                ], 200);
            }
        }
        /*} else {
            return response()->json([
                'message' => $check_authentication,
            ], 200);
        }*/
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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
