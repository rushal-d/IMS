<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SharePullDateRecord extends Model
{
    protected $fillable = [
        'record_date',
        'number_of_records'
    ];
}
