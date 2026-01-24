<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model {
    use HasFactory;

    protected $fillable = ['country_id', 'name', 'latitude', 'longitude', 'image'];

    public function country() {
        return $this->belongsTo(Country::class);
    }

    public function regions() {
        return $this->hasMany(Region::class);
    }
}
