<?php

namespace App\Http\Controllers;

use App\Models\supplier;
use App\Http\Requests\StoresupplierRequest;
use App\Http\Requests\UpdatesupplierRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $suppliers = supplier::where('name', 'LIKE', "%$request->search%")
            ->orWhereRaw('CAST(tel AS CHAR) LIKE?', ['%' . $request->search . '%'])
            ->orWhereRaw('address LIKE?', ['%' . $request->search . '%'])
            ->get();
        return view('layouts.supplier.index', compact('suppliers'));
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
    public function store(StoresupplierRequest $request)
    {
        supplier::create([
            'name' => $request->name,
            'tel' => $request->tel,
            'address' => $request->address,
        ]);
        return redirect()->back()->with('add', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(supplier $supplier)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(supplier $supplier)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatesupplierRequest $request, supplier $supplier)
    {
        try {
            $supplier->update([
                'name' => $request->name,
                'tel' => $request->tel,
                'address' => $request->address
            ]);
            return redirect()->route('supplier')->with('edit', 'Data berhasil di update');
        } catch (QueryException $e) {
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(supplier $supplier)
    {
        try {
            $supplier->delete();
            return redirect()->back()->with('hapus', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('restrict', 'Data tidak dapat dihapus karena masih terpakai di tabel yang lain.');
        }
    }
}
