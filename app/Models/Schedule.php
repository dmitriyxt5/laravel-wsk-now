<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'line', 'from_place_id', 'to_place_id', 'departure_time', 'arrival_time', 'distance', 'speed', 'status'];

    public function from_place_id() {
        return $this->belongsTo(Place::class, 'from_place_id');
    }

    public function to_place_id() {
        return $this->belongsTo(Place::class, 'to_place_id');
    }
}
