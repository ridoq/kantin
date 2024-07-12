@extends('dashboard')
@section('content')
    @if (session('hapus'))
        <div class="alert alert-dismissible alert-danger fade show">
            {{ session('hapus') }}
            <button class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('add'))
        <div class="alert alert-dismissible alert-success fade show">
            {{ session('add') }}
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
    @if (session('edit'))
        <div class="alert alert-dismissible alert-success fade show">
            {{ session('edit') }}
            <button class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('unique'))
        <div class="alert alert-dismissible alert-danger fade show">
            {{ session('unique') }}
            <button class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('restrict'))
        <div class="alert alert-dismissible alert-danger fade show">
            {{ session('restrict') }}
            <button class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
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
    <h3>Tabel Kategori</h3>
    {{-- end judul --}}

    {{-- CREATE DATA - modal --}}

    {{-- button trigger modal --}}
    <div class="d-flex justify-content-between">
        <form action="" method="GET" class="d-flex w-50">
            @csrf
            <input type="text" name="search" class="form-control" value="{{ request()->input('search') }}">
            <button type="submit" class="btn btn-secondary ms-2">Cari</button>
            <a href="{{ route('category') }}" class="btn btn-primary ms-3">Refresh</a>
        </form>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createCategory">
            Tambah Data
        </button>
    </div>
    {{-- end button create trigger modals --}}

    <!-- Modal CREATE DATA-->
    <div class="modal fade" id="createCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                {{-- ubahable --}}
                <div class="modal-body">
                    <form action="/create/category" method="post">
                        @csrf
                        @method('POST')
                        <div class="row">
                            {{-- col++ --}}
                            <div class="col-12 mb-3">
                                <label for="" class="form-label">Nama Kategori</label>
                                <input type="text" value="{{old('name')}}" name="name" placeholder="category" class="form-control">
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
                <td style="font-weight: bold">No</td>
                <td style="font-weight: bold">category</td>
                <td style="font-weight: bold">Aksi</td>
            </tr>
        </thead>
        {{-- ubahable --}}
        <tbody>
            @forelse ($categories as $index => $category)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $category->name }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <div class="d-flex justify-content-end">
                                {{-- button trigger modal edit --}}
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal-{{ $category->id }}">
                                    Edit
                                </button>
                                {{-- end button trigger modal edit --}}
                            </div>
                            {{-- button delete --}}
                            <div class="d-flex justify-content-end">
                                {{-- button trigger modal edit --}}
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#hapus-{{ $category->id }}">
                                    Hapus
                                </button>
                                {{-- end button trigger modal edit --}}
                            </div>

                            {{-- button delete --}}
                        </div>
                    </td>
                    {{-- modal edit --}}
                    <div class="modal fade" id="exampleModal-{{ $category->id }}" tabindex="-1"
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
                                    <form action="{{ route('edit.category', [$category->id]) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class=" col-lg-12 mb-3">
                                                <label class="form-label">Nama Kategori</label>
                                                <input type="text" name="name" placeholder="Category"
                                                    class="form-control" value="{{ $category->name }}">
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
                    <div class="modal fade" id="hapus-{{ $category->id }}" tabindex="-1"
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
                                    <form action="delete/category/{{ $category->id }}" method="post" >
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" data-bs-dismiss="modal"
                                        aria-label="Close" class="btn btn-secondary">Batal</button>
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
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
