<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keydin extends Model
{
    use HasFactory;

    protected $table = 'tbl_keydin'; // table name
    protected $primaryKey = 'keydin_ID'; // primary key

    public $timestamps = false; // jadwalkaaga ma laha created_at, updated_at

    protected $fillable = [
        'keydin_QID',
        'keydin_lambarka1',
        'Lahansho',
        'keydin_image1',
        'Xalada',
        'keydin_Xalada',
        'keydin_UserID',
        'keydin_WaxID',
        'keydin_CreateDate',
        'keydin_finishDate',
        'keydin_itemID',
        'storeID',
        'Calamaden',
        'kayimid',
        'Describ',
        'keydin_UpdateDate',
        'keydin_lambarka2',
        'FadhiId',
    ];

    public function FadhiIdRelation() { return $this->belongsTo(Department::class, 'FadhiId'); }
public function QaybtaHubkaRelation() { return $this->belongsTo(Item::class, 'keydin_itemID'); }

}
