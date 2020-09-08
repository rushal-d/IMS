<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    /**
     * @var string
     */
    protected $table = "user_types";

    /**
     * @var array
     */
    protected $fillable =[
      'staff_id',
      'staff_post',
      'status',
      'user_id'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
