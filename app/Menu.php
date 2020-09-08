<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table="menus";
    protected $fillable=[
        'id',
        'menu_name',
        'display_name',
        'parent_id',
        'order',
        'icon',
    ];

    public function scopeRootMenu($query)
    {
        return $query->where('parent_id', null)->orderBy('order', 'asc');
    }

    public function scopeNextLevel($query, $id)
    {
        return $query->where('parent_id', $id)->orderBy('order', 'asc');
    }

    public function childPs()
    {
        return $this->hasMany('\App\Menu', 'parent_id', 'id');
    }
}
