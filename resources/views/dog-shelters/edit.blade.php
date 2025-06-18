@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Dog Shelter</h1>

    <form action="{{ route('dog-shelters.update', $dogShelter->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('dog-shelters.form')
        <button type="submit" class="btn btn-primary mt-3">Update Shelter</button>
    </form>
</div>

@section('scripts')
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description');
</script>
@endsection
@endsection