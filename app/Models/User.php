<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Zizaco\Entrust\Traits\EntrustUserTrait;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, EntrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function drawings()
    {
        return $this->hasMany(File::class, 'student_id')
            ->where('extension', 'png');
    }

    public function videos()
    {
        return $this->hasMany(File::class)
            ->where('extension', 'mp4');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function ownMerchant()
    {
        return $this->hasOne(Merchant::class, 'admin_id');
    }


    public function attendances()
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    public function schedules()
    {
        return $this->belongsToMany(Schedule::class);
    }

    public function enrolledShedules()
    {
        return $this->belongsToMany(Schedule::class)
            ->wherePivot('type', 'student');
    }

    public function coachingSchedules()
    {
        return $this->belongsToMany(Schedule::class)
            ->wherePivot('type', 'teacher');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

}
