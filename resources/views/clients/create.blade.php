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

                    <!-- Phone Numbers -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                                <h5 class="mb-0">Phone Numbers</h5>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="addPhone">
                                    <i class="fas fa-plus me-1"></i>Add Phone
                                </button>
                            </div>
                            <div id="phoneContainer">
                                <div class="row phone-item mb-3">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="phones[0][phone]" placeholder="Phone number" value="{{ old('phones.0.phone') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="phones[0][type]"
                                               placeholder="Type (e.g., Primary, Mobile)"
                                               list="phoneTypes"
                                               value="{{ old('phones.0.type', 'Primary') }}">
                                        <datalist id="phoneTypes">
                                            <option value="Primary">
                                            <option value="Mobile">
                                            <option value="Office">
                                            <option value="Fax">
                                            <option value="Home">
                                            <option value="Work">
                                            <option value="Emergency">
                                        </datalist>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-danger btn-sm remove-phone" style="display: none;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Email Addresses -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                                <h5 class="mb-0">Additional Email Addresses</h5>
                                <button type="button" class="btn btn-sm btn-outline-primary" id="addEmail">
                                    <i class="fas fa-plus me-1"></i>Add Email
                                </button>
                            </div>
                            <div id="emailContainer">
                                <div class="row email-item mb-3">
                                    <div class="col-md-6">
                                        <input type="email" class="form-control" name="emails[0][email]" placeholder="Additional email address" value="{{ old('emails.0.email') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <input type="text" class="form-control" name="emails[0][type]"
                                               placeholder="Type (e.g., Secondary, Billing)"
                                               list="emailTypes"
                                               value="{{ old('emails.0.type', 'Secondary') }}">
                                        <datalist id="emailTypes">
                                            <option value="Secondary">
                                            <option value="Billing">
                                            <option value="Support">
                                            <option value="Personal">
                                            <option value="Finance">
                                            <option value="Legal">
                                            <option value="HR">
                                            <option value="Technical">
                                        </datalist>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-danger btn-sm remove-email" style="display: none;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Services -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">Services</h5>
                            @if($services->count() > 0)
                                <div class="row">
                                    @foreach($services as $service)
                                        <div class="col-md-4 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="services[]"
                                                       value="{{ $service->id }}" id="service_{{ $service->id }}"
                                                       {{ in_array($service->id, old('services', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="service_{{ $service->id }}" title="{{ $service->detail }}">
                                                    {{ $service->name }}
                                                    @if($service->detail)
                                                        <i class="fas fa-info-circle text-muted ms-1" data-bs-toggle="tooltip" title="{{ $service->detail }}"></i>
                                                    @endif
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    No services available. <a href="#" class="alert-link">Contact administrator</a> to add services.
                                </div>
                            @endif
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

                    <!-- Employee Assignment -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <h5 class="border-bottom pb-2 mb-3">Employee Assignment</h5>
                            <p class="text-muted small mb-3">Select employees who will have access to this client's information</p>
                            @if($employees->count() > 0)
                                <div class="row">
                                    @foreach($employees as $employee)
                                        <div class="col-md-6 col-lg-4 mb-3">
                                            <div class="card border">
                                                <div class="card-body p-3">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                               name="assigned_employees[]" value="{{ $employee->id }}"
                                                               id="employee_{{ $employee->id }}"
                                                               {{ in_array($employee->id, old('assigned_employees', [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label w-100" for="employee_{{ $employee->id }}">
                                                            <div class="d-flex align-items-center">
                                                                <div class="flex-shrink-0">
                                                                    <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                                        <i class="fas fa-user"></i>
                                                                    </div>
                                                                </div>
                                                                <div class="flex-grow-1 ms-3">
                                                                    <h6 class="mb-0">{{ $employee->user->name }}</h6>
                                                                    <small class="text-muted">{{ $employee->position }}</small>
                                                                    @if($employee->department)
                                                                        <br><small class="text-muted">{{ $employee->department }}</small>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    No active employees available for assignment. <a href="{{ route('employees.create') }}">Create an employee</a> first.
                                </div>
                            @endif
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

                <h6>Employee Assignment</h6>
                <p class="small text-muted mb-3">
                    Assign employees to this client to grant them access to client information and documents.
                    Employees will be able to view and manage this client's data based on their permissions.
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

@push('scripts')
<script>
// Employee assignment visual feedback
document.addEventListener('DOMContentLoaded', function() {
    const employeeCheckboxes = document.querySelectorAll('input[name="assigned_employees[]"]');

    employeeCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            const card = this.closest('.card');
            if (this.checked) {
                card.classList.add('border-primary');
                card.style.backgroundColor = '#f8f9ff';
            } else {
                card.classList.remove('border-primary');
                card.style.backgroundColor = '';
            }
        });
    });

    // Phone and Email Management
    let phoneIndex = 1; // Start from 1 since index 0 is already used
    let emailIndex = 1; // Start from 1 since index 0 is already used

    // Add phone functionality
    document.getElementById('addPhone').addEventListener('click', function() {
        const phoneContainer = document.getElementById('phoneContainer');
        const phoneHTML = `
            <div class="row phone-item mb-3">
                <div class="col-md-6">
                    <input type="text" class="form-control" name="phones[${phoneIndex}][phone]" placeholder="Phone number">
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="phones[${phoneIndex}][type]"
                           placeholder="Type (e.g., Primary, Mobile)"
                           list="phoneTypes"
                           value="Primary">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-phone">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;
        phoneContainer.insertAdjacentHTML('beforeend', phoneHTML);
        phoneIndex++;
        updateRemoveButtons('phone');
    });

    // Add email functionality
    document.getElementById('addEmail').addEventListener('click', function() {
        const emailContainer = document.getElementById('emailContainer');
        const emailHTML = `
            <div class="row email-item mb-3">
                <div class="col-md-6">
                    <input type="email" class="form-control" name="emails[${emailIndex}][email]" placeholder="Additional email address">
                </div>
                <div class="col-md-4">
                    <input type="text" class="form-control" name="emails[${emailIndex}][type]"
                           placeholder="Type (e.g., Secondary, Billing)"
                           list="emailTypes"
                           value="Secondary">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-email">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        `;
        emailContainer.insertAdjacentHTML('beforeend', emailHTML);
        emailIndex++;
        updateRemoveButtons('email');
    });

    // Remove phone/email functionality
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-phone')) {
            e.target.closest('.phone-item').remove();
            updateRemoveButtons('phone');
        }
        if (e.target.closest('.remove-email')) {
            e.target.closest('.email-item').remove();
            updateRemoveButtons('email');
        }
    });

    // Update remove buttons visibility
    function updateRemoveButtons(type) {
        const items = document.querySelectorAll(`.${type}-item`);
        items.forEach((item, index) => {
            const removeBtn = item.querySelector(`.remove-${type}`);
            if (items.length > 1) {
                removeBtn.style.display = 'block';
            } else {
                removeBtn.style.display = 'none';
            }
        });
    }
});
</script>
@endpush
