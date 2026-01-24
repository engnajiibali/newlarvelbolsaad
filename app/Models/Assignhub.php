<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignhub extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'assignhub';

    // Primary key
    protected $primaryKey = 'assignhubId';

    // No timestamps columns (created_at, updated_at) in your table
    public $timestamps = false;

    // Fillable fields (mass assignment)
    protected $fillable = [
        'assignhubId',
        'AskariId',
        'ItemId',
        'QoriNumber',
        'CreateDate',
        'UpdateDate',
        'FinishDate',
        'Status',
        'StoreId',
        'keydin_ID',
        'descrip',
        'sawirka',
    ];

    // If dates should be cast to Carbon instances
    protected $dates = [
        'CreateDate',
        'UpdateDate',
        'FinishDate',
    ];

    // Example relationships
    public function askari()
    {
        return $this->belongsTo(Askari::class, 'AskariId');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'ItemId');
    }

    public function store()
    {
        return $this->belongsTo(Store::class, 'StoreId');
    }

    public function keydin()
    {
        return $this->belongsTo(Keydin::class, 'keydin_ID');
    }
}
