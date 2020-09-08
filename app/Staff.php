<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = [
        'name', 'organization_branch_id', 'position', 'note'
    ];

    public function organizationBranch()
    {
        return $this->hasOne('\App\OrganizationBranch','id','organization_branch_id');
    }
}
