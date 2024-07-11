<?php

namespace App\Http\Controllers;

use App\Models\employee;
use App\Http\Requests\StoreemployeeRequest;
use App\Http\Requests\UpdateemployeeRequest;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $employees = employee::where('name', 'like', "%$request->search%")
        ->orWhereRaw("CAST(tel as VARCHAR) like ?", ["%" . $request->search . "%"])
        ->orWhereRaw("email like ?", ["%" . $request->search . "%"])
        ->orWhereRaw("address like ?", ["%" . $request->search . "%"])
        ->get();
        return view('layouts.employee.index', compact('employees'));
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
    public function store(StoreemployeeRequest $request)
    {
        employee::create([
            'name' => $request->name,
            'tel' => $request->tel,
            'email' => $request->email,
            'address' => $request->address,
        ]);
        return redirect()->back()->with('add', 'Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateemployeeRequest $request, employee $employee)
    {
        try {
            $employee->update([
                'name' => $request->name,
                'tel' => $request->tel,
                'email' => $request->email,
                'address' => $request->address,
            ]);
            return redirect()->back()->with('edit', 'Data employee berhasil diperbarui.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('unique', 'Data telah ada sebelumnya');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(employee $employee)
    {
        try {
            $employee->delete();
            return redirect()->back()->with('add', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('restrict', 'Data tidak dapat dihapus karena masih terpakai di tabel yang lain.');
        }
    }
}
