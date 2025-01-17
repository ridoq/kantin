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
    <h3>Tabel Menu</h3>
    <!-- Button trigger modal -->

    <div class="d-flex justify-content-between mb-5">
        <form action="" method="GET" class="d-flex w-50">
            @csrf
            <input type="text" name="search" class="form-control" value="{{ request()->input('search') }}">
            <button type="submit" class="btn btn-secondary ms-2">Cari</button>
            <a href="{{ route('menu') }}" class="btn btn-primary ms-3">Refresh</a>
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
                <form action="/create/menu" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <label class="form-label">Menu</label>
                            <input type="text" name="name" placeholder="Menu" class="form-control"
                                value="{{ old('menu') }}">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Harga Menu</label>
                            <input type="number" name="price" placeholder="Harga" class="form-control"
                                value="{{ old('price') }}">
                        </div>
                        <div class="col-lg-6 mb-3">
                            <label class="form-label">Stock Menu</label>
                            <input type="number" name="stock" placeholder="Stock" class="form-control"
                                value="{{ old('stock') }}">
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label class="form-label">Kategori Menu</label>
                            <select name="category_id" class="form-select" required>
                                @forelse ($categories as $category)
                                    <option value="{{ $category->id }}"> {{ $category->name }}</option>

                                @empty
                                    <option hidden>Tidak ada data</option>
                                @endforelse ()
                            </select>
                        </div>
                        <div class="col-lg-12 mb-3">
                            <label class="form-label">Gambar</label>
                            <input type="file" name="gambar" placeholder="gambar" class="form-control">
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
                <td>Gambar</td>
                <td>Menu</td>
                <td>Harga</td>
                <td>Stock {{ '(item)' }}</td>
                <td>Kategori Menu</td>
                <td>aksi</td>
            </tr>
        </thead>
        <tbody>
            @forelse ($menus as $index => $menu)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        @if ($menu->gambar)
                            <div class="img"
                                style="box-shadow:0px 0px 10px rgba(0,0,0,.2);background-size: cover;background-position:center;width: 200px;height:150px;background-image:url({{ asset('storage/' . $menu->gambar) }});">
                            </div>
                        @else
                            <img src="{{ asset('assets/img/image_not_avaible.png') }}" alt="image_not_avaible"
                                style="background-size: cover;background-position:center;width: 200px;height:150px;">
                        @endif
                    <td>{{ $menu->name }}</td>
                    <td>Rp. {{ number_format($menu->price, 0, ',', '.') }}</td>
                    <td class="text-primary fw-bold">{{ number_format($menu->stock,0,',','.') }}</td>
                    <td>{{ $menu->category->name }}</td>
                    <td>
                        <div class="d-flex gap-2 align-items-center">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal-{{ $menu->id }}">
                                    Edit
                                </button>
                            </div>
                            <div class="d-flex justify-content-end">
                                {{-- button trigger modal edit --}}
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#hapus-{{ $menu->id }}">
                                    Hapus
                                </button>
                                {{-- end button trigger modal edit --}}
                            </div>
                        </div>
                    </td>
                </tr>
                <div class="modal fade" id="exampleModal-{{ $menu->id }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">edit Data</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('edit.menu', [$menu->id]) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-lg-12 mb-3">
                                            <label class="form-label">Menu</label>
                                            <input type="text" name="name" placeholder="Menu" class="form-control"
                                                value="{{ $menu->name }}">
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="form-label">harga</label>
                                            <input type="number" name="price" placeholder="harga"
                                                class="form-control" value="{{ $menu->price }}">
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="form-label">Kategori Menu</label>
                                            <select name="category_id" class="form-select">
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $menu->category_id == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-12 mb-3">
                                            <label for="gambar" class="form-label">Gambar</label>
                                            <input type="file" name="gambar" id="gambar" class="form-control">
                                            @if ($menu->gambar)
                                            <img src="{{ asset('storage/' . $menu->gambar) }}" alt=""
                                            style="max-width: 200px;margin-top:10px;">
                                            @endif
                                        </div>
                                        <div class="col-lg-12 mb-3">
                                            <label class="form-label">Stock</label>
                                            <input type="number" name="stock" placeholder="Stock"
                                                class="form-control" value="{{ $menu->stock }}">
                                        </div>

                                        <div class="col-lg-12 mb-3 d-flex justify-content-end align-items-center">
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>

                {{-- modal hapus --}}
                <div class="modal fade" id="hapus-{{ $menu->id }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Apakah anda yakin?</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            {{-- ubahable --}}
                            <div class="modal-body">
                                <p>Apakah anda yakin ingin menghapus data ini?</p>
                            </div>
                            <div class="modal-footer">
                                <form action="delete/menu/{{ $menu->id }}" method="post" class="p-0 m-0">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" data-bs-dismiss="modal" aria-label="Close"
                                        class="btn btn-secondary">Batal</button>
                                    <button type="submit" class="btn btn-danger">Hapus</button>
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
