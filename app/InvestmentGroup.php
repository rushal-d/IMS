<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvestmentGroup extends Model
{
    protected $table = "investment_groups";

    protected $fillable = [
        'group_name',
        'group_code',
        'parent_id',
        'percentage',
        'description',
        'invest_type_id',
        'enable',
    ];

    public function invest_type()
    {
        return $this->belongsTo(InvestmentType::class, 'invest_type_id');
    }

    public function invest_inst()
    {
        return $this->hasMany(InvestmentInstitution::class, 'invest_group_id');
    }

    public function parent()
    {
        return $this->belongsTo(InvestmentGroup::class, 'parent_id', 'id');
    }

    public function child()
    {
        return $this->hasMany(InvestmentGroup::class, 'parent_id', 'id');
    }

    public function scopeisGA_1($query)
    {
        return $query->where('group_name', 'GA-1 Group')->value('id');
    }

    public function scopeisGA_2($query)
    {
        return $query->where('group_name', 'GA-2 Group')->value('id');
    }

    public function scopeisGA_3($query)
    {
        return $query->where('group_name', 'GA-3 Group')->value('id');
    }

    public function scopeisGA_4($query)
    {
        return $query->where('group_name', 'GA-4 Group')->value('id');
    }

    public function scopeisGA_5($query)
    {
        return $query->where('group_name', 'GA-5 Group')->value('id');
    }

    public function scopeisKHA_1($query)
    {
        return $query->where('group_name', 'KHA-1 Group')->value('id');
    }

    public function scopeisKHA_2($query)
    {
        return $query->where('group_name', 'KHA-2 Group')->value('id');
    }

    public function scopeisKHA_3($query)
    {
        return $query->where('group_name', 'KHA-3 Group')->value('id');
    }


    public function bond()
    {
        return $this->hasMany(Bond::class, 'invest_group_id', 'id');
    }

    public function deposit()
    {
        return $this->hasMany(Deposit::class, 'invest_group_id', 'id');
    }

    public function share()
    {
        return $this->hasMany(Share::class, 'invest_group_id', 'id');
    }
}
