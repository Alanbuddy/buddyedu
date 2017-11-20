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

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}

