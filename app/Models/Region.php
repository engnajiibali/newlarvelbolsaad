<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model {
    use HasFactory;

    protected $fillable = ['state_id', 'name', 'latitude', 'longitude', 'image'];

    public function state() {
        return $this->belongsTo(State::class);
    }

    public function districts() {
        return $this->hasMany(District::class);
    }
}
