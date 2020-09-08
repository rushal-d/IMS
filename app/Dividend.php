<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Dividend extends Model
{
    protected $fillable = [
        'fiscal_year_id',
        'date',
        'date_np',
        'institution_code',
        'amount',
        'remarks',
    ];
}
