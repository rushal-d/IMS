<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvestmentRequestDocument extends Model
{
    protected $fillable = [
        'investment_request_id',
        'name',
    ];
}
