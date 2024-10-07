@extends('layouts.app')

@section('content')
<div class="container">
    <!-- <h1>My Tasks</h1> -->
    <a href="{{ route('tasks.create') }}" class="btn btn-primary">Create New Task</a>

    <table class="table mt-4">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody id="task-table-body">
            <!-- Tasks will be loaded here by AJAX -->
        </tbody>
    </table>
</div>
@endsection
@section('form-submit-js')
<script>
    $(document).ready(function() {
        // Load tasks via AJAX
        function loadTasks() {
            $.ajax({
                url: "{{ route('tasks.index') }}",
                method: 'GET',
                success: function(tasks) {
                    let rows = '';
                    tasks.forEach(function(task) {
                        rows += `
                            <tr>
                                <td>${task.title}</td>
                                <td>${task.description}</td>
                                <td>${task.due_date}</td>
                                <td>${task.status.charAt(0).toUpperCase() + task.status.slice(1)}</td>
                                <td>
                                    <a href="/tasks/${task.id}/edit" class="btn btn-sm btn-warning">Edit</a>
                                    <button class="btn btn-sm btn-danger delete-task" data-id="${task.id}">Delete</button>
                                </td>
                            </tr>
                        `;
                    });
                    $('#task-table-body').html(rows);
                }
            });
        }

        // Call loadTasks on page load
        loadTasks();

        // Handle delete task
        $(document).on('click', '.delete-task', function() {
            let taskId = $(this).data('id');
            $.ajax({
                url: `/tasks/${taskId}`,  // Corrected here
                method: 'DELETE',
                data: {
                    _token: "{{ csrf_token() }}",
                },
                success: function(response) {
                    loadTasks(); // Reload tasks after deletion
                    alert('Task deleted successfully.');
                },
                error: function(error) {
                    alert('There was an error deleting the task.');
                }
            });
        });
    });
</script>
@endsection