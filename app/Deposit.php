<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deposit extends Model
{
    use SoftDeletes;

    protected $table = "deposits";

    protected $fillable = [
        'fiscal_year_id',
        'trans_date',
        'trans_date_en',
        'institution_id',
        'investment_subtype_id',
        'days',
        'mature_date',
        'mature_date_en',
        'document_no',
        'interest_payment_method',
        'loan_or_premature',
        'deposit_amount',
        'interest_rate',
        'estimated_earning',
        'alert_days',
        'branch_id',
        'created_by_id',
        'updated_by_id',
        'status',
        'expiry_days',
        'bank_id',
        'bank_branch_id',
        'accountnumber',
        'invest_group_id',
        'reference_number',
        'earmarked',
        'parent_id',
        'organization_branch_id',
        'cheque_no',
        'notes',
        'receipt_no',
        'staff_id',
        'cheque_date',
        'cheque_date_np',
        'narration',
        'voucher_number',
        'is_pending',
        'credit_date',
        'credit_date_np',
        'account_head',
        'fd_document_current_location',
        'investment_request_id',
        'deleted_at',
        'deleted_by_id',
        'approved_by',
        'approved_date',
        'next_interest_rate',
        'debit_bank_id',
        'debit_account_number',
        'cheque_bank_id',
        'debit_branch_id',
        'bank_merger_id',
    ];


    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('is_pending', function (Builder $builder) {
            $builder->where('is_pending', '=', 0);
        });
    }

    public function fiscalyear()
    {
        return $this->belongsTo(FiscalYear::class, 'fiscal_year_id');
    }

    public function institute()
    {
        return $this->belongsTo(InvestmentInstitution::class, 'institution_id')->where('invest_type_id', 2);
    }

    public function bank()
    {
        return $this->belongsTo(InvestmentInstitution::class, 'bank_id');
    }

    public function cheque_bank()
    {
        return $this->belongsTo(InvestmentInstitution::class, 'cheque_bank_id');
    }

    public function debit_bank()
    {
        return $this->belongsTo(InvestmentInstitution::class, 'debit_bank_id');
    }

    public function deposit_type()
    {
        return $this->belongsTo(InvestmentSubType::class, 'investment_subtype_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function updated_by()
    {
        return $this->belongsTo(User::class, 'updated_by_id');
    }

    public function approvalUser()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function branch()
    {
        return $this->belongsTo(BankBranch::class, 'branch_id');
    }

    public function bank_branch()
    {
        return $this->belongsTo(BankBranch::class, 'bank_branch_id');
    }

    public function debit_branch()
    {
        return $this->belongsTo(BankBranch::class, 'debit_branch_id');
    }

    public function organization_branch()
    {
        return $this->belongsTo(OrganizationBranch::class, 'organization_branch_id');
    }

    public function withdraw()
    {
        return $this->hasOne(DepositWithdraw::class, 'deposit_id', 'id');
    }

    public function actualEarning()
    {
        return $this->hasMany(InterestEarnedEntry::class, 'deposit_id', 'id');
    }

    public function child()
    {
        return $this->hasOne(Deposit::class, 'parent_id');
    }

    public function investmentRequest()
    {
        return $this->belongsTo(InvestmentRequest::class, 'investment_request_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function scopeWithAndWhereHas($query, $relation, $constraint)
    {
        return $query->whereHas($relation, $constraint)
            ->with([$relation => $constraint]);
    }

    public function parent()
    {
        return $this->belongsTo(Deposit::class, 'parent_id', 'id');
    }

    public function parentWithoutGlobalScope()
    {
        return $this->belongsTo(Deposit::class, 'parent_id', 'id')->withoutGlobalScope('is_pending');
    }

    public function childWithoutGlobalScope()
    {
        return $this->hasOne(Deposit::class, 'parent_id')->withoutGlobalScope('is_pending');
    }

    public function bankMerger()
    {
        return $this->belongsTo(BankMerger::class, 'bank_merger_id');
    }

}
