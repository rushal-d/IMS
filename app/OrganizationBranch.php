<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class OrganizationBranch extends Model
{
    protected $fillable = [
        'branch_name',
        'branch_code',
        'description'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('orderByName', function (Builder $builder) {
            $builder->orderBy('branch_name');
        });
    }

    public function depositBankB1()
    {
        return $this->hasMany(Deposit::class, 'organization_branch_id', 'id');
    }

}
