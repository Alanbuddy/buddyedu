<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Merchant extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function admin()
    {
        return $this->belongsTo(User::class);
    }

    public function students()
    {
        return $this->belongsToMany(User::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function teachers()
    {
        return $this->hasMany(User::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function points()
    {
        return $this->hasMany(Point::class);
    }

    public function orders()
    {
        return $this->hasManyThrough(Order::class, Schedule::class, 'merchant_id', 'product_id');
    }
}
