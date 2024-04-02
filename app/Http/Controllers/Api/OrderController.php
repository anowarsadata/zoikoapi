<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $check_authentication = Auth::user();
        if ($check_authentication) {
            if ($check_authentication->hasRole('admin')) {
                $orders = Order::all();
                return response()->json([
                    'orders' => $orders,
                ], 200);
            } else {
                $orders = Order::find($check_authentication->id);
                return response()->json([
                    'orders' => $orders,
                ], 200);
            }
        } else {
            return response()->json([
                'message' => $check_authentication,
            ], 200);
        }
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
        $check_authentication = Auth::user();
        if ($check_authentication) {
            $validatedData = $this->validate($request, [
                'user_id' => 'required|int',
                'currency_id' => 'required|int',
                'billing_address_id' => 'required|int',
                'shipping_address_id' => 'required|int',
            ]);
            if ($validatedData) {
                $result = Order::create($request->all());
                return response()->json([
                    'success' => true,
                    'message' => "Record created successfully.",
                    'order' => $result,
                ], 200);
            }
        } else {
            return response()->json([
                'message' => $check_authentication,
            ], 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $check_authentication = Auth::user();
        if ($check_authentication) {
            if ($check_authentication->hasRole('admin')) {
                $orders = Order::find($id);
                return response()->json([
                    'orders' => $orders,
                ], 200);
            }
        } else {
            return response()->json([
                'message' => $check_authentication,
            ], 200);
        }
    }


    /**
     * Display the specified resources based on user id for admin user.
     */
    public function get_orders_by_user_id(string $id)
    {
        $check_authentication = Auth::user();
        if ($check_authentication) {
            if ($check_authentication->hasRole('admin')) {
                $orders = Order::where('user_id', '=', $id)
                    ->join('currencies', 'currencies.id', '=', 'orders.currency_id')
                    ->get();
                return response()->json([
                    'orders' => $orders,
                ], 200);
            }
        } else {
            return response()->json([
                'message' => $check_authentication,
            ], 200);
        }
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
