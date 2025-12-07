<?php

namespace App\Enum;

enum ServiceRequestStatus: string
{
    case pending = 'pending';
    case accepted = 'accepted';
    case otw = 'otw';
    case completed = 'completed';
    case cancelled = 'cancelled';
}
