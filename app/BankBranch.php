<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class BankBranch extends Model
{
    protected $table = "bank_branches";

    protected $fillable = [
        'branch_name',
        'description',
    ];

    public $timestamps = true;

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('orderByName', function (Builder $builder) {
            $builder->orderBy('branch_name');
        });
    }

    public function depositBankB1()
    {
        return $this->hasMany(Deposit::class, 'branch_id', 'id');
    }

    public function depositBankB2()
    {
        return $this->hasMany(Deposit::class, 'bank_branch_id', 'id');
    }

}
