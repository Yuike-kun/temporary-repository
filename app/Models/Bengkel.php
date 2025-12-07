<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bengkel extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'latitude',
        'longitude',
        'phone',
        'open_time',
        'close_time',
        'is_verified',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'open_time' => 'datetime:H:i',
        'close_time' => 'datetime:H:i',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function serviceRequests()
    {
        return $this->hasMany(ServiceRequest::class);
    }

    public function bengkelServices()
    {
        return $this->hasMany(BengkelService::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function getOperatingHoursAttribute()
    {
        return $this->open_time->format('H:i') . ' - ' . $this->close_time->format('H:i');
    }
}
