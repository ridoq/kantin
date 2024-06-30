<?php

namespace App\Http\Controllers;

use App\Models\menu;
use App\Models\customer;
use App\Models\employee;
use App\Models\transaction;
use App\Http\Requests\StoretransactionRequest;
use App\Http\Requests\UpdatetransactionRequest;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = transaction::all();
        $customers = customer::all();
        $menus = menu::all();
        $employees = employee::all();
        return view('layouts.transaction.index', compact('transactions','customers','menus','employees'));
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
    public function store(StoretransactionRequest $request)
{
    // Ambil data menu berdasarkan menu_id yang dikirimkan dari request
    $menu = Menu::findOrFail($request->menu_id);

    // Buat transaksi baru
    Transaction::create([
        'customer_id' => $request->customer_id,
        'menu_id' => $request->menu_id,
        'totalAmount' => $request->totalAmount,
        'priceTotal' => $menu->price * $request->totalAmount,
        'transactionDate' => $request->transactionDate,
        'employee_id' => $request->employee_id
    ]);

    return redirect()->back()->with('add','Data telah berhasil ditambahkan');
}

    /**
     * Display the specified resource.
     */
    public function show(transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatetransactionRequest $request, transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(transaction $transaction)
    {
        try{
            $transaction->delete();
            return redirect()->back()->with('hapus','Data berhasil dihapus');
        }catch(\Exception $e){
            return redirect()->back()->with('restrict','Data tidak dapat dihapus karena masih terpakai di tabel yang lain.');
        }
    }
}
