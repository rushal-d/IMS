<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvestmentSubType extends Model
{
    protected  $table = "investment_sub_types";

    protected $fillable = [
      'name',
      'description',
      'code',
      'invest_type_id',
      'percentage'
    ];

    public function investment_type(){
        return $this->belongsTo(InvestmentType::class,'invest_type_id');
    }

    public function bond(){
        return $this->hasMany(Bond::class,'investment_subtype_id','id');
    }

    public function deposit(){
        return $this->hasMany(Deposit::class,'investment_subtype_id','id');
    }

    public function share(){
        return $this->hasMany(Share::class,'investment_subtype_id','id');
    }
}
