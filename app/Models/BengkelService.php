<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BengkelService extends Model
{
    protected $table = 'bengkel_services';

    protected $fillable = [
        'bengkel_id',
        'service_id',
    ];

    public function bengkel()
    {
        return $this->belongsTo(Bengkel::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
