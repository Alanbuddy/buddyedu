<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'product_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
