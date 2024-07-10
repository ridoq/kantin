<?php

namespace App\Http\Controllers;

use App\Models\menu;
use App\UploadTrait;
use App\Models\customer;
use App\Models\employee;
use App\Models\stockMenu;
use App\Models\transaction;
use Illuminate\Http\Request;
use App\Http\Requests\StoretransactionRequest;
use App\Http\Requests\UpdatetransactionRequest;

class TransactionController extends Controller
{
    use UploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $transactions = transaction::where('kode_transaksi', 'LIKE', "%$request->search%")
            ->orWhereRaw('CAST(transactionDate AS CHAR) LIKE?', ['%' . $request->search . '%'])
            ->orWhereRelation('customer', 'name', 'LIKE', "%$request->search%")
            ->get();
        $menus = menu::all();
        $customers = customer::all();
        $employees = customer::all();
        return view('layouts.transaction.index', compact('transactions','employees', 'customers', 'menus'));
    }

    // public function payment(Request $request)
    // {
    //     $transactions = transaction::where('kode_transaksi', 'LIKE', "%$request->search%")
    //         ->orWhereRaw('CAST(transactionDate AS CHAR) LIKE?', ['%' . $request->search . '%'])
    //         ->orWhereRelation('customer', 'name', 'LIKE', "%$request->search%")
    //         ->get();
    //     $customers = customer::all();
    //     $stockMenus = stockMenu::all();
    //     return view('layouts.payment.index', compact('transactions', 'customers', 'stockMenus'));
    // }
    /**
     * Show the form for creating a new resource.
     */

    // public function storePayment(Storedetail_transactionRequest $request )
    // {
    //     $kode = "001";
    //     $kode_detail = "TR-" . $kode;
    //     $detail_transaction = detail_transaction::query()->latest()->first();
    //     if ($detail_transaction != null) {
    //         $old_kode = $detail_transaction->kode_detail;
    //         $nomor = substr($old_kode, 3);
    //         $old_nomor = intval($nomor) + 1;
    //         $kode_detail = "TR-" . sprintf("%03d", $old_nomor);
    //     }

    //     $priceTotal = transaction::findOrFail($request->transaction_id);
    //     detail_transaction::create([
    //         'kode_detail'=>$kode_detail,
    //         'transaction_id'=>$request->transaction_id,
    //         'totalPayment'=>$request->totalPayment,
    //         'change'=>$request->totalPayment - $priceTotal->priceTotal
    //     ]);
    //     return redirect()->route('detail')->with('add','Data berhasil ditambahkan');
    // }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoretransactionRequest $request)
    {

        $kode = "001";
        $kode_pemesanan = "ORD-" . $kode;
        $transaction = Transaction::query()->latest()->first();
        if ($transaction != null) {
            $old_kode = $transaction->kode_transaksi;
            $nomor = substr($old_kode, 4);
            $old_nomor = intval($nomor) + 1;
            $kode_pemesanan = "ORD-" . sprintf("%03d", $old_nomor);
        }

        $menu = menu::findOrFail($request->menu_id);
        $priceTotal =$menu->price * $request->totalAmount;
        // Buat transaksi baru
        Transaction::create([
            'kode_transaksi' => $kode_pemesanan,
            'customer_id' => $request->customer_id,
            'employee_id' => $request->employee_id,
            'menu_id' => $request->menu_id,
            'stock_menu_id' => $request->stock_menu_id,
            'totalAmount' => $request->totalAmount,
            'priceTotal' => $priceTotal,
            'transactionDate' => now()->toDateString(),
        ]);
        $menu->stock -= $request->totalAmount;
        $menu->save();

        return redirect()->back()->with('add', 'Data berhasil ditambahkan');
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
        $menu = menu::findOrFail($request->menu_id);
        if ($menu->stock < $request->totalAmount) {
            return redirect()->back()->with('hapus', 'Stok tidak mencukupi.');
        }
        $priceTotal = number_format($menu->price * $request->totalAmount, 2, ',', '.');
        $transaction->update([
            'customer_id' => $request->customer_id,
            'stock_menu_id' => $request->menu_id,
            'totalAmount' => $request->totalAmount,
            'priceTotal' => $priceTotal,
            'transactionDate' => now()->toDateString(),
        ]);
        return redirect()->back()->with('edit', 'Data berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(transaction $transaction)
    {
        try {
            $transaction->delete();
            return redirect()->back()->with('hapus', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('restrict', 'Data tidak dapat dihapus karena masih terpakai di tabel yang lain.');
        }
    }
}
