<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MergeBankList extends Model
{
    protected $fillable = [
        'bank_merger_id',
        'bank_name',
        'bank_code',
    ];

    public function institution()
    {
        return $this->belongsTo(InvestmentInstitution::class, 'bank_merger_id');
    }
}
