<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Point extends Model
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    
    /**
     * The "type" of the auto-incrementing ID.
     *
     * @var string
     */
    protected $keyType = 'string';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lng', 'lat', 'alt',
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if ( empty( $model->{$model->getKeyName()} ) ) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
            if( empty( $model->user_id ) && auth()->check() ) {
                $model->user_id = auth()->user()->id;
            }
        });
    }

    /**
     * Get the clubs what owns the point.
     */
    public function clubs()
    {
        return $this->hasMany(Club::class);
    }
    
    /**
     * The orders that belong to the point.
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_point')->using(OrderPoint::class);
    }
    
    /**
     * The travels that belong to the point.
     */
    public function travels()
    {
        return $this->belongsToMany(Travel::class, 'travel_point')->using(TravelPoint::class);
    }

    /**
     * Get the user what creates the point.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    /**
     * The users that belong to the point.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_point')->using(UserPoint::class);
    }
}
