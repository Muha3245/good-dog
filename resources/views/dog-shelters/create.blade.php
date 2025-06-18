@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Create New Dog Shelter</h1>

    <form action="{{ route('dog-shelters.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('dog-shelters.form')
        <button type="submit" class="btn btn-primary mt-3">Create Shelter</button>
    </form>
</div>

@section('scripts')
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('description');
</script>
@endsection
@endsection