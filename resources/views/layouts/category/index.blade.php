@extends('dashboard')
@section('content')
<h3>Tabel category  </h3>
<!-- Button trigger modal -->

<div class="d-flex justify-content-end">
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
        <div class="modal-body">
            <form action="/create/category" method="post">
                @csrf
                @method('POST')
                <div class="row">
                    <div class="col-12 mb-3">
                        <label for="" class="form-label">Nama category</label>
                        <input type="text" name="name" placeholder="category" class="form-control">
                    </div>
                    <div class="col-12 mb-3 d-flex justify-content-end align-items-center">
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
            <td>category</td>
            <td>Aksi</td>
        </tr>
    </thead>
    <tbody>
        @forelse ($categories as $index => $category)
        <tr>
            <td>{{ $index+1 }}</td>
            <td>{{ $category    ->namacategory   }}</td>
            <td>
                <div class="d-flex gap-2">
                            <div class="d-flex justify-content-end">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal-{{$category  ->id}}">
                                    Edit
                                  </button>
                            </div>
                    <form action="delete/category   /{{ $category  ->id }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Hapus</button>
                    </form>
                </div>
            </td>
            <div class="modal fade" id="exampleModal-{{ $category   ->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">edit Data</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('edit.category' , [$category ->id]) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class=" col-lg-12 mb-3">
                                    <label class="form-label">Nama category </label>
                                    <input type="text" name="namacategory   " placeholder="nama" class="form-control" value="{{$category   ->namacategory   }}">
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
            @empty
            <tr>
                <td colspan="15" >
                    <div class="d-flex justify-content-center" >Data Kosong</div>
                </td>
            </tr>
            @endforelse
    </tbody>
</table>

@endsection
