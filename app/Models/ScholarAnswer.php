<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarAnswer extends Model
{
    use HasFactory;
    protected $fillable = ['application_id', 'scholar_question_id', 'scholarship_id', 'answer_text'];

    public function application()
    {
        return $this->belongsTo(ScholarApplication::class, 'application_id');
    }

    public function question()
    {
        return $this->belongsTo(ScholarQuestion::class, 'scholar_question_id');
    }

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class, 'scholarship_id');
    }
}
