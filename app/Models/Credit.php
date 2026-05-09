<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Credit_payment;
use Illuminate\Database\Eloquent\Relations\HasMany;
class Credit extends Model
{
    public function payments(): HasMany
        {
            // Adjust 'credit_id' if your foreign key is named differently
            return $this->hasMany(Credit_payment::class, 'credit_id');
        }
}
