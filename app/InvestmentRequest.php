<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvestmentRequest extends Model
{
    protected $fillable = [
        'request_date_en',
        'request_date',
        'institution_id',
        'days',
        'interest_payment_method',
        'deposit_amount',
        'interest_rate',
        'branch_id',
        'organization_branch_id',
        'staff_id',
        'status',
        'created_by_id',
        'updated_by_id',
        'remarks',
    ];

    public function institution()
    {
        return $this->belongsTo(InvestmentInstitution::class, 'institution_id')->where('invest_type_id', 2);
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    public function branch()
    {
        return $this->belongsTo(BankBranch::class, 'branch_id');
    }

    public function organization_branch()
    {
        return $this->belongsTo(OrganizationBranch::class, 'organization_branch_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function deposit()
    {
        return $this->hasOne(Deposit::class, 'investment_request_id')->withoutGlobalScope('is_pending');
    }

    public function documents(){
        return $this->hasMany(InvestmentRequestDocument::class,'investment_request_id');
    }

}
