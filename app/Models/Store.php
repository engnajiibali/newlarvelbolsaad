<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    // Waxaan u sheegaynaa Laravel in table-ka uu yahay 'storada' maadaama uusan ahayn 'stores'
    protected $table = 'storada';

    // Haddii Primary Key-gaaga uu yahay 'StoradaId' halkii uu ka ahaan lahaa 'id'
    protected $primaryKey = 'StoradaId';

    // Haddii database-kaaga uusan lahayn 'created_at' iyo 'updated_at' ee uu leeyahay kuwaan hoose:
    const CREATED_AT = 'StoreCreateDate';
    const UPDATED_AT = 'StoreUpdateDate';

    protected $fillable = [
        'StoreName', 
        'FadhiId', 
        'UserId', 
        'FinishDate', 
        'Status'
    ];

    // Xiriirka uu la leeyahay Department (Fadhiga)
    public function department()
    {
        // Waxaan ku xiraynaa FadhiId oo ah foreign key-ga ku jira table-ka storada
        return $this->belongsTo(Department::class, 'FadhiId', 'id');
    }
}