<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function academicSession()
    {
        return $this->belongsTo(AcademicSession::class, 'academic_session_id');
    }


    protected $table = 'applications';


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
    public function applicationDepartment()
    {
        return $this->hasManyThrough(
            Department::class,
            User::class,
            'id', // Foreign key on the applications table for the user_id
            'id', // Foreign key on the users table for the user_id
            'user_id', // Local key on the applications table for the user_id
            'id' // Local key on the users table for the user_id
        );
    }
}
