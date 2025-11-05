<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function bengkels()
    {
        return $this->belongsToMany(Bengkel::class, 'bengkel_services');
    }
}
