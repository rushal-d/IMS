<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VersionChangeLog extends Model
{
    protected $fillable = [
        'version_code',
        'version_description',
    ];
}
