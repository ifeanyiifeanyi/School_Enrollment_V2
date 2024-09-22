<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcceptanceFee extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'amount',
        'academic_year',
        'department',
        'status',
        'transaction_id',
        'paid_at',
        'due_date',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'due_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    public function getDueDateFormattedAttribute()
    {
        return $this->due_date ? $this->due_date->format('jS F, Y') : null;
    }

    public function getPaidDateFormattedAttribute()
    {
        return $this->paid_at ? $this->paid_at->format('jS F, Y') : null;
    }

    public function getDepartmentAttribute($value)
    {
        return ucfirst($value);
    }
}
