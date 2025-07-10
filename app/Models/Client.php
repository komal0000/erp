<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'address',
        'tax_id',
        'business_license',
        'status',
        'services',
        'notes'
    ];

    protected $casts = [
        'services' => 'array',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function phones()
    {
        return $this->hasMany(ClientPhone::class);
    }

    public function emails()
    {
        return $this->hasMany(ClientEmail::class);
    }

    public function documents()
    {
        return $this->hasMany(ClientDocument::class);
    }

    public function images()
    {
        return $this->hasMany(ClientImage::class);
    }

    public function employeeAccesses()
    {
        return $this->hasMany(ClientEmployeeAccess::class);
    }

    public function formResponses()
    {
        return $this->hasMany(DynamicFormResponse::class);
    }

    public function accessibleEmployees()
    {
        return $this->belongsToMany(Employee::class, 'client_employee_accesses')
                    ->withPivot('permissions', 'access_granted_date', 'access_expires_date', 'is_active')
                    ->withTimestamps();
    }
}
