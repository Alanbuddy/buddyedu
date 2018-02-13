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
            ->wherePivot('type', 'teacher')
            ->withTimestamps();
    }

    public function students()
    {
        return $this->belongsToMany(User::class)
            ->wherePivot('type', 'student')
            ->withPivot('created_at', 'updated_at');

    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }


    public function applications()
    {
        return $this->hasMany(Application::class, 'object_id');
    }

    public function scopeHidden($query)
    {
        return $query->where('hidden', true);
    }

    public function scopeNotHidden($query)
    {
        return $query->where('hidden', false);
    }

    public function getPriceAttribute($value)
    {
        return round($value/100,2);
    }
}

