<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    Protected $guarded = [];
    protected $table = 'students';


    public function user(){
        return $this->belongsTo(User::class);
    }

    // public function applications()
    // {
    //     return $this->hasMany(Application::class);
    // }

    protected $casts = [
        // 'dob' => 'date',
        
    ];
}
