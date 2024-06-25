<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarApplication extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class);
    }

    public function answers()
    {
        return $this->hasMany(ScholarAnswer::class, 'application_id');
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }


}
