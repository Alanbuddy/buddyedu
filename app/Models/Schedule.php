<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $guarded = [];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function point()
    {
        return $this->belongsTo(Point::class);
    }

    public function teachers()
    {
        return $this->belongsToMany(User::class)
            ->wherePivot('type', 'teacher');
    }

    public function students()
    {
        return $this->belongsToMany(User::class)
            ->wherePivot('type', 'student');
    }
}

