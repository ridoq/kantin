@extends('dashboard')
@section('content')
@if (@session('status'))
<div class="alert alert-dismissible alert-danger fade show">
    {{ session('hapus')}}
    <button class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
    <h3>Tabel Ingredient</h3>
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
                    <form action="/create/ingredient" method="post">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="name" placeholder="Nama" class="form-control"
                                    value="{{ old('name') }}">
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Stock</label>
                                <input type="number" name="stock" placeholder="Stock" class="form-control"
                                    value="{{ old('stock') }}">
                            </div>
                            <div class="col-lg-12 mb-3">
                                <label class="form-label">Supplier</label>
                                <select name="supplier_id" class="form-select">
                                    @forelse ($suppliers as $supplier)
                                        <option value="{{ $supplier->id }}"> {{ $supplier->name }}</option>
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
                <td>Nama</td>
                <td>Stock</td>
                <td>Supplier</td>
            </tr>
        </thead>
        <tbody>
            @forelse ($ingredients as $index => $ingredient)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $ingredient->name }}</td>
                    <td>{{ $ingredient->stock }}</td>
                    <td>{{ $ingredient->supplier->name }}</td>
                    <td>
                        <div class="d-flex gap-2 align-items-center">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal-{{ $ingredient->id }}">
                                    Edit
                                </button>
                            </div>
                            <form action="delete/ingredient/{{ $ingredient->id }}" method="post" class="p-0 m-0">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <div class="modal fade" id="exampleModal-{{ $ingredient->id }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">edit Data</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('edit.ingredient', [$ingredient->id]) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-lg-6 mb-3">
                                            <label class="form-label">Nama</label>
                                            <input type="text" name="name" placeholder="Nama" class="form-control"
                                                value="{{ $ingredient->name }}">
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="form-label">Stock</label>
                                            <input type="number" name="stock" placeholder="harga" class="form-control"
                                                value="{{ $ingredient->stock }}">
                                        </div>
                                        <div class="col-lg-12 mb-3">
                                            <label class="form-label">Nama Supllier</label>
                                            <select name="supplier_id" class="form-select">
                                                @foreach ($suppliers as $supplier)
                                                    <option value="{{ $supplier->id }}"
                                                        {{ $supplier->supplier_id == $supplier->id ? 'selected' : '' }}>
                                                        {{ $supplier->name }}
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
