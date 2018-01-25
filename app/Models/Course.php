<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Course extends Model
{
    use SoftDeletes;
    protected $guarded = [];


    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }

    public function tags()
    {
        return $this->belongsToMany('App\Models\Term', 'term_object', 'object_id', 'term_id')
            ->where('term_object.type', 'tag');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Term', 'category_id');
//        return $this->belongsToMany('App\Models\Term', 'term_object', 'object_id', 'term_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\Models\User');
    }

    public function teachers()
    {
        return $this->belongsToMany('App\Models\User')
            ->wherePivot('type', 'teacher');
    }

    public function students()
    {
        return $this->belongsToMany('App\Models\User')
            ->wherePivot('user_type', 'student')
            ->wherePivot('type', 'enroll');
    }

    //收藏课程的学员
    public function followers()
    {
        return $this->belongsToMany('App\Models\User')
            ->wherePivot('user_type', 'student')
            ->wherePivot('type', 'favorite');
    }

    public function orders()
    {
        return $this->hasMany('App\Models\Order', 'product_id');
    }

    //课程安排
    public function schedules()
    {
        return $this->hasMany('App\Models\Schedule');
    }

    public function merchants()
    {
        return $this->belongsToMany('App\Models\Merchant')->withPivot('is_batch');
    }

    public function markHasAddedByMerchant($merchant)
    {
        $this->added = $this->merchants->contains($merchant);
    }

    public function calculateRemain($merchant)
    {


        $this->remain = $this->merchants->contains($merchant);
    }
}
