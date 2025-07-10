@extends('layouts.app')

@section('title', 'Add New Client')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><i class="fas fa-user-plus me-2"></i>Add New Client</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('clients.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Back to Clients
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-body">
                <form method="POST" action="{{ route('clients.store') }}">
                    @csrf

                    <!-- User Information -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">Contact Person Information</h5>
                        </div>
                        <div class="col-md-6">
                            <label for="name" class="form-label">Contact Person Name *</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="password" class="form-label">Password *</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                   id="password" name="password" required>
                            @error('password')
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
                                   id="company_name" name="company_name" value="{{ old('company_name') }}" required>
                            @error('company_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="tax_id" class="form-label">Tax ID</label>
                            <input type="text" class="form-control @error('tax_id') is-invalid @enderror"
                                   id="tax_id" name="tax_id" value="{{ old('tax_id') }}">
                            @error('tax_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="business_license" class="form-label">Business License</label>
                            <input type="text" class="form-control @error('business_license') is-invalid @enderror"
                                   id="business_license" name="business_license" value="{{ old('business_license') }}">
                            @error('business_license')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control @error('address') is-invalid @enderror"
                                      id="address" name="address" rows="3">{{ old('address') }}</textarea>
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
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="services[]" value="accounting" id="accounting">
                                        <label class="form-check-label" for="accounting">Accounting</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="services[]" value="payroll" id="payroll">
                                        <label class="form-check-label" for="payroll">Payroll</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="services[]" value="tax_preparation" id="tax_preparation">
                                        <label class="form-check-label" for="tax_preparation">Tax Preparation</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="services[]" value="bookkeeping" id="bookkeeping">
                                        <label class="form-check-label" for="bookkeeping">Bookkeeping</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="services[]" value="hr_consulting" id="hr_consulting">
                                        <label class="form-check-label" for="hr_consulting">HR Consulting</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="services[]" value="financial_planning" id="financial_planning">
                                        <label class="form-check-label" for="financial_planning">Financial Planning</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notes -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"
                                      placeholder="Any additional notes about this client...">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <!-- Submit Buttons -->
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('clients.index') }}" class="btn btn-secondary">Cancel</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Create Client
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Information</h6>
            </div>
            <div class="card-body">
                <h6>Creating a New Client</h6>
                <p class="small text-muted mb-3">
                    Fill out this form to add a new client to the system. The client will receive login credentials
                    via email and can access their dedicated dashboard.
                </p>

                <h6>Required Fields</h6>
                <ul class="small text-muted mb-3">
                    <li>Contact Person Name</li>
                    <li>Email Address</li>
                    <li>Password</li>
                    <li>Company Name</li>
                </ul>

                <h6>Services</h6>
                <p class="small text-muted">
                    Select the services that this client will be using. You can modify these later.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
