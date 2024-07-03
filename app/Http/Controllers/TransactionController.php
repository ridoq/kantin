<?php

namespace App\Http\Controllers;

use App\Models\menu;
use App\Models\customer;
use App\Models\employee;
use App\Models\transaction;
use App\Http\Requests\StoretransactionRequest;
use App\Http\Requests\UpdatetransactionRequest;
use App\UploadTrait;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    use UploadTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $transactions = transaction::where('kode_transaksi', 'LIKE', "%$request->search%")
            ->orWhereRaw('CAST(totalAmount AS CHAR) LIKE?', ['%' . $request->search . '%'])
            ->orWhereRaw('CAST(transactionDate AS CHAR) LIKE?', ['%' . $request->search . '%'])
            ->orWhereRelation('customer', 'name', 'LIKE', "%$request->search%")
            ->orWhereRelation('employee', 'name', 'LIKE', "%$request->search%")
            ->orWhereRelation('menu', 'name', 'LIKE', "%$request->search%")
            ->get();
        $customers = customer::all();
        $menus = menu::all();
        $employees = employee::all();
        return view('layouts.transaction.index', compact('transactions', 'customers', 'menus', 'employees'));
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

        $kode = "001";
        $kode_transaksi = "TR" . $kode;
        $transaction = Transaction::query()->latest()->first();
        if ($transaction != null) {
            $old_kode = $transaction->kode_transaksi;
            $nomor = substr($old_kode, 2);
            $old_nomor = intval($nomor) + 1;
            $kode_transaksi = "TR" . sprintf("%03d", $old_nomor);
        }
        // Buat transaksi baru
        Transaction::create([
            'kode_transaksi' => $kode_transaksi,
            'customer_id' => $request->customer_id,
            'menu_id' => $request->menu_id,
            'totalAmount' => $request->totalAmount,
            'priceTotal' => $menu->price * $request->totalAmount,
            'transactionDate' => $request->transactionDate,
            'employee_id' => $request->employee_id
        ]);

        return redirect()->back()->with('add', 'Data telah berhasil ditambahkan');
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
        $menu = Menu::findOrFail($request->menu_id);
        $transaction->update([
            'customer_id' => $request->customer_id,
            'menu_id' => $request->menu_id,
            'totalAmount' =>  $request->totalAmount,
            'priceTotal' => $menu->price * $request->totalAmount,
            'transactionDate' => $request->transactionDate,
            'employee_id' => $request->employee_id,
        ]);
        return redirect()->back()->with('edit', 'Data berhasil di update');
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
