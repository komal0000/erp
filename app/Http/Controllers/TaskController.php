<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Client;
use App\Models\Employee;
use App\Models\CallLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Task::with(['client', 'assignedEmployee.user', 'creator.user', 'callLog'])
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::orderBy('company_name')->get();
        $employees = Employee::with('user')->orderBy('id')->get();
        $callLogs = CallLog::with('client')->orderBy('created_at', 'desc')->take(50)->get();

        return view('tasks.create', compact('clients', 'employees', 'callLogs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'call_log_id' => 'nullable|exists:call_logs,id',
            'client_id' => 'required|exists:clients,id',
            'assigned_to' => 'nullable|exists:employees,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|integer|min:1|max:9',
            'due_date' => 'nullable|date|after:today',
            'started_at' => 'nullable|date',
            'completed_at' => 'nullable|date',
            'notes' => 'nullable|string',
            'estimated_hours' => 'nullable|numeric|min:0',
            'actual_hours' => 'nullable|numeric|min:0'
        ]);

        // Set created_by to current logged in employee
        $validated['created_by'] = Auth::user()->employee->id;

        $task = Task::create($validated);

        return redirect()->route('tasks.index')
                        ->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        $task->load(['client', 'assignedEmployee.user', 'creator.user', 'callLog']);
        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $clients = Client::orderBy('company_name')->get();
        $employees = Employee::with('user')->orderBy('id')->get();
        $callLogs = CallLog::with('client')->orderBy('created_at', 'desc')->take(50)->get();

        return view('tasks.edit', compact('task', 'clients', 'employees', 'callLogs'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'call_log_id' => 'nullable|exists:call_logs,id',
            'client_id' => 'required|exists:clients,id',
            'assigned_to' => 'nullable|exists:employees,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|integer|min:1|max:9',
            'due_date' => 'nullable|date',
            'started_at' => 'nullable|date',
            'completed_at' => 'nullable|date',
            'notes' => 'nullable|string',
            'estimated_hours' => 'nullable|numeric|min:0',
            'actual_hours' => 'nullable|numeric|min:0'
        ]);

        $task->update($validated);

        return redirect()->route('tasks.show', $task)
                        ->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();

        return redirect()->route('tasks.index')
                        ->with('success', 'Task deleted successfully.');
    }
}
