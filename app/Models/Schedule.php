<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $guarded = [];

    public function course()
    {
        $this->belongsTo(Course::class);
    }

    public function merchant()
    {
        $this->belongsTo(Merchant::class);
    }

    public function point()
    {
        $this->belongsTo(Point::class);
    }
}

