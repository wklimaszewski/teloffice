<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class customer extends Model
{
    use HasFactory;

    protected $table = 'customers';
    public $timestamps = true;


    protected $fillable = [
        'user_id',
        'name',
        'surname',
        'address',
        'phone',
        'email',
        'pesel',
        'created_at',
        'updated_at',
    ];
}
