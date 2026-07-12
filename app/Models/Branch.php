<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
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
}
