<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UploadedDocument extends Model
{
    protected $table = 'uploaded_documents';
    protected $fillable = [
        'deposit_id',
        'name'
    ];
}
