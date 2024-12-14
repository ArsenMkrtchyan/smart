<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Price;
use Illuminate\Support\Facades\Auth;

class PriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $prices = Price::all();

        return view('prices.index', compact('prices'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create()
    {
        return view('prices.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'price_name' => 'required|string|max:255',
            'detail' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        Price::create([
            'price_name' => $validatedData['price_name'],
            'detail' => $validatedData['detail'],
            'amount' => $validatedData['amount'],
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('prices.index')->with('success', 'Price created successfully.');
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
    public function edit($id)
    {
        $price = Price::findOrFail($id);
        return view('prices.edit', compact('price'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'price_name' => 'required|string|max:255',
            'detail' => 'required|string',
            'amount' => 'required|numeric',
        ]);

        $price = Price::findOrFail($id);

        $price->update([
            'price_name' => $validatedData['price_name'],
            'detail' => $validatedData['detail'],
            'amount' => $validatedData['amount'],
        ]);

        return redirect()->route('prices.index')->with('success', 'Price updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
