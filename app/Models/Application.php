<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'city',
        'address',
        'budget',
        'phone_whatsapp',
        'comments',
        'status'
    ];
}
