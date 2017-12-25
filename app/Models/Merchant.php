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

    public function users()
    {
        return $this->belongsToMany(User::class);
    }


    public function courses()
    {
        return $this->belongsToMany(Course::class)
            ->withTimestamps()->withPivot('status');
    }

    public function teachers()
    {
        return $this->hasMany(User::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function ongoingSchedules()
    {
        return $this->hasMany(Schedule::class)
            ->where('end', '>', date('Y-m-d H:i:s'));
    }

    public function finishedSchedules()
    {
        return $this->hasMany(Schedule::class)
            ->where('end', '<', date('Y-m-d H:i:s'));
    }


    public function points()
    {
        return $this->hasMany(Point::class);
    }

    public function orders()
    {
        return $this->hasManyThrough(Order::class, Schedule::class, 'merchant_id', 'product_id');
    }

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
