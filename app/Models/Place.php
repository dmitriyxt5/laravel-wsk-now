<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    protected $fillable = ['x', 'y', 'name', 'type', 'latitude', 'longitude', 'image', 'open_time', 'close_time', 'image_path', 'description'];
    use HasFactory;
}
