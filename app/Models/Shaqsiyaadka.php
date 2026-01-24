<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shaqsiyaadka extends Model
{
    use HasFactory;

    protected $table = 'shaqsiyadka';
    protected $primaryKey = 'ShaqsiyaadkaId';
    public $timestamps = false;

    protected $fillable = [
        'magacaShaqsiga',
        'Jagada',
        'CreateDate',
        'SawirkaShaqsiga',
        'KaarkaShaqsiga',
        'TalefanLambarka',
        'Addresska',
        'Description',
        'FadhiId',
        'FinishDate',
    ];

        public function assignShaqsiRecords()
    {
        // Shaqsiyaadka can have many AssignShaqsi records
        return $this->hasMany(AssignShaqsi::class, 'shaqiid', 'ShaqsiyaadkaId');
    }
}
