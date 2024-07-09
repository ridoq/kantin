@extends('dashboard')
@section('content')
    @if (session('hapus'))
        <div class="alert alert-dismissible alert-danger fade show">
            {{ session('hapus') }}
            <button class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('restrict'))
        <div class="alert alert-dismissible alert-danger fade show">
            {{ session('restrict') }}
            <button class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('add'))
        <div class="alert alert-dismissible alert-success fade show">
            {{ session('add') }}
            <button class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('edit'))
        <div class="alert alert-dismissible alert-success fade show">
            {{ session('edit') }}
            <button class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <div class="alert alert-dismissible alert-danger fade show">
                {{ $error }}
                <button class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endforeach
    @endif
    <h3>Tabel Stok Menu</h3>
    <!-- Button trigger modal -->

    <div class="d-flex justify-content-between">
        <form action="" method="get" class="d-flex w-50">
            @csrf
            <input type="text" name="search" class="form-control">
            <button type="submit" class="btn btn-secondary ms-2">Cari</button>
        </form>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Tambah Data
        </button>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- editable --}}
                <div class="modal-body">
                    <form action="/create/stock" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-lg-12 mb-3">
                                <label class="form-label">Menu</label>
                                <select name="menu_id" class="form-select">
                                    @forelse ($menus as $menu)
                                        <option value="{{ $menu->id }}"> {{ $menu->name }}</option>
                                    @empty
                                        <option hidden>Tidak ada Data</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Stok</label>
                                <input type="number" name="stock" placeholder="stok" class="form-control"
                                    value="{{ old('stock') }}">
                            </div>
                            <div class="col-lg-12 mb-3 d-flex justify-content-end align-items-center">
                                <button type="submit" class="btn btn-secondary">Tambah</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <table class="table">
        <thead>
            <tr>
                <td>No</td>
                <td>Menu</td>
                <td>Menu Gambar</td>
                <td>Stok Awal</td>
                <td>Stok terjual</td>
                <td>Stok Saat Ini</td>
                <td>Aksi</td>
            </tr>
        </thead>
        <tbody>
            @forelse ($stockMenus as $index => $stockMenu)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $stockMenu->menu->name }}</td>
                    <td>
                        @if ($stockMenu->menu->gambar)
                            <div class="img"
                                style="box-shadow:0px 0px 10px rgba(0,0,0,.2);background-size: cover;background-position:center;width: 200px;height:150px;background-image:url({{ asset('storage/' . $stockMenu->menu->gambar) }});">
                            </div>
                        @else
                            <img src="{{ asset('assets/img/image_not_avaible.png') }}" alt="image_not_avaible"
                                style="background-size: cover;background-position:center;width: 200px;height:150px;">
                        @endif
                    </td>
                    <td>{{ $stockMenu->stock }}</td>
                    <td>
                        <div class="d-flex gap-2 align-items-center">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal-{{ $stockMenu->id }}">
                                    Edit
                                </button>
                            </div>
                            <form action="delete/stock/{{ $stockMenu->id }}" method="post" class="p-0 m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <div class="modal fade" id="exampleModal-{{ $stockMenu->id }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">edit Data</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('edit.stock', [$stockMenu->id]) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-lg-12 mb-3">
                                            <label class="form-label">Nama Menu</label>
                                            <select name="menu_id" class="form-select">
                                                @foreach ($menus as $menu)
                                                    <option value="{{ $menu->id }}"
                                                        {{ $stockMenu->menu_id == $menu->id ? 'selected' : '' }}>
                                                        {{ $menu->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="form-label">Stok</label>
                                            <input type="number" name="stock" placeholder="stok" class="form-control"
                                                value="{{ $stockMenu->stock }}">
                                        </div>
                                        <div class="col-lg-12 mb-3 d-flex justify-content-end align-items-center">
                                            <div class="col-lg-12 mb-3 d-flex justify-content-end align-items-center">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <tr>
                    <td colspan="15">
                        <div class="d-flex justify-content-center">Data Kosong</div>
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>
@endsection
