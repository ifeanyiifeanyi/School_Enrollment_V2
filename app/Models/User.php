<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    public function admissionAcceptanceManager()
    {
        return $this->hasOne(AdmissionAcceptanceManager::class);
    }

    public function faculty()
    {
        return $this->belongsTo(Faculty::class);
    }


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_permissions', 'user_id', 'role_id');
    }
    public function permissions()
    {
        // supposed to be permission_id
        return $this->belongsToMany(Permission::class, 'user_permissions', 'user_id', 'role_id');
    }


    public function hasPermission($permission)
    {
        return $this->roles->flatMap(function ($role) {
            return $role->permissions;
        })->contains('name', $permission);
    }


    public function admin()
    {
        return $this->hasOne(Admin::class);
    }


    public function student()
    {
        return $this->hasOne(Student::class);
    }


    // public function applications()
    // {
    //     return $this->hasMany(Application::class);
    // }


    public function applications(): HasOne
    {
        return $this->hasOne(Application::class);
    }



    public function departments()
    {
        return $this->hasMany(Department::class);
    }


    public function getFullNameAttribute()
    {
        $fullName = $this->first_name . ' ' . $this->last_name;

        if ($this->other_names) {
            $fullName .= ' ' . $this->other_names;
        }

        return $fullName;
    }


    // generate random username for users
    public function generateUsername()
    {
        // Combine first name and last name
        $fullName = $this->last_name;

        // Convert full name to array of characters
        $characters = str_split($fullName);

        // Shuffle the characters randomly
        shuffle($characters);

        // Generate the username by joining shuffled characters
        $username = implode('', $characters);

        // Check if username already exists
        $count = User::where('username', $username)->count();

        // If username exists, regenerate
        if ($count > 0) {
            return $this->generateUsername();
        }

        return $username;
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'previous_login_at' => 'datetime',
        'last_login_at' => 'datetime',

    ];


     /**
     * Check if user can apply for current academic session
     */
    public function canApplyForCurrentSession()
    {
        // Get current academic session
        $currentSession = \App\Models\AcademicSession::where('status', 'current')->first();

        // Check if user has been approved in any session
        $hasBeenAdmitted = $this->applications()
            ->where('admission_status', 'approved')
            ->exists();

        if ($hasBeenAdmitted) {
            return false;
        }

        // Check if user has application for current session
        $hasCurrentSessionApplication = $this->applications()
            ->where('academic_session_id', $currentSession->id ?? null)
            ->exists();

        return !$hasCurrentSessionApplication;
    }

     /**
     * Get application status message for display
     */
    public function getApplicationStatusMessage()
    {
        $currentSession = \App\Models\AcademicSession::where('status', 'current')->first();

        // Check if approved in any session
        $approvedApplication = $this->applications()
            ->where('admission_status', 'approved')
            ->first();

        if ($approvedApplication) {
            return 'You have already been admitted and cannot submit another application.';
        }

        // Check current session application
        $currentApplication = $this->applications()
            ->where('academic_session_id', $currentSession->id ?? null)
            ->first();

        if ($currentApplication) {
            if ($currentApplication->payment_id) {
                return 'You have already completed your application for the current academic session.';
            } else {
                return 'Please complete your payment to finish your application.';
            }
        }

        return null; // Can apply
    }
}
