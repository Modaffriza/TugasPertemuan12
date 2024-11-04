@extends('auth.layouts')
@section('content')
<h2>Edit User</h2>
<form action="{{ route('users.update', $user->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label for="name">Name</label>
    <input type="text" name="name" id="name" value="{{ $user->name }}" required>
    <br>

    <label for="email">Email</label>
    <input type="email" name="email" id="email" value="{{ $user->email }}" required>
    <br>

    <label for="photo">Photo</label>
    <input type="file" name="photo" id="photo">
    @if($user->photo)
        <img src="{{ asset('storage/' . $user->photo) }}" width="100px">
    @endif
    <br>

    <button type="submit">Update</button>
</form>
<a href="{{ route('users.index') }}">Back to Users List</a>
@endsection
