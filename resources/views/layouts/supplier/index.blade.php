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
    {{-- rule:
1. cek button trigger modal create dan div modal create data, ubah modal body
2. cek tbody, ubah database sesuai judul file.
3. tbody-> variable ygv menampung modelnya menjadi objek. contoh "$categories as $category"
4. cek button trigger modal edit, samakan data-bs-target nya, ubah variable nya sesuai judul file
5. cek modal edit, tbodynya
6. cek button delete nya,[form action:routenya]
--}}
    {{-- judul --}}
    <h3>Tabel Pemasok</h3>
    {{-- end judul --}}

    {{-- CREATE DATA - modal --}}

    {{-- button trigger modal --}}
    <div class="d-flex justify-content-between mb-5">
        <form action="" method="GET" class="d-flex w-50">
            @csrf
            <input type="text" name="search" class="form-control">
            <button type="submit" class="btn btn-secondary ms-2">Cari</button>
        </form>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createSupplier">
            Tambah Data
        </button>
    </div>
    {{-- end button create trigger modals --}}

    <!-- Modal CREATE DATA-->
    <div class="modal fade" id="createSupplier" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- ubahable --}}
                <div class="modal-body">
                    <form action="/create/supplier" method="post">
                        @csrf
                        @method('POST')
                        <div class="row">
                            {{-- col++ --}}
                            <div class="col-6 mb-3">
                                <label for="" class="form-label">Nama Supplier</label>
                                <input type="text" name="name" placeholder="Supplier" class="form-control">
                            </div>
                            <div class="col-6 mb-3">
                                <label for="" class="form-label">Nomor Telepon</label>
                                <input type="number" name="tel" placeholder="Nomor Telepon" class="form-control">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="" class="form-label">Alamat</label>
                                <input type="text" name="address" placeholder="Alamat" class="form-control">
                            </div>
                            <div class="col-12 mb-3 d-flex justify-content-end align-items-center">
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- end modal create data --}}



    {{-- READ / TABLE VIEW --}}
    <table class="table">
        <thead>
            <tr>
                <td>No</td>
                <td>Nama Supplier</td>
                <td>Nomor Telepon</td>
                <td>Alamat</td>
                <td>Aksi</td>
            </tr>
        </thead>
        {{-- ubahable --}}
        <tbody>
            @forelse ($suppliers as $index => $supplier)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $supplier->name }}</td>
                    <td>{{ $supplier->tel }}</td>
                    <td>{{ $supplier->address }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <div class="d-flex justify-content-end">
                                {{-- button trigger modal edit --}}
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal-{{ $supplier->id }}">
                                    Edit
                                </button>
                                {{-- end button trigger modal edit --}}
                            </div>
                            {{-- button delete --}}
                            <form action="delete/supplier/{{ $supplier->id }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                            {{-- button delete --}}
                        </div>
                    </td>
                    {{-- modal edit --}}
                    <div class="modal fade" id="exampleModal-{{ $supplier->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">edit Data</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                {{-- ubahable --}}
                                <div class="modal-body">
                                    <form action="{{ route('edit.supplier', [$supplier->id]) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class=" col-lg-6 mb-3">
                                                <label class="form-label">Nama Supplier</label>
                                                <input type="text" name="name" placeholder="supplier"
                                                    class="form-control" value="{{ $supplier->name }}">
                                            </div>
                                            <div class=" col-lg-6 mb-3">
                                                <label class="form-label">Telepon</label>
                                                <input type="number" name="tel" placeholder="telepon"
                                                    class="form-control" value="{{ $supplier->tel }}">
                                            </div>
                                            <div class=" col-lg-12 mb-3">
                                                <label class="form-label">Alamat</label>
                                                <input type="text" name="address" placeholder="Alamat"
                                                    class="form-control" value="{{ $supplier->address }}">
                                            </div>
                                            <div class="col-lg-12 d-flex justify-content-end align-items-center">
                                                <button type="submit" class="btn btn-primary w-25">Update</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- end modal edit --}}
                @empty
                    {{-- fungsinya: tampilan jika data kosong --}}
                <tr>
                    <td colspan="15">
                        <div class="d-flex justify-content-center">Data Kosong</div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
