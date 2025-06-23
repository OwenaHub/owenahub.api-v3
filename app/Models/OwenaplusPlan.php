<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OwenaplusPlan extends Model
{
    protected $fillable = [
        'name',
        'price',
        'interval',
        'description',
    ];
}
