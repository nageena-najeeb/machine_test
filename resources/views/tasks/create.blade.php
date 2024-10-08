@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Task</h1>

    <form id="create-form" action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description"></textarea>
        </div>

        <div class="mb-3">
            <label for="due_date" class="form-label">Due Date</label>
            <input type="date" class="form-control" id="due_date" name="due_date">
        </div>

        <button type="submit" class="btn btn-success">Create Task</button>
    </form>
</div>
@endsection
@section('form-submit-js')
<script src="{{ asset('task.js') }}"></script>
<script src="{{ asset('common.js') }}"></script>

@endsection