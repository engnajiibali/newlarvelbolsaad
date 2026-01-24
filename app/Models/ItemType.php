<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemType extends Model
{
    use HasFactory;

    protected $table = 'itemtype';
    protected $primaryKey = 'ItemTypeId';
    public $timestamps = false;

    protected $fillable = [
        'ItemTypeName',
        'WaaxId',
        'UserId',
        'itemtypeCreateDate',
        'FinishDate',
        'itemtypeUpdateDate'
    ];

     public function departments()
    {
        return $this->belongsTo(Department::class, 'WaaxId', 'id');
    }
}
