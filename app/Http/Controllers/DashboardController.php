<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Client;
use App\Models\Employee;

class DashboardController extends Controller
{
    /**
     * Admin Dashboard
     */
    public function adminDashboard()
    {
        $totalClients = Client::count();
        $totalEmployees = Employee::count();
        $activeClients = Client::where('status', 'active')->count();
        $recentClients = Client::with('user')->latest()->take(5)->get();

        return view('dashboard.admin', compact('totalClients', 'totalEmployees', 'activeClients', 'recentClients'));
    }

    /**
     * Employee Dashboard
     */
    public function employeeDashboard()
    {
        $employee = Auth::user()->employee;
        $accessibleClients = $employee->accessibleClients()->where('is_active', true)->get();

        return view('dashboard.employee', compact('employee', 'accessibleClients'));
    }

    /**
     * Client Dashboard
     */
    public function clientDashboard()
    {
        $client = Auth::user()->client;
        $documents = $client->documents()->latest()->take(5)->get();
        $images = $client->images()->latest()->take(5)->get();
        $formResponses = $client->formResponses()->with('dynamicForm')->latest()->take(5)->get();

        return view('dashboard.client', compact('client', 'documents', 'images', 'formResponses'));
    }
}
