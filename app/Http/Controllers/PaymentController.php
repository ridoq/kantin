<?php

namespace App\Http\Controllers;

use App\Models\menu;
use App\Models\payment;
use App\Models\transaction;
use Illuminate\Http\Request;
use App\Models\paymentMethod;
use App\Http\Requests\StorepaymentRequest;
use App\Http\Requests\UpdatepaymentRequest;
use App\Models\customer;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $payments = payment::whereRaw('CAST(totalPayment AS CHAR) LIKE?', ['%' . $request->search . '%'])
            ->orWhereRelation('transaction','kode_transaksi','LIKE',"%$request->search%")
            ->orWhereRelation('transaction','totalAmount','LIKE',"%$request->search%")
            ->orWhereRelation('transaction','priceTotal','LIKE',"%$request->search%")
            ->orWhereRelation('transaction','status','LIKE',"%$request->search%")
            ->orWhereRelation('paymentMethod','method','LIKE',"%$request->search%")
            ->orWhereRaw('CAST(totalPayment as CHAR) LIKE?', ['%'.$request->search.'%'])
            ->orWhereRaw('CAST(change as CHAR) LIKE?', ['%'.$request->search.'%'])
            ->get();
        $transactions = transaction::whereRaw('kode_transaksi LIKE?',['%'.$request->search.'%'])
        ->orWhereRelation('customer','name','LIKE',"%$request->search%")
        ->orWhereRelation('menu','name','LIKE',"%$request->search%")
        ->orWhereRelation('employee','name','LIKE',"%$request->search%")
        ->orWhereRaw('CAST(totalAmount as CHAR) LIKE?',['%'.$request->search.'%'])
        ->get();
        $paymentMethods = paymentMethod::all();
        return view('layouts.payment.index', compact('payments', 'transactions', 'paymentMethods'));
    }

    public function trashPayment(Request $request)
    {
        $payments = payment::onlyTrashed()->whereRaw('CAST(totalPayment AS CHAR) LIKE?', ['%' . $request->search . '%'])
            ->get();
        $transactions = transaction::all();
        $paymentMethods = paymentMethod::all();
        return view('layouts.payment.history', compact('payments', 'transactions', 'paymentMethods'));
    }
    public function restorePayment($id)
    {
        try {
            $payments = payment::withTrashed()->findOrFail($id);
            if (!empty($payments)) {
                $payments->restore();
            }
            return redirect()->route('payment')->with('add', 'Data berhasil dikembalikan');
        } catch (\Exception $e) {
            return redirect()->back()->with('hapus', 'Data yang dikembalikan tidak valid');
        }
    }
    public function deletePermanentPayment($id)
    {
        try {
            $payments = payment::withTrashed()->findOrFail($id);
            if (!empty($payments)) {
                $payments->forceDelete();
            }
            return redirect()->route('payment')->with('add', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('hapus', 'Data yang dihapus tidak valid');
        }
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
        if ($request->totalPayment < $tr->priceTotal) {
            return redirect()->route('payment')->with('hapus', 'Dana tidak cukup untuk melakukan transaksi ini');
        } else {
            payment::create([
                'transaction_id' => $request->transaction_id,
                'paymentMethod_id' => $request->paymentMethod_id,
                'totalPayment' => $request->totalPayment,
                'change' => $request->totalPayment - $tr->priceTotal,
            ]);
            $tr->update(['status' => 'Paid']);
            return redirect()->route('payment')->with('add', 'Pembayaran telah berhasil');
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
            'status' => 'Complete'
        ]);
        return redirect()->route('payment')->with('add', 'Transaksi telah selesai');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(payment $payment)
    {
        $payment->delete();
        return redirect()->route('trashPayment')->with('add', 'Data berhasil dipindahkan ke dalam history');
    }
}
