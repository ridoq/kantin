@extends('dashboard')
@section('content')
    <div class="row g-0">
        <div class="col-md-6">
            <div class="card mb-3" >
                <div class="card-body d-flex justify-content-between align-items-start">
                    <img src="{{ asset('assets/img/43322.jpg') }}" class="img-fluid rounded-start" style="width: 40%">
                    <div class="text ms-3 mt-2">
                        <h3 class="card-title">
                            Welcome, Chief
                            @auth
                                <b class="text-primary">{{ Auth::user()->name }}</b>
                            @endauth
                        </h3>
                        <p class="card-text">Kami senang melihat Anda kembali! Dashboard ini dirancang
                            untuk memberikan Anda semua informasi dan alat yang Anda butuhkan untuk
                            mengelola tugas dan proyek Anda dengan efisien. Kami berharap Anda memiliki
                            hari yang produktif dan menyenangkan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
