<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tournament extends Model
{
    protected $fillable = [
        'name',
        'location',
        'start_date',
        'end_date',
        'type',
        'status'
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'datetime',
            'end_date' => 'datetime',
        ];
    }

    public function tournamentResults()
    {
        return $this->hasMany(TournamentResult::class);
    }
}
