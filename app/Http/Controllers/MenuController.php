<?php

namespace App\Http\Controllers;

use App\Models\menu;
use App\Models\category;
use App\Http\Requests\StoremenuRequest;
use App\Http\Requests\UpdatemenuRequest;
use App\UploadTrait;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    use UploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $menus = menu::where('name', 'LIKE', "%$request->search%")
            ->orWhereRaw('CAST(price AS CHAR) LIKE?', ['%' . $request->search . '%'])
            ->orWhereRelation('category', 'name', 'LIKE', "%$request->search%")
            ->get();
        $categories = Category::all();

        return view('layouts.menu.index', compact('menus', 'categories'));
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
    public function store(StoremenuRequest $request)
    {
        if ($request->hasFile('gambar')) {
            $gambar = $this->upload('gambar', $request->gambar);
        } else {
            $gambar = null;
        }
        menu::create([
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'gambar' => $gambar
        ]);
        return redirect()->back()->with('add', 'Data telah berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatemenuRequest $request, menu $menu)
    {
        try {
            if ($request->hasFile('gambar')) {
                $gambar = $this->upload('gambar', $request->gambar);
            } else {
                $gambar = $menu->gambar;
            }


            $menu->update([
                'name' => $request->name,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'gambar' => $gambar
            ]);
            return redirect()->route('menu')->with('edit', 'Data berhasil di update');
        } catch (\Exception $e) {
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(menu $menu)
    {
        try {
            $menu->delete();
            return redirect()->back()->with('hapus', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return redirect()->back()->with('restrict', 'Data tidak dapat dihapus karena masih terpakai di tabel yang lain.');
        }
    }
}
