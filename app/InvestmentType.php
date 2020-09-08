<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvestmentType extends Model
{
    protected $table = "investment_types";

    protected $fillable =[
      'name',
      'description'
    ];

    public function investment_subtype(){
        return $this->hasMany(InvestmentSubType::class, 'invest_type_id');
    }

    public function investment_group(){
        return $this->hasMany(InvestmentGroup::class, 'invest_type_id');
    }

    public function invest_inst(){
        return $this->hasMany(InvestmentInstitution::class, 'invest_type_id');
    }

    public function scopeInvestmenttypeBond($query){
        return $query->where('name','bond')->value('id');
    }

    public function scopeInvestmenttypeDeposit($query){
        return $query->where('name','deposit')->value('id');
    }

    public function scopeInvestmenttypeShare($query){
        return $query->where('name','share')->value('id');
    }
}
