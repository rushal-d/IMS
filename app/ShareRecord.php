<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ShareRecord extends Model
{
    protected $fillable=[
      'organization_name',
      'organization_code',
      'closing_value',
      'date',
      'date_np',
    ];
}
