<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zone extends Model
{
    
    use SoftDeletes;

    /**
     * Save item author
     */
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            $model->user_id = auth()->check()?auth()->user()->id:null;
        });
    }
    
    /**
     * Get the user that adds the zone.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * Get the orders that adds the zone.
     */
    public function user()
    {
        return $this->belongsTo(Order::class);
    }
}
