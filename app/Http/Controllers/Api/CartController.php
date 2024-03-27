<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
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
            'user_id' => 'required|int'
        ]);
        if ($validatedData) {
            $result = Cart::create($request->all());
            return response()->json([
                'success' => true,
                'message' => "Record created successfully.",
                'cart' => $result,
            ], 200);
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
        //$check_authentication = Auth::user();
        //if ($check_authentication) {
        $cart = Cart::query()
            ->where("user_id", $id)
            ->get();

        return response()->json([
            'Cart' => $cart,
        ]);
        /*} else {
            return response()->json([
                'message' => $check_authentication,
            ], 200);
        }*/
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
        //$check_authentication = Auth::user();
        //if ($check_authentication) {
        $cart = Cart::find($id);

        if (!$cart) {
            return response()->json(['message' => 'Record not found'], Response::HTTP_NOT_FOUND);
        }

        $cart->delete();
        return response()->json(['message' => 'Record deleted'], Response::HTTP_OK);
        /* } else {
             return response()->json([
                 'message' => $check_authentication,
             ], 200);
         }*/
    }
}
