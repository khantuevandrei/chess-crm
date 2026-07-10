<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TournamentResult extends Model
{
    protected $fillable = [
        'tournament_id',
        'student_id',
        'place',
        'points',
        'rating_change',
    ];

    public function tournament()
    {
        return $this->belongsTo(Tournament::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
