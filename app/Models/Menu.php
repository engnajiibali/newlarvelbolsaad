<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menus';

    protected $fillable = [
        'menu_name',
        'menu_order',
        'icon',
        'status',
    ];

    // A Menu has many SubMenus
    public function subMenus()
    {
        return $this->hasMany(SubMenu::class, 'menu_id', 'id')
                    ->orderBy('sub_menu_order', 'asc');
    }
}
