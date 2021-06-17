<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agreement extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'customer_id',
        'number',
        'duration',
        'start_price',
        'price_for_month',
        'created_at',
        'updated_at',
    ];
}
