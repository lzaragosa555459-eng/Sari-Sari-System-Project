<?php

namespace App\Models;

use App\Http\Controllers\SaleController;
use Illuminate\Database\Eloquent\Model;
use App\Models\Credit_payment;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Sale;

class Credit extends Model
{
    protected $table = 'credits';

    public function sale()
    {
        return $this->belongsTo(Sale::class, 'sale_id');
    }

    public function payments()
    {
        return $this->hasMany(Credit_payment::class, 'credit_id');
    }
}