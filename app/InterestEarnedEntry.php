<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InterestEarnedEntry extends Model
{
    protected $fillable = [
        'date_en',
        'date',
        'amount',
        'tax',
        'total_amount',
        'deposit_id',
        'notes',
    ];
}
