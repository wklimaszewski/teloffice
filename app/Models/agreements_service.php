<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agreements_service extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'agreement_id',
        'service_id',
    ];
}
