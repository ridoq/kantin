@extends('dashboard')
@section('content')
{{-- rule:
1. cek button trigger modal create dan div modal create data, ubah modal body
2. cek tbody, ubah database sesuai judul file.
3. tbody-> variable ygv menampung modelnya menjadi objek. contoh "$categories as $category"
4. cek button trigger modal edit, samakan data-bs-target nya, ubah variable nya sesuai judul file
5. cek modal edit, tbodynya
6. cek button delete nya,[form action:routenya]
--}}
    {{-- judul --}}
    <h3>Tabel Employee</h3>
    {{-- end judul --}}

    {{-- CREATE DATA - modal --}}

        {{-- button trigger modal --}}
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createEmplyoee">
                Tambah Data
            </button>
        </div>
        {{-- end button create trigger modals --}}

        <!-- Modal CREATE DATA-->
        <div class="modal fade" id="createEmplyoee" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    {{-- ubahable --}}
                    <div class="modal-body">
                        <form action="/create/employee" method="post">
                            @csrf
                            @method('POST')
                            <div class="row">
                                {{-- col++ --}}
                                <div class="col-12 mb-3">
                                    <label for="" class="form-label">Nama Employoee</label>
                                    <input type="text" name="name" placeholder="Employoee" class="form-control">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="" class="form-label">Nomor Telepon</label>
                                    <input type="number" name="tel" placeholder="Nomor Telepon" class="form-control">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="" class="form-label">Email</label>
                                    <input type="email" name="email" placeholder="Email" class="form-control">
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
                <td>Nama Employee</td>
                <td>Nomor Telepon</td>
                <td>Email</td>
                <td>Alamat</td>
                <td>Aksi</td>
            </tr>
        </thead>
        {{-- ubahable --}}
        <tbody>
            @forelse ($employees as $index => $employee)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->tel }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->address }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <div class="d-flex justify-content-end">
                                {{-- button trigger modal edit --}}
                                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal-{{ $employee->id }}">
                                    Edit
                                </button>
                                {{-- end button trigger modal edit --}}
                            </div>
                            {{-- button delete --}}
                            <form action="delete/employee/{{ $employee->id }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                            {{-- button delete --}}
                        </div>
                    </td>
                    {{-- modal edit --}}
                    <div class="modal fade" id="exampleModal-{{ $employee->id }}" tabindex="-1"
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
                                    <form action="{{ route('edit.employee', [$employee->id]) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <div class=" col-lg-12 mb-3">
                                                <label class="form-label">Nama Emplyee</label>
                                                <input type="text" name="name " placeholder="Emplyoee"
                                                    class="form-control" value="{{ $employee->name }}">
                                            </div>
                                            <div class=" col-lg-12 mb-3">
                                                <label class="form-label">Telepon</label>
                                                <input type="number" name="tel" placeholder="telepon"
                                                    class="form-control" value="{{ $employee->tel }}">
                                            </div>
                                            <div class=" col-lg-12 mb-3">
                                                <label class="form-label">Email</label>
                                                <input type="email" name="email " placeholder="Email"
                                                    class="form-control" value="{{ $employee->email }}">
                                            </div>
                                            <div class=" col-lg-12 mb-3">
                                                <label class="form-label">Alamat</label>
                                                <input type="text" name="address " placeholder="Alamat"
                                                    class="form-control" value="{{ $employee->address }}">
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