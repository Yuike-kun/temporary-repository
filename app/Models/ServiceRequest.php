<?php

namespace App\Models;

use App\Enum\ServiceRequestStatus;
use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    protected $fillable = [
        'bengkel_id',
        'user_id',
        'description',
        'latitude',
        'longitude',
        'status',
    ];

    protected $casts = [
        'status' => ServiceRequestStatus::class,
    ];

    public function bengkel()
    {
        return $this->belongsTo(Bengkel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
