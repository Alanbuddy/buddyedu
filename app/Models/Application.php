<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Application extends Model
{
    use softDeletes;
    protected $guarded = [];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function scopeWithdrawType($query)
    {
        return $query->where('type', 'withdraw');
    }

    public function scopeCourseType($query)
    {
        return $query->where('type', 'course');
    }

    public function scopeApproved($query)
    {
        return $query->where('type', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('type', 'rejected');
    }
}
