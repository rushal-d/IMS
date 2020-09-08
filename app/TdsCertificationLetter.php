<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TdsCertificationLetter extends Model
{
    public $table = "tds_certification_letters";
    public $primaryKey = "id";

    public function fiscal_year()
    {
        return $this->belongsTo(FiscalYear::class, 'fiscal_year_id');
    }

    public function institute()
    {
        return $this->belongsTo(InvestmentInstitution::class, 'institution_id')->where('invest_type_id',2 );
    }
}
