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
        return view('layouts.paymentMethod.index', compact('paymentMethods'));
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
        paymentMethod::create([
            'method'=>$request->method
        ]);
        return redirect()->route('paymentMethod')->with('add','Data Berhasil ditambah');
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
        $paymentMethod->update([
            'method'=>$request->method
        ]);
        return redirect()->back()->with('add','Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(paymentMethod $paymentMethod)
    {
        $paymentMethod->delete();
        return redirect()->back()->with('hapus','Data berhasil dihapus');
    }
}
