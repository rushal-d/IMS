<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TechnicalReserve extends Model
{
    protected $table = 'technical_reserves';
    protected $fillable = [
        'fiscal_year_id',
        'approved_date_en',
        'approved_date',
        'amount',
    ];

    public function fiscalYear()
    {
        return $this->belongsTo('\App\FiscalYear', 'fiscal_year_id');
    }
}
