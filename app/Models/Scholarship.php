<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'slug'];

    public function questions()
    {
        return $this->hasMany(ScholarQuestion::class);
    }

    public function applications()
    {
        return $this->hasMany(ScholarApplication::class);
    }
}
