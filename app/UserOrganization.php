<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserOrganization extends Model
{
    protected $table = "user_organizations";

    protected $fillable = [
        'organization_name',
        'organization_code',
        'address',
        'contact_person',
        'effect_date',
        'effect_date_en',
        'valid_date',
        'valid_date_en',
        'status',
        'implement_merger',
        'placement_letter',
        'placement_letter2',
        'renew_letter',
        'withdraw_letter',
        'tds_certification_letter'
    ];
}
