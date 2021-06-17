<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class db_invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'agreement_id',
        'number',
        'price',
        'confirm'
    ];
}
