<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShareMarketToday extends Model
{
    protected  $table = "shares_today";

    protected $fillable =[
      'organization_name',
      'closing_value',
      'code',
    ];
}
