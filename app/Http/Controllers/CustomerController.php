<?php

namespace App\Http\Controllers;

use App\Models\customer;
use App\Http\Requests\StorecustomerRequest;
use App\Http\Requests\UpdatecustomerRequest;
use Illuminate\Http\Request;
use Termwind\Components\Raw;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $customers = customer::where('name', 'like', "%$request->search%")
        ->orWhereRaw("CAST(tel as VARCHAR) like ?", ["%".$request->search."%"])
        ->orWhereRaw("email like ?", ["%".$request->search."%"])
        ->orWhereRaw("address like ?", ["%".$request->search."%"])
        ->get();
        return view('layouts.customer.index', compact('customers','request'));
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
    public function store(StorecustomerRequest $request)
    {
        customer::create([
            'name' => $request->name,
            'tel'  => $request->tel,
            'email' => $request->email,
            'address' => $request->address
        ]);
        return redirect()->back()->with('add', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatecustomerRequest $request, customer $customer)
    {
            $customer->update([
                'name' => $request->name,
                'tel' => $request->tel,
                'email' => $request->email,
                'address' => $request->address,
            ]);
            return redirect()->route('customer')->with('edit', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(customer $customer)
    {
        try {
            $customer->delete();
            return redirect()->back()->with('add', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('restrict', 'Data tidak dapat dihapus karena masih terpakai di tabel yang lain.');
        }
    }
}
