<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class FiscalYear extends Model
{
    protected $table = "fiscal_years";

    protected $fillable =[
      'start_date',
      'start_date_en',
      'end_date',
      'end_date_en',
      'code',
      'status',
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('sortByDate', function (Builder $builder) {
            $builder->orderBy('start_date_en', 'ASC');
        });

    }
    public function bond(){
        return $this->hasMany(Bond::class,'fiscal_year_id','id');
    }

    public function deposit(){
        return $this->hasMany(Deposit::class,'fiscal_year_id','id');
    }

    public function share(){
        return $this->hasMany(Share::class,'fiscal_year_id','id');
    }
}
