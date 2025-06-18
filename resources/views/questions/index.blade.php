@extends('layouts.admin')

@section('admin')
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Manage Questions</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="/dashboard">Home</a></li>
                    <li class="breadcrumb-item active">Questions</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Questions List</h3>
                        <div class="card-tools">
                            <a href="{{ route('questions.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus mr-1"></i> Add New
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-check"></i> Success!</h5>
                            {{ session('success') }}
                        </div>
                        @endif

                        <table class="table table-bordered table-hover">
                            <thead class="thead-light">
                                <tr>
                                    <th style="width: 10%">Order</th>
                                    <th>Question</th>
                                    <th style="width: 15%">Type</th>
                                    <th style="width: 10%">Required</th>
                                    <th style="width: 15%">Actions</th>
                                </tr>
                            </thead>
                            <tbody id="sortable">
                                @foreach($questions as $question)
                                <tr data-id="{{ $question->id }}">
                                    <td class="handle text-center"><i class="fas fa-arrows-alt"></i> {{ $question->order }}</td>
                                    <td>{{ $question->question }}</td>
                                    <td class="text-capitalize">{{ $question->type }}</td>
                                    <td class="text-center">
                                        @if($question->is_required)
                                            <span class="badge badge-success">Yes</span>
                                        @else
                                            <span class="badge badge-secondary">No</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('questions.edit', $question->id) }}" 
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('questions.destroy', $question->id) }}" 
                                              method="POST" style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" 
                                                    onclick="return confirm('Are you sure?')" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .handle {
        cursor: move;
    }
    .sortable-ghost {
        opacity: 0.5;
        background: #c8ebfb;
    }
</style>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    new Sortable(document.getElementById('sortable'), {
        handle: '.handle',
        animation: 150,
        ghostClass: 'sortable-ghost',
        onEnd: function() {
            const order = Array.from(document.querySelectorAll('#sortable tr')).map(tr => tr.dataset.id);
            
            fetch("{{ route('questions.reorder') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({ order: order })
            });
        }
    });
});
</script>
@endsection
