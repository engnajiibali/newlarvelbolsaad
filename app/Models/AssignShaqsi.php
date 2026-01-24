<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignShaqsi extends Model
{
    use HasFactory;

    // Magaca table-ka haddii uusan la mid ahayn magaca model-ka oo plural ah
    protected $table = 'assignshaqsi';

    // Primary key
    protected $primaryKey = 'id';

    // Haddii primary key uu auto-increment yahay (default waa true)
    public $incrementing = true;

    // Haddii timestamps ay jiraan (created_at, updated_at), laakiin table-kaagu wuxuu leeyahay magacyo custom
    public $timestamps = false;

    // Mass assignable fields
    protected $fillable = [
        'shaqiid',
        'ItemId',
        'QoriNumber',
        'CreateDate',
        'UpdateDate',
        'FinishDate',
        'Status',
        'keydin_ID',
        'descrip',
    ];
    public function shaqsi()
    {
        // Each AssignShaqsi belongs to one Shaqsiyaadka
        return $this->belongsTo(Shaqsiyaadka::class, 'shaqiid', 'ShaqsiyaadkaId');
    }

    public function item()
    {
        // If you have Item model
        return $this->belongsTo(Item::class, 'ItemId', 'ItemId');
    }
    // Haddii aad rabto, waxaad ku dari kartaa accessor/mutator ama scope-yada halkan
}
