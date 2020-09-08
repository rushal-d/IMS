<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Share extends Model
{
    use SoftDeletes;
    protected $table = "shares";

    protected $fillable = [
        'fiscal_year_id',
        'trans_date',
        'trans_date_en',
        'institution_code',
        'investment_subtype_id',
        'purchase_kitta',
        'kitta_details',
        'rateperunit',
        'purchase_value',
        'total_amount',
        'closing_value',
        'created_by_id',
        'updated_by_id',
        'status',
        'invest_group_id',
        'reference_number',
        'parent_id',
        'share_type_id'
    ];

    public function fiscalyear()
    {
        return $this->belongsTo(FiscalYear::class, 'fiscal_year_id');
    }

    public function institute()
    {
        return $this->belongsTo(InvestmentInstitution::class, 'institution_id');
    }

    public function instituteByCode()
    {
        return $this->belongsTo(InvestmentInstitution::class, 'institution_code', 'institution_code');
    }

    public function investment_sector()
    {
        return $this->belongsTo(InvestmentSubType::class, 'investment_subtype_id');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function share_prices()
    {
        return $this->hasMany(ShareRecord::class, 'organization_code', 'institution_code');
    }

    public function dividend()
    {
        return $this->hasMany(Dividend::class, 'institution_code', 'institution_code');
    }

    public function share_price_last()
    {
        return $this->hasOne('\App\ShareRecord', 'organization_code', 'institution_code')->latest();
    }
}
