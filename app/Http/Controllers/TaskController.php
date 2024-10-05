<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    // Display a list
    public function index() {
        $tasks = Task::where('user_id', Auth::id())->orWhereHas('sharedWith', function($query) {
            $query->where('user_id', Auth::id());
        })->get();
        
        return view('tasks.index', compact('tasks'));
    }

    // creating a new task
    public function create() {
        return view('tasks.create');
    }

    // Store 
    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'due_date' => 'nullable|date',
        ]);

        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->due_date = $request->due_date;
        $task->user_id = Auth::id();
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Task created successfully');
    }

    // edit 
    public function edit(Task $task) {
        $this->authorize('update', $task); 
        return view('tasks.edit', compact('task'));
    }

    // Update 
    public function update(Request $request, Task $task) {
        $this->authorize('update', $task);

        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'due_date' => 'nullable|date',
        ]);

        $task->title = $request->title;
        $task->description = $request->description;
        $task->due_date = $request->due_date;
        $task->status = $request->status;
        $task->save();

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully');
    }

    // Delete t
    public function destroy(Task $task) {
        $this->authorize('delete', $task);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
    }

    // share task
    public function share(Request $request, Task $task) {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);
    
        $task->sharedWith()->attach($request->user_id);
        return back()->with('success', 'Task shared successfully.');
    }
}

