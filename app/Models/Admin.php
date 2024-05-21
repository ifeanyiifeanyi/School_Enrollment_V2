<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'admins';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullNameAttribute()
    {
        $fullName = $this->first_name . ' ' . $this->last_name;

        if ($this->other_names) {
            $fullName .= ' ' . $this->other_names;
        }

        return $fullName;
    }
}
