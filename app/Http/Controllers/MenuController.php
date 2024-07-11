<?php

namespace App\Http\Controllers;

use App\Models\menu;
use App\UploadTrait;
use App\Models\category;
use Illuminate\Http\Request;
use App\Http\Requests\StoremenuRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdatemenuRequest;

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
            'stock' => $request->stock,
            'gambar' => $gambar
        ]);
        return redirect()->back()->with('add', 'Data berhasil ditambahkan');
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
    if ($request->hasFile('gambar')) {
        // Hapus file gambar lama jika ada
        $path = $menu->gambar;
        if ($path && Storage::exists($path)) {
            Storage::delete($path);
        }

        // Upload file gambar baru
        $gambar = $this->upload('gambar', $request->gambar);
    } else {
        $gambar = $menu->gambar;
    }

    // Update data menu
    $menu->update([
        'name' => $request->name,
        'price' => $request->price,
        'category_id' => $request->category_id,
        'stock' => $request->stock,
        'gambar' => $gambar
    ]);

    return redirect()->route('menu')->with('edit', 'Data berhasil diperbarui');
}


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(menu $menu)
    {
        try {
            if($menu->gambar != null){
                $menu->delete();
                $path = $menu->gambar;
                if (Storage::exists($path)) {
                    Storage::delete($path);
                }
                return redirect()->back()->with('add', 'Data berhasil dihapus');
            }else{
                $menu->delete();
                return redirect()->back()->with('add', 'Data berhasil dihapus');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('restrict', 'Data tidak dapat dihapus karena masih terpakai di tabel yang lain.');
        }
    }
}
