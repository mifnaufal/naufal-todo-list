<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    public function index(Request $request) {
        $query = Task::query();

        if ($request->has('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        $tasks = $query->paginate(10);
        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $tasks = Task::all();
        return view('tasks.create', compact('tasks'));
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'status' => 'required|in:pending,completed',
        ]);

        Task::create($request->all());
        return redirect()->route('tasks.index')->with('success', 'Tugas berhasil ditambahkan!');
    }

    public function updateStatus(Request $request, $id) {
        $request->validate([
            'status' => 'required|in:pending,completed',
        ]);

        $task = Task::findOrFail($id);
        $task->update(['status' => $request->status]);

        return redirect()->route('tasks.index');
    }
}
