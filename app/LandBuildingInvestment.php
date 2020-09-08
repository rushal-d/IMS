<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LandBuildingInvestment extends Model
{
    protected $table = "land_building_investments";

    protected $fillable = [
        'fiscal_year_id',
        'site_location',
        'date_en',
        'date',
        'type',
        'amount',
        'remarks',
    ];

    public function fiscalyear()
    {
        return $this->belongsTo(FiscalYear::class, 'fiscal_year_id');
    }
}
