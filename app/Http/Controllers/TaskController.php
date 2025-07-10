<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Client;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Task::with(['client', 'assignedTo.user', 'createdBy.user', 'callLog'])
                     ->orderBy('created_at', 'desc');

        // Filter by employee role
        if (Auth::user()->isEmployee()) {
            $query->where('assigned_to', Auth::user()->employee->id);
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        // Filter by client
        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        $tasks = $query->paginate(15)->withQueryString();
        $clients = Client::orderBy('company_name')->get();

        return view('tasks.index', compact('tasks', 'clients'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task->load(['client', 'assignedTo.user', 'createdBy.user', 'callLog']);
        return view('tasks.show', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'status' => 'required|integer|min:1|max:9',
            'notes' => 'nullable|string'
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index')
                        ->with('success', 'Task updated successfully.');
    }
}
