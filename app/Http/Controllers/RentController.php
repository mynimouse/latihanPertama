<?php

namespace App\Http\Controllers;

use App\Models\Rent;
use Illuminate\Http\Request;

class RentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rent = Rent::paginate(10);
        return response()->json([
            'data' => $rent
        ]);
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
        $request->validate([
            'tenant' => 'required',
            'no_car' => 'required',
            'date_return' => 'required',
            'down_payment' => 'required',
            'total' => 'required',
        ]);
        $rent = Rent::create($request->all());

        return response()->json([
            'msg' => 'Create Rent Success',
            'data' => $rent
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Rent $rent)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rent $rent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tenant' => 'required',
            'no_car' => 'required',
            'date_borrow' => 'required',
            'date_return' => 'required',
            'down_payment' => 'required',
            'discount' => 'nullable',
            'total' => 'required',
        ]);
        $rent = Rent::find($id);
        $rent->update($request->all());

        return response()->json([
            'msg' => 'Update Rent Success',
            'data' => $rent
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $rent = Rent::find($id)->delete();
        return response()->json([
            'msg' => 'Update Rent Success',
            'data' => $rent
        ]);
    }
}
