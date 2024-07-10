<?php

namespace App\Http\Controllers;

use App\Models\payment;
use App\Http\Requests\StorepaymentRequest;
use App\Http\Requests\UpdatepaymentRequest;
use App\Models\menu;
use App\Models\paymentMethod;
use App\Models\transaction;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $payments = payment::whereRaw('CAST(totalPayment AS CHAR) LIKE?', ['%'.$request->search.'%'])
        ->get();
        $transactions = transaction::all();
        $paymentMethods = paymentMethod::all();
        return view('layouts.payment.index',compact('payments','transactions','paymentMethods'));
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
    public function store(StorepaymentRequest $request)
    {
        $tr = transaction::find($request->transaction_id);
        $harga = menu::find($tr->menu_id);
        if($request->totalPayment < $tr->priceTotal){
            return redirect()->route('payment')->with('hapus','Dana tidak cukup untuk melakukan transaksi ini');
        }else{
            payment::create([
                'transaction_id'=>$request->transaction_id,
                'paymentMethod_id'=>$request->paymentMethod_id,
                'totalPayment'=>$request->totalPayment,
                'change'=>$request->totalPayment - $tr->priceTotal,
            ]);
            $tr->update(['status'=>'Paid']);
            return redirect()->route('payment')->with('add','Pembayaran telah berhasil');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatepaymentRequest $request, payment $payment)
    {
        $tr = transaction::find($payment->transaction_id);
        $tr->update([
            'status'=>'Complete'
        ]);
        return redirect()->route('payment')->with('add','Transaksi telah selesai');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(payment $payment)
    {
        //
    }
}
