@extends('dashboard')
@section('content')
<div class="card mb-3" style="max-width: 540px;">
    <div class="row g-0">
        <div class="col-md-4">
            <img src="../../assets/img/avatars/profile.svg" class="img-fluid rounded-start"
                alt="...">
        </div>
        <div class="col-md-8">
            <div class="card-body">
                <h4 class="card-title">Welcome, Chef
                    @auth
                        <b class="text-primary">{{ Auth::user()->name }}</b>
                    @endauth
                </h4>
                <p class="card-text">Kami senang melihat Anda kembali! Dashboard ini dirancang
                    untuk memberikan Anda semua informasi dan alat yang Anda butuhkan untuk
                    mengelola tugas dan proyek Anda dengan efisien. Kami berharap Anda memiliki
                    hari yang produktif dan menyenangkan.</p>
            </div>
        </div>
    </div>
</div>
@endsection
