<?php

namespace App\Traits;

trait IsPublic
{
    public function scopePublic($query)
    {
        return $query->where('is_public', true);
    }
}
