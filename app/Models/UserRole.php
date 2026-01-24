<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    use HasFactory;

    // Table name (optional if follows Laravel naming convention)
    protected $table = 'user_roles';

    // Primary key (optional if 'id')
    protected $primaryKey = 'id';

    // Fillable columns (mass assignable)
    protected $fillable = [
        'Role',
        'role_menu',
        'Read_permision',
        'Write_permision',
        'Edit_permision',
        'Delete_permision',
        'description',
        'isDefault'
    ];

    // Casts (optional, for booleans or JSON)
    protected $casts = [
        'Read_permision' => 'boolean',
        'Write_permision' => 'boolean',
        'Edit_permision' => 'boolean',
        'Delete_permision' => 'boolean',
        'isDefault' => 'boolean',
    ];

    // Timestamps are enabled by default, no need to define created_at/updated_at unless customized
}
