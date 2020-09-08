<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class InvestmentInstitution extends Model
{
    protected $table = "investment_institutions";

    protected $fillable = [
        'institution_name',
        'institution_code',
        'description',
        'invest_group_id',
        'invest_type_id', //bond ,deposit or share
        'invest_subtype_id',
        'remote_bank_code', //designed for premier
        'is_merger', //added after merger code implementation
        'merger_date', //added after merger code implementation
        'merger_display_id', //added after merger code implementation
        'is_listed',
    ];

    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope('sortByName', function (Builder $builder) {
            $builder->orderBy('institution_name', 'ASC');
        });

    }

    public function invest_group()
    {
        return $this->belongsTo(InvestmentGroup::class, 'invest_group_id');
    }

    public function invest_sector()
    {
        return $this->belongsTo(InvestmentSubType::class, 'invest_subtype_id');
    }

    public function invest_type()
    {
        return $this->belongsTo(InvestmentType::class, 'invest_type_id');
    }

    public function deposit()
    {
        return $this->hasMany(Deposit::class, 'institution_id');
    }

    public function shares()
    {
        return $this->hasMany(Share::class, 'institution_code', 'institution_code');
    }

    public function share_prices()
    {
        return $this->hasMany(ShareRecord::class, 'organization_code', 'institution_code');
    }

    public function latest_share_price()
    {
        return $this->hasOne('\App\ShareRecord', 'organization_code', 'institution_code')->latest();
    }

    public function mergedTo()
    {
        return $this->belongsTo(InvestmentInstitution::class, 'merger_display_id');
    }

    public function hasAquired()
    {
        return $this->hasOne(InvestmentInstitution::class, 'merger_display_id');
    }

    public function dividends()
    {
        return $this->hasMany(Dividend::class, 'institution_code', 'institution_code');
    }

    public function purchaseShares()
    {
        return $this->hasMany(Share::class, 'institution_code','institution_code')->where('share_type_id', '<>', 6);
    }

    public function saleShares()
    {
        return $this->hasMany(Share::class, 'institution_code','institution_code')->where('share_type_id', '=', 6);
    }

}
