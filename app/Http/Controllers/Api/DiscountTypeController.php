<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DiscountType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscountTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discount_types = DiscountType::all();

        return response()->json([
            'discount_types' => $discount_types,
        ], 200);
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
        if ($check_authentication && $check_authentication->hasRole('admin')) {
            $validatedData = $this->validate($request, [
                'name' => 'required|min:3|max:255|string'
            ]);

            $discount_type = DiscountType::create($validatedData);

            return response()->json([
                'success' => true,
                'message' => 'Record created successfully!',
                'category' => $discount_type,
            ]);
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
