<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Army extends Model
{
    use HasFactory;

    // ✅ Use second database connection
    protected $connection = 'pgsql2';

    // Table name
    protected $table = 'army_army';

    protected $fillable = [
        'unique_id',
        'first_name',
        'middle_name',
        'last_name',
        'fourth_name',
        'mothers_name',
        'sex',
        'marital_status',
        'dob',
        'pob',
        'phone',
        'email',
        'color',
        'eye_color',
        'blood',
        'height',
        'cloth_size',
        'shoes_size',
        'picture',
        'status',
        'user_added_id',
        'date_added',
        'date_updated',
        'user_updated_id',
        'picture_size',
    ];

    protected $casts = [
        'dob' => 'date',
        'status' => 'boolean',
    ];

    public function recruitment()
    {
        return $this->hasOne(ArmyRecruitment::class, 'army_id');
    }
}
