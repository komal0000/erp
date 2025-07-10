@extends('layouts.app')

@section('title', 'Edit Client - ' . $client->company_name)

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-edit me-2"></i>Edit Client: {{ $client->company_name }}</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('clients.show', $client->id) }}" class="btn btn-outline-secondary me-2">
            <i class="fas fa-arrow-left me-2"></i>Back to Client
        </a>
        <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-list me-2"></i>All Clients
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-body">
                <form method="POST" action="{{ route('clients.update', $client->id) }}">
                    @csrf
                    @method('PUT')

                    <!-- User Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">Contact Person Information</h5>
                        </div>
                        <div class="col-md-6">
                            <label for="name" class="form-label">Contact Person Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $client->user->name) }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email', $client->user->email) }}" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Company Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">Company Information</h5>
                        </div>
                        <div class="col-md-6">
                            <label for="company_name" class="form-label">Company Name *</label>
                            <input type="text" class="form-control @error('company_name') is-invalid @enderror"
                                   id="company_name" name="company_name" value="{{ old('company_name', $client->company_name) }}" required>
                            @error('company_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="status" class="form-label">Status *</label>
                            <select class="form-control @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="active" {{ old('status', $client->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $client->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="suspended" {{ old('status', $client->status) === 'suspended' ? 'selected' : '' }}>Suspended</option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tax_id" class="form-label">Tax ID</label>
                            <input type="text" class="form-control @error('tax_id') is-invalid @enderror"
                                   id="tax_id" name="tax_id" value="{{ old('tax_id', $client->tax_id) }}">
                            @error('tax_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="business_license" class="form-label">Business License</label>
                            <input type="text" class="form-control @error('business_license') is-invalid @enderror"
                                   id="business_license" name="business_license" value="{{ old('business_license', $client->business_license) }}">
                            @error('business_license')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                      id="address" name="address" rows="3">{{ old('address', $client->address) }}</textarea>
                            @error('address')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Services -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">Services</h5>
                            <div class="row">
                                @php
                                    $currentServices = old('services', $client->services ?? []);
                                    $availableServices = [
                                        'accounting' => 'Accounting',
                                        'payroll' => 'Payroll',
                                        'tax_preparation' => 'Tax Preparation',
                                        'bookkeeping' => 'Bookkeeping',
                                        'hr_consulting' => 'HR Consulting',
                                        'financial_planning' => 'Financial Planning'
                                    ];
                                @endphp

                                @foreach($availableServices as $value => $label)
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="services[]"
                                               value="{{ $value }}" id="{{ $value }}"
                                               {{ in_array($value, $currentServices) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="{{ $value }}">{{ $label }}</label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"
                                      placeholder="Any additional notes about this client...">{{ old('notes', $client->notes) }}</textarea>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('clients.show', $client->id) }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Update Client
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- Current Contact Methods -->
        @if($client->phones->count() > 0 || $client->emails->count() > 0)
        <div class="card shadow mb-4">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="fas fa-address-book me-2"></i>Current Contact Methods</h6>
            </div>
            <div class="card-body">
                @if($client->phones->count() > 0)
                <h6>Phone Numbers</h6>
                @foreach($client->phones as $phone)
                <p class="mb-1 small">
                    <i class="fas fa-phone me-2"></i>{{ $phone->phone }}
                    <span class="badge bg-secondary ms-2">{{ ucfirst($phone->type) }}</span>
                </p>
                @endforeach
                <hr>
                @endif

                @if($client->emails->count() > 0)
                <h6>Additional Emails</h6>
                @foreach($client->emails as $email)
                <p class="mb-1 small">
                    <i class="fas fa-envelope me-2"></i>{{ $email->email }}
                    <span class="badge bg-secondary ms-2">{{ ucfirst($email->type) }}</span>
                </p>
                @endforeach
                @endif
            </div>
        </div>
        @endif

        <!-- Help Information -->
        <div class="card shadow">
            <div class="card-header bg-warning text-dark">
                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Edit Information</h6>
            </div>
            <div class="card-body">
                <h6>Editing Client</h6>
                <p class="small text-muted mb-3">
                    Update the client's information using this form. Changes will be saved immediately.
                </p>

                <h6>Required Fields</h6>
                <ul class="small text-muted mb-3">
                    <li>Contact Person Name</li>
                    <li>Email Address</li>
                    <li>Company Name</li>
                    <li>Status</li>
                </ul>

                <h6>Services</h6>
                <p class="small text-muted">
                    Update the services that this client is using. You can select multiple services.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
