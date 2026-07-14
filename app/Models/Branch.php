<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'short_name',
        'address',
        'city',
        'phone',
        'opening_date',
        'code',
        'email',
        'postal_code',
        'website',
        'description',
        'capacity',
        'area',
        'status',
    ];

    public function students()
    {
        return $this->hasMany(Student::class);
    }

    public function trainers()
    {
        return $this->hasMany(Trainer::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function studentsPayments()
    {
        return $this->hasManyThrough(Payment::class, Student::class);
    }
}
