<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'birth_date',
        'fide_rating',
        'local_rating',
        'rank',
        'parent_name',
        'parent_phone',
        'branch_id',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function trainers()
    {
        return $this->belongsToMany(Trainer::class, 'trainer_student')
            ->withTimestamps();
    }

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'lesson_student')
            ->withPivot('attended')
            ->withTimestamps();
    }

    public function pyaments()
    {
        return $this->hasMany(Payment::class);
    }

    public function tournamentResults()
    {
        return $this->hasMany(TournamentResult::class);
    }

    public function ratingsHistory()
    {
        return $this->hasMany(RatingHistory::class);
    }
}
