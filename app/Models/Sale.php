<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Sale extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}