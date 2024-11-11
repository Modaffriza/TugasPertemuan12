@extends('auth.layouts')

@section('content')
<div class="row justify-content-center mt-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Dashboard</span>
                <a href="{{ route('gallery.create') }}" class="btn btn-sm btn-success">Create</a>
            </div>
            <div class="card-body">
                <div class="row">
                    @if (count($galleries) > 0)
                        @foreach ($galleries as $gallery)
                            <div class="col-sm-2">
                                <div>
                                    <a class="example-image-link" href="{{ asset('storage/posts_image/'.$gallery->picture) }}" data-lightbox="roadtrip" data-title="{{ $gallery->description }}">
                                        <img class="example-image img-fluid mb-2" src="{{ asset('storage/posts_image/'.$gallery->picture) }}" alt="Image">
                                    </a>
                                    <div class="mt-2">
                                        <!-- Tombol Edit -->
                                        <a href="{{ route('gallery.edit', $gallery->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                        
                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('gallery.destroy', $gallery->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus gambar ini?')">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-sm-12 text-center">
                            <h3>Tidak ada data.</h3>
                        </div>
                    @endif
                </div>
                <div class="d-flex">
                    {{ $galleries->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
