<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BankMerger extends Model
{
    protected $fillable = [
        'bank_name_after_merger',
        'bank_code_after_merger',
        'merger_date',
    ];

    public function mergeBankList()
    {
        return $this->hasMany(MergeBankList::class, 'bank_merger_id');
    }

    public function mergedToInstitution()
    {
        return $this->hasMany(InvestmentInstitution::class, 'institution_code','bank_code_after_merger');

    }
}
