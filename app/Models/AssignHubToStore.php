<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignHubToStore extends Model
{
    use HasFactory;

    // Table-ka la isticmaalo
    protected $table = 'tbl_assine_hub_to_store';

    // Primary key
    protected $primaryKey = 'ashtst_ID';

    // Timestamp-ka (haddii table-ka uusan lahayn created_at / updated_at)
    public $timestamps = false;

    // Columns la mass-assignable
    protected $fillable = [
        'ashtst_keID',
        'StoreID',
        'QoriNum',
        'CreateDate',
        'ashtst_Status',
        'ashtst_FinishDate',
        'ashtst_keID'
    ];

    // RELATIONS

    // Relation la leh Keydin (hubka)
    public function keydin()
    {
        return $this->belongsTo(Keydin::class, 'ashtst_keID', 'keydin_ID');
    }
public function FadhiIdRelation() { return $this->belongsTo(Department::class, 'FadhiId'); }
    // Relation la leh Store
    public function store()
    {
        return $this->belongsTo(Store::class, 'StoreID', 'StoradaId'); // Halkan 'id' ku bedel primary key-ga store-kaaga
    }
}
