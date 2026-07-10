<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RatingHistory extends Model
{
    protected $fillable = [
        'student_id',
        'fide_rating',
        'local_rating',
        'recorded_at',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
