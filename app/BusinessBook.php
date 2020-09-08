<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessBook extends Model
{
    protected $fillable = [
        'fiscal_year_id',
        'date_en',
        'date',
        'amount',
        'notes',
        'organization_branch_id'
    ];

    public function fiscalyear()
    {
        return $this->belongsTo(FiscalYear::class, 'fiscal_year_id');
    }

    public function organizationbranch()
    {
        return $this->belongsTo(OrganizationBranch::class, 'organization_branch_id');
    }
}
