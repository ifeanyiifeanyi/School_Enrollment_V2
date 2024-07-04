<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionAcceptanceManager extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'admission_acceptance_status', 'remarks', 'academic_session'];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
