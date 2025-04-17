<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmartLight extends Model
{
    protected $fillable = ['name', 'status', 'location', 'brightness'];
}
