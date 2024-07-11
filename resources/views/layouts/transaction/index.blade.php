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
    <h3>Tabel Transaksi</h3>
    <!-- Button trigger modal -->

    <div class="d-flex justify-content-between mb-5">
        <form action="" method="GET" class="d-flex w-50 ">
            @csrf
            <input type="text" name="search" placeholder="cari data" class="form-control">
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
                    <form action="/create/transaction" method="post">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Nama Pelanggan</label>
                                <select name="customer_id" class="form-select" required>
                                    @forelse ($customers as $customer)
                                        <option value="{{ $customer->id }}"> {{ $customer->name }}</option>
                                    @empty
                                        <option hidden>Tidak ada data</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Nama Pegawai</label>
                                <select name="employee_id" class="form-select" required>
                                    @forelse ($employees as $employee)
                                        <option value="{{ $employee->id }}"> {{ $employee->name }}</option>
                                    @empty
                                        <option hidden>Tidak ada data</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-lg-6 mb-3">
                                <label class="form-label">Menu</label>
                                <select name="menu_id" class="form-select">
                                    @forelse ($menus as $menu)
                                        <option value="{{ $menu->id }}">{{ $menu->name . " (stok : " . $menu->stock .')'}}</option>
                                    @empty
                                        <option hidden>Tidak ada Data</option>
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-6 mb-3">
                                <label for="" class="form-label">Jumlah Beli</label>
                                <input type="number" value="{{ old('totalAmount') }}" name="totalAmount"
                                    placeholder="Jumlah Beli" class="form-control">
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
                <td>Kode Transaksi</td>
                <td>Pelanggan</td>
                <td>Nama Menu</td>
                <td>Total Beli</td>
                <td>Total Harga</td>
                <td>Tanggal Transaksi</td>
                <td>Status</td>
                <td>Aksi</td>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions->sortByDesc('kode_transaksi') as $index => $transaction)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $transaction->kode_transaksi }}</td>
                    <td>{{ $transaction->customer->name }}</td>
                    <td>{{ $transaction->menu->name}}</td>
                    <td>{{ $transaction->totalAmount }}</td>
                    <td>Rp. {{ number_format($transaction->priceTotal, 0, ',', '.') }}</td>
                    <td>{{ date('l, d F Y', strtotime($transaction->transactionDate)) }}</td>
                    @if ($transaction->status == 'Unpaid')
                        <td>
                            <a href="{{ route('payment') }}" class="text-decoration-underline text-warning fw-bold">{{ $transaction->status }}</a>
                        </td>
                    @elseif($transaction->status == 'Paid')
                        <td>
                            <a href="{{ route('payment') }}" class="text-decoration-underline text-primary fw-bold">{{ $transaction->status }}</a>
                        </td>
                    @else
                        <td>
                            <a class="text-success fw-bold">{{ $transaction->status }}</a>
                        </td>
                    @endif
                    @if ($transaction->status == 'Unpaid')
                        <td>
                            <div class="d-flex gap-2 align-items-center">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal-{{ $transaction->id }}">
                                        <i class="mdi mdi-pencil"></i>
                                    </button>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal2-{{ $transaction->id }}">
                                        <i class="mdi mdi-trash-can"></i>
                                    </button>
                                </div>
                            </div>
                        </td>
                        @elseif($transaction->status == 'Paid')
                        <td>
                            -
                        </td>
                        @else
                        <td>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                    data-bs-target="#exampleModal2-{{ $transaction->id }}">
                                    <i class="mdi mdi-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    @endif
                </tr>
                <div class="modal fade" id="exampleModal-{{ $transaction->id }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">edit Data</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('edit.transaction', [$transaction->id]) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-lg-6 mb-3">
                                            <label class="form-label">Nama Pelanggan</label>
                                            <select name="customer_id" class="form-select">
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}"
                                                        {{ $transaction->customer_id == $customer->id ? 'selected' : '' }}>
                                                        {{ $customer->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="form-label">Nama Pegawai</label>
                                            <select name="employee_id" class="form-select">
                                                @foreach ($employees as $employee)
                                                    <option value="{{ $employee->id }}"
                                                        {{ $transaction->employee_id == $employee->id ? 'selected' : '' }}>
                                                        {{ $employee->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-lg-6 mb-3">
                                            <label class="form-label">Menu</label>
                                            <input type="hidden" value="{{ $transaction->menu_id }}" name="menu_id">
                                            <input type="text" value="{{ $menu->name . " (stok awal: ". $menu->stock + $transaction->totalAmount .")"}}" disabled class="form-control">
                                        </div>
                                        <div class="col-6 mb-3">
                                            <label for="" class="form-label">Jumlah Beli</label>
                                            <input type="number" value="{{ $transaction->totalAmount }}" name="totalAmount"
                                                placeholder="Jumlah Beli" class="form-control">
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
                <div class="modal fade" id="exampleModal2-{{ $transaction->id }}" tabindex="-1"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Apakah anda yakin?</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Apakah anda yakin akan menghapus data ini?</p>
                                </div>
                                <div class="modal-footer">
                                    <form action="delete/transaction/{{ $transaction->id }}" method="post" class="p-0 m-0">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                            aria-label="Close">Batal</button>
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
