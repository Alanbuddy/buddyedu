<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    protected $guarded = [];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class, 'object_id');
    }
}
