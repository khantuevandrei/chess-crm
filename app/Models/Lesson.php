<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'trainer_id',
        'student_id',
        'branch_id',
        'type',
        'title',
        'start_time',
        'end_time',
        'status',
        'notes'
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function trainer()
    {
        return $this->belongsTo(Trainer::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'lesson_student')
            ->withPivot('attended')
            ->withTimestamps();
    }
}
