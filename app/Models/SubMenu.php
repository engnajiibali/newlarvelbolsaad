<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    use HasFactory;

    protected $table = 'sub_menus';

   protected $fillable = [
        'name_sub_menu',
        'menu_id',
        'sub_menu_order',
        'hak_akses',
        'url',
        'content_before',
        'content_after',
        'icon',
        'title',
        'target',
    ];

    // A SubMenu belongs to a Menu
  public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
