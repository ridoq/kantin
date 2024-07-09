<?php

namespace App\Http\Controllers;

use App\Models\menu;
use App\Models\stockMenu;
use App\Models\transaction;
use Illuminate\Http\Request;
use App\Models\detail_transaction;
use App\Http\Requests\Storedetail_transactionRequest;
use App\Http\Requests\Updatedetail_transactionRequest;

class DetailTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        $detail_transactions = detail_transaction::whereRaw('CAST(totalAmount AS CHAR) LIKE?', ['%' . $request->search . '%'])
            ->orWhereRelation('transactions', 'kode_transaksi', 'LIKE', "%$request->search")
            ->orWhereRaw('kode_detail LIKE?', ['%' . $request->search . '%'])
            ->get();
        $transactions = transaction::all();
        $stockMenus = stockMenu::all();
        return view('layouts.detail.index', compact('detail_transactions', 'transactions', 'stockMenus'));
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
    public function store(Storedetail_transactionRequest $request)
    {
        //kode_detail_transaksi generator
        $kode = "001";
        $kode_detail = "DT" . $kode;
        $detail_transaction = detail_transaction::query()->latest()->first();
        if ($detail_transaction != null) {
            $old_kode = $detail_transaction->kode_detail;
            $nomor = substr($old_kode, 2);
            $old_nomor = intval($nomor) + 1;
            $kode_detail = "TR" . sprintf("%03d", $old_nomor);
        }
        // /kode_detail

        $stockMenu = stockMenu::findOrFail($request->stock_menu_id);
        if ($stockMenu->stockNow < $request->totalAmount) {
            return redirect()->back()->with('hapus', 'Stok tidak mencukupi.');
        }
        $menu = menu::findOrFail($stockMenu->menu_id);
        $priceTotal = number_format($menu->price * $request->totalAmount, 2, ',', '.');
        detail_transaction::create([
            'kode_detail' => $kode_detail,
            'transaction_id' => $request->transaction_id,
            'stock_menu_id' => $request->stock_menu_id,
            'totalAmount' => $request->totalAmount,
            'totalPrice' => $priceTotal
        ]);

        // Update the stockNow column in the stockMenu table
        $stockMenu->stockNow -= $request->totalAmount;
        $stockMenu->save();

        return redirect()->back()->with('add', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(detail_transaction $detail_transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(detail_transaction $detail_transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Updatedetail_transactionRequest $request, detail_transaction $detail_transaction)
    {
        $stockMenu = stockMenu::findOrFail($request->stock_menu_id);
        if ($stockMenu->stockNow < $request->totalAmount) {
            return redirect()->back()->with('hapus', 'Stok tidak mencukupi.');
        }
        $originalTotalAmount = $detail_transaction->totalAmount;
        $menu = menu::findOrFail($stockMenu->menu_id);
        $priceTotal = number_format($menu->price * $request->totalAmount, 2, ',', '.');
        $detail_transaction->update([
            'transaction_id' => $request->transaction_id,
            'stock_menu_id' => $request->stock_menu_id,
            'totalAmount' => $request->totalAmount,
            'totalPrice' => $priceTotal
        ]);
        $stockMenu->stockNow += $originalTotalAmount;
        $stockMenu->stockNow -= $request->totalAmount;
        $stockMenu->save();
        return redirect()->route('detail')->with('add', 'Data berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(detail_transaction $detail_transaction)
    {
        $detail_transaction->delete();
        return redirect()->back()->with('hapus', 'Data berhasil Dihapus');
    }
}
