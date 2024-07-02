<?php

namespace App\Http\Controllers;

use App\Models\category;
use App\Http\Requests\StorecategoryRequest;
use App\Http\Requests\UpdatecategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = category::where('name', 'like', "%$request->search%")->get();
        return view('layouts.category.index',compact('categories'));
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
    public function store(StorecategoryRequest $request)
    {
        category::create([
            'name' => $request->name
        ]);
        return redirect()->back()->with('add','data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatecategoryRequest $request, category $category)
    {
        try {
            $category->update([
                'name' => $request->name,
            ]);
            return redirect()->route('category')->with('edit', 'Data category berhasil diperbarui.');
        } catch (\Throwable $th) {
            return redirect()->route('category')->with('unique', 'Data telah ada sebelumnya');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(category $category)
    {
        try{
            $category->delete();
            return redirect()->back()->with('hapus','Data berhasil dihapus');
        }catch(\Exception $e){
            return redirect()->back()->with('restrict','Data tidak dapat dihapus karena masih terpakai di tabel yang lain.');
        }
    }
}
