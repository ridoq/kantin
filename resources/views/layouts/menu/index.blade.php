@extends('dashboard')
@section('content')
    <h3>Tabel menu</h3>
    <!-- Button trigger modal -->

    <div class="d-flex justify-content-between">
        {{-- <form action="{{ route('menus.cari') }}" method="GET" class="d-flex w-50">
            @csrf
            <input type="text" name="keyword" class="form-control">
            <button type="submit" class="btn btn-secondary ms-2">Cari</button>
        </form> --}}
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
                    <form action="/create/menu" method="post">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Menu</label>
                                <input type="text" name="menu" placeholder="Menu" class="form-control"
                                value="{{ old('menu') }}">
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Harga Menu</label>
                                <input type="number" name="price" placeholder="Harga" class="form-control"
                                value="{{ old('price') }}">
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label class="form-label">Kategori Menu</label>
                                <select name="category_id" class="form-select">
                                    @forelse ($categories as $category)
                                        <option value="{{ $category->id }}"> {{ $category->name }}</option>
                                    @empty
                                    <option hidden>Tidak ada Data</option>
                                    @endforelse
                                </select>
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
                <td>Harga</td>
                <td>Kategori Menu</td>
            </tr>
        </thead>
        <tbody>
            @forelse ($menus as $index => $menu)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $menu->menu }}</td>
                    <td>{{ $menu->price }}</td>
                    <td>{{ $menu->category->name }}</td>
                    <td>
                        <div class="d-flex gap-2 align-items-center">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal-{{ $menu->id }}">
                                    Edit
                                </button>
                            </div>
                            <form action="delete/menu/{{ $menu->id }}" method="post" class="p-0 m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
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
                                <form action="{{ route('edit.menu', [$menu->id]) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-lg-6 mb-3">
                                            <label class="form-label">Menu</label>
                                            <input type="text" name="menu" placeholder="Menu" class="form-control"
                                                value="{{ $menu->menu }}">
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="form-label">harga</label>
                                            <input type="number" name="harga" placeholder="harga" class="form-control"
                                                value="{{ $menu->price }}">
                                        </div>
                                        <div class="col-lg-12 mb-3">
                                            <label class="form-label">Kategori Menu</label>
                                            <select name="category_id" class="form-select">
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" {{ $menu->category_id == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
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
