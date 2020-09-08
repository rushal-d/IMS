<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AgriTourWaterInvestment extends Model
{
    protected $table = "agri_tour_water_investments";

    protected $fillable = [
        'fiscal_year_id',
        'investment_area',
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
