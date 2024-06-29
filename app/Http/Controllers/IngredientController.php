<?php

namespace App\Http\Controllers;

use App\Models\supplier;
use App\Models\ingredient;
use App\Http\Requests\StoreingredientRequest;
use App\Http\Requests\UpdateingredientRequest;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ingredients = ingredient::all();
        $suppliers = supplier::all();
        return view('layouts.ingredient.index', compact('ingredients', 'suppliers'));
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
    public function store(StoreingredientRequest $request)
    {
        ingredient::create([
            'name' => $request->name,
            'stock' => $request->stock,
            'supplier_id' => $request->supplier_id
        ]);
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(ingredient $ingredient)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ingredient $ingredient)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateingredientRequest $request, ingredient $ingredient)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ingredient $ingredient)
    {
        try {
            $ingredient->delete();
            return redirect()->back()->with('hapus', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('restrict', 'Data tidak dapat dihapus karena masih terpakai di tabel yang lain.');
        }
    }
}
