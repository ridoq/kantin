<?php

namespace App\Http\Controllers;

use App\Models\supplier;
use App\Models\ingredient;
use App\Http\Requests\StoreingredientRequest;
use App\Http\Requests\UpdateingredientRequest;
use Illuminate\Http\Request;

class IngredientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $ingredients = ingredient::where('name', 'LIKE', "%$request->search%")->get();
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

        $bahan = ingredient::where('name', $request->name)->where('supplier_id', $request->supplier_id)->first();

        if ($bahan) {
            $bahan->stock += $request->stock;
            $bahan->save();
        } else {

            ingredient::create([
                'name' => $request->name,
                'stock' => $request->stock,
                'supplier_id' => $request->supplier_id
            ]);
        }
        return redirect()->back()->with('success', 'Data berhasil disimpan.');

        //     $ingredient = Ingredient::where('name', $request->name)
        //                         ->where('supplier_id', $request->supplier_id)
        //                         ->first();

        // if ($ingredient) {
        //     // Jika data sudah ada, tambahkan stok
        //     $ingredient->stock += $request->stock;
        //     $ingredient->save();
        // } else {
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
    public function update(UpdateIngredientRequest $request, Ingredient $ingredient)
    {
        // Cek apakah ada bahan dengan nama dan supplier_id yang sama seperti yang diinput
        $existingIngredient = Ingredient::where('name', $request->name)
            ->where('supplier_id', $request->supplier_id)
            ->where('id', '!=', $ingredient->id) // Exclude current ingredient
            ->where('supplier_id', 'LIKE', $request->supplier_id)
            ->first();

        if ($existingIngredient) {
            // Jika ada, tambahkan stok baru ke stok yang ada
            $existingIngredient->stock += $request->stock;
            $existingIngredient->save();

            // Hapus ingredient lama
            $ingredient->delete();
        } else {
            // Jika tidak ada, update ingredient yang sedang diproses
            $ingredient->update([
                'name' => $request->name,
                'stock' => $request->stock,
                'supplier_id' => $request->supplier_id,
            ]);
        }

        return redirect()->route('ingredient')->with('edit', 'Data berhasil diupdate');
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
