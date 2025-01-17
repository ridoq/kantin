<?php

namespace App\Http\Controllers;

use App\Models\paymentMethod;
use App\Http\Requests\StorepaymentMethodRequest;
use App\Http\Requests\UpdatepaymentMethodRequest;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $paymentMethods = paymentMethod::where('method', 'LIKE', "%$request->search%")
            ->get();
        return view('layouts.paymentMethod.index', compact('paymentMethods','request'));
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
    public function store(StorepaymentMethodRequest $request)
    {
        try {
            paymentMethod::create([
                'method' => strtoupper($request->method)
            ]);
            return redirect()->route('paymentMethod')->with('add', 'Data Berhasil ditambah');
        } catch (\Exception $e) {
            return redirect()->back()->with('hapus', 'Metode pembayaran telah terdaftar');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(paymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(paymentMethod $paymentMethod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatepaymentMethodRequest $request, paymentMethod $paymentMethod)
    {
        try {
            $paymentMethod->update([
                'method' => strtoupper($request->method)
            ]);
            return redirect()->back()->with('add', 'Data berhasil diperbarui');
        } catch (\Exception $e) {
            return redirect()->back()->with('hapus', 'Metode pembayaran telah terdaftar');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(paymentMethod $paymentMethod)
    {
        try {
            $paymentMethod->delete();
            return redirect()->back()->with('add', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('restrict', 'Data tidak dapat dihapus karena masih dipakai di tabel yang lain');
        }
    }
}
