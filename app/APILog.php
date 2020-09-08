<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class APILog extends Model
{
    protected $table = 'api_logs';
    public $timestamps = true;

    protected $fillable = [
        'data', 'status'
    ];
}
