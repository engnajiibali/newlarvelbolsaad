<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $table = 'unit';      // table-ka saxda ah
    protected $primaryKey = 'UnitId';
    public $incrementing = true;
    protected $keyType = 'int';

    // Timestamps-ka caadiga ah (created_at, updated_at) lama isticmaalin,
    // markaa waxaan ku beddelaynaa column-yadaada gaarka ah:
    const CREATED_AT = 'UnitCreateDate';
    const UPDATED_AT = 'UnitUpdateDate';

    public $timestamps = true;

    protected $fillable = [
        'UnitName',
        'Status',
        'UserId',
        'FinishDate',
    ];

    protected $casts = [
        'UnitId'          => 'integer',
        'UserId'          => 'integer',
        'UnitCreateDate'  => 'datetime',
        'UnitUpdateDate'  => 'datetime',
        'FinishDate'      => 'datetime',
        'Status'          => 'boolean',
    ];

    // Example: haddii uu jiro relation user table
    public function user()
    {
        return $this->belongsTo(User::class, 'UserId', 'id');
    }
}
