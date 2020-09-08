<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BonusShareHistory extends Model
{
    protected $fillable = [
        'date_en',
        'date',
        'no_of_kitta',
        'notes',
        'share_id',
    ];
}
