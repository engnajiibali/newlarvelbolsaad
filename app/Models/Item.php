<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'item';
    protected $primaryKey = 'ItemId';
    public $timestamps = false; // table-kan kuma jiro created_at / updated_at

    protected $fillable = [
        'ItemName',
        'UnitId',
        'ItemType',
        'CabirkaKeedinta',
        'CabirkaBixinta',
        'ItemCreateDate',
        'ItemUpdateDate',
        'WaaxId',
        'UserId',
        'Status',
        'FinishDate'
    ];

    // Example relations
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'UnitId', 'UnitId');
    }

    public function waax()
    {
        return $this->belongsTo(Department::class, 'WaaxId', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'UserId', 'id');
    }
        public function ItemType()
    {
        return $this->belongsTo(ItemType::class, 'ItemType', 'ItemTypeId');
    }
}
