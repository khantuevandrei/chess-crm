<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'amount',
        'paid_at',
        'method',
        'description',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
