@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Edit Call Log</h4>
                    <div>
                        <a href="{{ route('call-logs.show', $callLog) }}" class="btn btn-info btn-sm">
                            <i class="fas fa-eye"></i> View
                        </a>
                        <a href="{{ route('call-logs.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('call-logs.update', $callLog) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <!-- Left Column -->
                            <div class="col-md-6">
                                <h5 class="mb-3">Basic Information</h5>

                                <div class="form-group">
                                    <label for="client_id">Client *</label>
                                    <select name="client_id" id="client_id" class="form-control" required>
                                        <option value="">Select a client</option>
                                        @foreach($clients as $client)
                                            <option value="{{ $client->id }}" {{ old('client_id', $callLog->client_id) == $client->id ? 'selected' : '' }}>
                                                {{ $client->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="employee_id">Assigned Employee</label>
                                    <select name="employee_id" id="employee_id" class="form-control">
                                        <option value="">Select an employee</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}" {{ old('employee_id', $callLog->employee_id) == $employee->id ? 'selected' : '' }}>
                                                {{ $employee->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="caller_name">Caller Name</label>
                                    <input type="text" name="caller_name" id="caller_name" class="form-control"
                                           value="{{ old('caller_name', $callLog->caller_name) }}" placeholder="Name of the person who called">
                                </div>

                                <div class="form-group">
                                    <label for="caller_phone">Caller Phone</label>
                                    <input type="text" name="caller_phone" id="caller_phone" class="form-control"
                                           value="{{ old('caller_phone', $callLog->caller_phone) }}" placeholder="Phone number">
                                </div>

                                <div class="form-group">
                                    <label for="call_type">Call Type *</label>
                                    <select name="call_type" id="call_type" class="form-control" required>
                                        <option value="incoming" {{ old('call_type', $callLog->call_type) == 'incoming' ? 'selected' : '' }}>Incoming</option>
                                        <option value="outgoing" {{ old('call_type', $callLog->call_type) == 'outgoing' ? 'selected' : '' }}>Outgoing</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="call_date">Call Date & Time</label>
                                    <input type="datetime-local" name="call_date" id="call_date" class="form-control"
                                           value="{{ old('call_date', $callLog->call_date ? $callLog->call_date->format('Y-m-d\TH:i') : '') }}">
                                </div>

                                <div class="form-group">
                                    <label for="duration_minutes">Duration (minutes)</label>
                                    <input type="number" name="duration_minutes" id="duration_minutes" class="form-control"
                                           value="{{ old('duration_minutes', $callLog->duration_minutes) }}" min="0" placeholder="Call duration in minutes">
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="col-md-6">
                                <h5 class="mb-3">Call Details</h5>

                                <div class="form-group">
                                    <label for="priority">Priority *</label>
                                    <select name="priority" id="priority" class="form-control" required>
                                        <option value="low" {{ old('priority', $callLog->priority) == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ old('priority', $callLog->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ old('priority', $callLog->priority) == 'high' ? 'selected' : '' }}>High</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status *</label>
                                    <select name="status" id="status" class="form-control" required>
                                        <option value="1" {{ old('status', $callLog->status) == 1 ? 'selected' : '' }}>Pending</option>
                                        <option value="2" {{ old('status', $callLog->status) == 2 ? 'selected' : '' }}>In Progress</option>
                                        <option value="3" {{ old('status', $callLog->status) == 3 ? 'selected' : '' }}>On Hold</option>
                                        <option value="4" {{ old('status', $callLog->status) == 4 ? 'selected' : '' }}>Escalated</option>
                                        <option value="5" {{ old('status', $callLog->status) == 5 ? 'selected' : '' }}>Waiting for Client</option>
                                        <option value="6" {{ old('status', $callLog->status) == 6 ? 'selected' : '' }}>Testing</option>
                                        <option value="7" {{ old('status', $callLog->status) == 7 ? 'selected' : '' }}>Completed</option>
                                        <option value="8" {{ old('status', $callLog->status) == 8 ? 'selected' : '' }}>Resolved</option>
                                        <option value="9" {{ old('status', $callLog->status) == 9 ? 'selected' : '' }}>Backlog</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <div class="form-check">
                                        <input type="checkbox" name="follow_up_required" id="follow_up_required" class="form-check-input"
                                               value="1" {{ old('follow_up_required', $callLog->follow_up_required) ? 'checked' : '' }}
                                               onchange="toggleFollowUpDate()">
                                        <label class="form-check-label" for="follow_up_required">
                                            Follow-up Required
                                        </label>
                                    </div>
                                </div>

                                <div class="form-group" id="follow_up_date_group" style="{{ old('follow_up_required', $callLog->follow_up_required) ? '' : 'display: none;' }}">
                                    <label for="follow_up_date">Follow-up Date</label>
                                    <input type="date" name="follow_up_date" id="follow_up_date" class="form-control"
                                           value="{{ old('follow_up_date', $callLog->follow_up_date ? $callLog->follow_up_date->format('Y-m-d') : '') }}">
                                </div>

                                <div class="form-group">
                                    <label for="subject">Subject *</label>
                                    <input type="text" name="subject" id="subject" class="form-control"
                                           value="{{ old('subject', $callLog->subject) }}" required placeholder="Brief subject of the call">
                                </div>
                            </div>
                        </div>

                        <!-- Full Width Fields -->
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="description">Description *</label>
                                    <textarea name="description" id="description" class="form-control" rows="5" required
                                              placeholder="Detailed description of the call...">{{ old('description', $callLog->description) }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label for="notes">Additional Notes</label>
                                    <textarea name="notes" id="notes" class="form-control" rows="3"
                                              placeholder="Any additional notes or comments...">{{ old('notes', $callLog->notes) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="form-group d-flex justify-content-between">
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Call Log
                                </button>
                                <button type="button" class="btn btn-secondary" onclick="window.history.back()">
                                    <i class="fas fa-times"></i> Cancel
                                </button>
                            </div>
                            <div>
                                @if($callLog->tasks->count() > 0)
                                    <small class="text-muted">
                                        This call log has {{ $callLog->tasks->count() }} related task(s)
                                    </small>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
function toggleFollowUpDate() {
    const checkbox = document.getElementById('follow_up_required');
    const dateGroup = document.getElementById('follow_up_date_group');

    if (checkbox.checked) {
        dateGroup.style.display = 'block';
    } else {
        dateGroup.style.display = 'none';
        document.getElementById('follow_up_date').value = '';
    }
}

// Auto-populate caller info if client is selected
document.getElementById('client_id').addEventListener('change', function() {
    const clientId = this.value;

    if (clientId && !document.getElementById('caller_name').value) {
        // You could make an AJAX call here to get client contact info
        // For now, we'll just clear the fields to let user enter manually
    }
});
</script>
@endsection
