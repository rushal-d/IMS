<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bond extends Model
{
    use SoftDeletes;
    protected $table= "bonds";

    protected $fillable = [
        'fiscal_year_id',
        'trans_date',
        'trans_date_en',
        'institution_id',
        'investment_subtype_id',
        'days',
        'mature_date',
        'mature_date_en',
        'rateperunit',
        'totalunit',
        'totalamount',
        'unitdetails',
        'interest_rate',
        'estimated_earning',
        'alert_days',
        'created_by_id',
        'updated_by_id',
        'status',
	    'invest_group_id',
        'reference_number',
        'interest_payment_method_id',
        'receipt_location_id',
        'organization_branch_id'
    ];

    public function fiscalyear(){
        return $this->belongsTo(FiscalYear::class,'fiscal_year_id');
    }

    public function institute(){
        return $this->belongsTo(InvestmentInstitution::class,'institution_id');
    }

    public function organization_branch(){
        return $this->belongsTo(OrganizationBranch::class, 'organization_branch_id');
    }

    public function bond_type(){
        return $this->belongsTo(InvestmentSubType::class,'investment_subtype_id');
    }

    public function created_by(){
        return $this->belongsTo(User::class,'created_by_id');
    }

}
