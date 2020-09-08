<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmailSetup extends Model
{
    protected $fillable=[
        'driver',
        'host',
        'port',
        'from_address',
        'from_name',
        'encryption',
        'username',
        'password',
    ];
}
