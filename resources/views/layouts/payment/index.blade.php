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
    <h3>Tabel Pembayaran</h3>
    <!-- Button trigger modal -->

    <div class="d-flex justify-content-between mb-5">
        <form action="" method="GET" class="d-flex w-50 ">
            @csrf
            <input type="text" name="search" placeholder="cari data" class="form-control" value="{{ request()->input('search') }}">
            <button type="submit" class="btn btn-secondary ms-2">Cari</button>
            <a href="{{ route('payment') }}" class="btn btn-primary ms-3">Refresh</a>
        </form>
    </div>


    <table class="table mt-3">
        <thead>
            <tr>
                <td>No</td>
                <td>Kode Transaksi</td>
                <td>Transaksi</td>
                <td>Nama Pegawai</td>
                <td>Metode pembayaran</td>
                <td>Total Bayar</td>
                <td>Kembalian</td>
                <td>Status</td>
                <td>Aksi</td>
            </tr>
        </thead>
        <tbody>
            @if (App\Models\Payment::exists() || App\Models\Transaction::exists())
                @php
                    $unpaid = $transactions->where('status', 'Unpaid');
                @endphp
                @foreach ($unpaid as $transaction)
                    <tr>
                        <td class="text-warning">{{ $loop->index + 1 }}</td>
                        <td> {{ $transaction->kode_transaksi }} </td>
                        <td>
                            Nama : <span class="fw-bold">{{ $transaction->customer->name }} </span><br>
                            Menu : <span class="fw-bold">{{ $transaction->menu->name }}</span> <br>
                            Jumlah beli : <span class="fw-bold">{{number_format( $transaction->totalAmount ,0,',','.')}} </span><br>
                            Total harga : <span class="fw-bold text-primary">Rp.
                                {{ number_format($transaction->priceTotal, 0, ',', '.') }}</span>
                        </td>
                        <td> {{ $transaction->employee->name }} </td>
                        <td> - </td>
                        <td> - </td>
                        <td> - </td>
                        <td> <span class="text-warning">{{ $transaction->status }} </span></td>
                        <td>
                            <div class="d-flex gap-2 align-items-center">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal-{{ $transaction->id }}">
                                        Bayar
                                    </button>
                                </div>
                            </div>
                        </td>
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
                                        <form action="{{ route('create.payment') }}" method="post">
                                            @csrf
                                            @method('POST')
                                            <div class="row">
                                                <div class="col-12 mb-3">
                                                    <input type="hidden" value="{{ $transaction->id }}"
                                                        name="transaction_id">
                                                    <label for="" class="form-label">Informasi Transaksi</label>
                                                    <p> - Kode transaksi : <b>{{ $transaction->kode_transaksi }}</b></p>
                                                    <p> - Nama : <b>{{ $transaction->customer->name }}</b></p>
                                                    <p> - Menu : <b>{{ $transaction->menu->name }}</b></p>
                                                    <p> - Jumlah beli : <b>{{ $transaction->totalAmount }}</b></p>
                                                    <p> - Total harga : <b><span class="text-primary"> Rp.
                                                                {{ number_format($transaction->priceTotal, 0, ',', '.') }}</span></b>
                                                    </p>
                                                </div>
                                                <div class="col-lg-12 mb-3">
                                                    <label class="form-label">Metode pembayaran</label>
                                                    <select name="paymentMethod_id" class="form-select">
                                                        @forelse ($paymentMethods as $paymentMethod)
                                                            <option value="{{ $paymentMethod->id }}">
                                                                {{ $paymentMethod->method }}</option>
                                                        @empty
                                                            <option hidden>Tidak ada Data</option>
                                                        @endforelse
                                                    </select>
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label for="" class="form-label">Total bayar</label>
                                                    <input type="number" value="{{ old('totalPayment') }}"
                                                        placeholder="Total Bayar" name="totalPayment" class="form-control">
                                                </div>
                                                <div class="col-lg-12 mb-3 d-flex justify-content-end align-items-center">
                                                    <button type="submit" class="btn btn-primary">Bayar</button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                @endforeach
                @foreach ($payments as $payment)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>{{ $payment->transaction->kode_transaksi }}</td>
                        <td>
                            Nama : <span class="fw-bold">{{ $payment->transaction->customer->name }} </span><br>
                            Menu : <span class="fw-bold">{{ $payment->transaction->menu->name }}</span> <br>
                            Jumlah beli : <span class="fw-bold">{{ $payment->transaction->totalAmount }} </span><br>
                            Total harga : <span class="fw-bold text-primary">
                                Rp. {{ number_format($payment->transaction->priceTotal, 0, ',', '.') }}</span>
                        </td>
                        <td>{{ $payment->transaction->employee->name }}</td>
                        <td>{{ $payment->paymentMethod->method }}</td>
                        <td>Rp. {{ number_format($payment->totalPayment, 0, ',', '.') }}</td>
                        <td>Rp. {{ number_format($payment->change, 0, ',', '.') }}</td>
                        <td class="text-primary">{{ $payment->transaction->status }}</td>
                        @if ($payment->transaction->status == 'Paid')
                            <td>
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-success" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal-{{ $payment->id }}">
                                            Selesaikan
                                        </button>
                                    </div>
                                </div>
                            </td>
                        @elseif($payment->transaction->status == 'Complete')
                            <td>
                                <div class="d-flex gap-2 align-items-center">
                                    <div class="d-flex justify-content-end">
                                        <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal2-{{ $payment->id }}">
                                            <i class="mdi mdi-trash-can"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                        @endif
                    </tr>
                    <div class="modal fade" id="exampleModal-{{ $payment->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('edit.payment', [$payment->id]) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <p><span class="fw-bold fs-3"> Apakah anda yakin menyelesaikan transaksi ini?
                                                </span><br><br>
                                                Pastikan pesanan telah sampai ke pelanggan dan pembayarannya telah selesai.
                                            </p>
                                            <div class="col-lg-12 mb-3 mt-5 d-flex justify-content-end align-items-center">
                                                <button type="button" class="btn btn-secondary me-3"
                                                    data-bs-dismiss="modal"aria-label="Close">Batal</button>
                                                <button type="submit" class="btn btn-success">Selesai</button>
                                            </div>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="exampleModal2-{{ $payment->id }}" tabindex="-1"
                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel"></h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="delete/payment/{{ $payment->id }}" method="post" class="p-0 m-0">
                                        @csrf
                                        @method('DELETE')
                                        <div class="row">
                                            <p><span class="fw-bold fs-3"> Apakah anda yakin menghapus data transaksi ini?
                                                </span><br><br>
                                                Data ini sementara akan masuk ke dalam menu<span
                                                    class="text-primary">History</span>
                                            </p>
                                            <div class="col-lg-12 mb-3 mt-5 d-flex justify-content-end align-items-center">
                                                <button type="button" class="btn btn-secondary me-3"
                                                    data-bs-dismiss="modal"aria-label="Close">Batal</button>
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <tr>
                    <td colspan="15">
                        <div class="d-flex justify-content-center">Data Kosong</div>
                    </td>
                </tr>
            @endif

            {{-- @forelse ($payments as $index => $payment)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        @if ($paymentUnpaid)
                            <td>{{ $payment->kode_transaksi }}</td>
                        @else
                            <td>{{ $payment->kode_transaksi }}</td>
                        @endif
                        <td>{{ $payment->totalAmount }}</td>
                        @if ($payment->priceTotal)
                            <td>Rp. {{ $payment->priceTotal }}</td>
                        @else
                            <td>Rp. {{ $payment->priceTotal }}</td>
                        @endif
                        <td>{{ date('l, d F Y', strtotime($payment->transactionDate)) }}</td>
                        <td>
                            <div class="d-flex gap-2 align-items-center">
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#exampleModal-{{ $transaction->id }}">
                                        Bayar
                                    </button>
                                </div>
                            </div>
                        </td>
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
                                    <form action="{{ route('create.payment', [$transaction->id]) }}" method="post">
                                        @csrf
                                        @method('POST')
                                        <div class="row">
                                            <div class="col-6 mb-3">
                                                <label for="" class="form-label">Jumlah Beli</label>
                                                <input type="text" value="{{ $transaction->totalAmount }}"
                                                    placeholder="Jumlah Bayar" class="form-control" disabled>
                                            </div>
                                            <div class="col-6 mb-3">
                                                <label for="" class="form-label">Total Harga</label>
                                                <input type="text" value="Rp. {{ $transaction->priceTotal }}"
                                                    placeholder="Jumlah Bayar" class="form-control" disabled>
                                            </div>
                                            <div class="col-12 mb-3">
                                                <input type="hidden" value="{{ $transaction->id }}"
                                                    name="transaction_id">
                                                <label for="" class="form-label">Jumlah Bayar</label>
                                                <input type="number" value="{{ old('transaction') }}"
                                                    name="transaction" placeholder="Jumlah Bayar" class="form-control">
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
                @endforelse --}}
        </tbody>
    </table>
@endsection
