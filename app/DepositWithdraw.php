<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DepositWithdraw extends Model
{
    protected $table = "deposit_withdraws";

    protected $fillable = [
        'fiscal_year_id',
        'withdrawdate',
        'withdrawdate_en',
        'withdraw_amount',
        'deposit_id',
        'notes',
        'withdraw_bank_id',
        'withdraw_bank_branch_id',
        'withdraw_account_no',
        'approved_by',
    ];

    public function deposit()
    {
        return $this->belongsTo(Deposit::class, 'deposit_id');
    }
    public function approvalUser()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
    public function withdrawbank(){
        return $this->belongsTo(InvestmentInstitution::class, 'withdraw_bank_id');
    }

    public function withdrawbranch(){
        return $this->belongsTo(BankBranch::class, 'withdraw_bank_branch_id');
    }

    public function scopeWithAndWhereHas($query, $relation, $constraint)
    {
        return $query->whereHas($relation, $constraint)
            ->with([$relation => $constraint]);
    }
}
