<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class company extends Model
{
    use HasFactory;

    protected $table = 'companies';
    public $timestamps = true;


    protected $fillable = [
        'user_id',
        'name',
        'description',
        'address',
        'description',
        'phone',
        'email',
        'nip',
        'account_number',
        'area_id',
        'logo',
        'created_at',
        'updated_at',
    ];
}
