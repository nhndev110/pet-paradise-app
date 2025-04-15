<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Employee extends Model
{
    protected $fillable = [
        'user_id',
        'position_id',
        'hire_date',
        'is_male',
        'birth_date',
        'address',
        'bio',
        'is_locked',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function position()
    {
        return $this->belongsTo(Position::class);
    }

    protected function hireDate(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? Carbon::parse($value)->format('d/m/Y') : '',
            set: fn($value) => $value ? Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d') : '',
        );
    }

    protected function birthDate(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? Carbon::parse($value)->format('d/m/Y') : '',
            set: fn($value) => $value ? Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d') : '',
        );
    }
}
