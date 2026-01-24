<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Askari extends Model
{
    protected $table = 'askarta';   // 👈 FIXED
    protected $primaryKey = 'AskariId';
    public $incrementing = true;
    protected $keyType = 'int';

    const CREATED_AT = 'AskariCreateDate';
    const UPDATED_AT = 'AskariUpdateDate';

    public $timestamps = true;

    protected $fillable = [
        'LamabrkaCiidanka',
        'Darajada',
        'MagacaQofka',
        'Gender',
        'TalefanLambar',
        'JobTitle',
        'AskariAddress',
        'AskariImage',
        'FadhiId',
        'FinishDate',
        'Status',
        'Payrol',
        'Shirkadaha',
        'Accon',
        'AP',
    ];

    protected $casts = [
        'AskariId' => 'integer',
        'FadhiId' => 'integer',
        'AskariCreateDate' => 'datetime',
        'AskariUpdateDate' => 'datetime',
        'FinishDate' => 'datetime',
        'Status' => 'boolean',
        
    ];

    public function Department()
    {
        return $this->belongsTo(Department::class, 'FadhiId', 'id');
    }

    public function getAskariImageUrlAttribute()
    {
        if (!$this->AskariImage) {
            return asset('default.png'); // fallback image
        }
        return asset('storage/' . ltrim($this->AskariImage, '/'));
    }
}
