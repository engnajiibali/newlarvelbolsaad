<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'designation',
        'status',     // Active / Inactive
        'joining_date',
    ];

    /**
     * Scope for searching by name, email, or phone
     */
    public function scopeSearch($query, $term)
    {
        $term = "%$term%";
        return $query->where(function($q) use ($term) {
            $q->where('name', 'like', $term)
              ->orWhere('email', 'like', $term)
              ->orWhere('phone', 'like', $term);
        });
    }

    /**
     * Scope for filtering by designation
     */
    public function scopeDesignation($query, $designation)
    {
        if ($designation) {
            return $query->where('designation', $designation);
        }
        return $query;
    }

    /**
     * Scope for filtering by status
     */
    public function scopeStatus($query, $status)
    {
        if ($status) {
            return $query->where('status', $status);
        }
        return $query;
    }
}
