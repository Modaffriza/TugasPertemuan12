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
                <div id="gallery" class="row">
                    <!-- Galeri akan dimuat secara dinamis -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const galleryContainer = document.getElementById('gallery');

        // Ambil data dari endpoint API
        fetch('/api/gallery')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const galleries = data.data;

                    if (galleries.length > 0) {
                        galleries.forEach(gallery => {
                            const col = document.createElement('div');
                            col.classList.add('col-sm-2');

                            col.innerHTML = `
                                <div>
                                    <a class="example-image-link" href="/storage/posts_image/${gallery.picture}" data-lightbox="roadtrip" data-title="${gallery.description}">
                                        <img class="example-image img-fluid mb-2" src="/storage/posts_image/${gallery.picture}" alt="${gallery.title}">
                                    </a>
                                    <div class="mt-2">
                                        <a href="/gallery/${gallery.id}/edit" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="/gallery/${gallery.id}" method="POST" style="display:inline;">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus gambar ini?')">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            `;
                            galleryContainer.appendChild(col);
                        });
                    } else {
                        galleryContainer.innerHTML = `<div class="col-sm-12 text-center"><h3>Tidak ada data.</h3></div>`;
                    }
                } else {
                    galleryContainer.innerHTML = `<div class="col-sm-12 text-center"><h3>Gagal memuat data.</h3></div>`;
                }
            })
            .catch(error => {
                console.error('Error fetching gallery data:', error);
                galleryContainer.innerHTML = `<div class="col-sm-12 text-center"><h3>Error memuat data.</h3></div>`;
            });
    });
</script>
@endsection
