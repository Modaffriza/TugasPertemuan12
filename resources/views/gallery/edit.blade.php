
@extends('auth.layouts')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Edit Gambar</div>
                <div class="card-body">
                    <form action="{{ route('gallery.update', $gallery->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul</label>
                            <input type="text" name="title" class="form-control" id="title" value="{{ $gallery->title }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control" id="description" required>{{ $gallery->description }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="picture" class="form-label">Gambar</label>
                            <input type="file" name="picture" class="form-control" id="picture">
                            <small class="form-text text-muted">Kosongkan jika tidak ingin mengganti gambar.</small>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
