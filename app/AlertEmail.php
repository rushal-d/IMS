<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlertEmail extends Model
{
    protected $fillable = [
        'name',
        'email',
        'mobile_number',
        'alert_days',
        'organization_branch_id',
    ];

    /*public function investmentType()
    {
        return $this->hasMany(AlertEmailInvestmentType::class, 'alert_email_id');
    }*/

    public function organizationBranch()
    {
        return $this->belongsTo('App\OrganizationBranch', 'organization_branch_id');
    }
}
