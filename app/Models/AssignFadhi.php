<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignFadhi extends Model
{
    use HasFactory;

    // Table name
    protected $table = 'assignfadhi';

    // Primary key
    protected $primaryKey = 'assignfadhiId';

    // Disable timestamps if your table does not use created_at/updated_at
    public $timestamps = false;

    // Fillable fields
    protected $fillable = [
        'AskariId',
        'FadhiId',
        'assignFadhiDate',
        'AssignFadhiUpdateDate',
        'Status',
    ];

    // Relationship with Askari
    public function askari()
    {
        return $this->belongsTo(Askari::class, 'AskariId', 'AskariId');
    }

    // Relationship with Fadhi
    public function fadhi()
    {
        return $this->belongsTo(Department::class, 'FadhiId', 'id');
    }
}
