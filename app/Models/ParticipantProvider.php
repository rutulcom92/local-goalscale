<?php

namespace App\Models;

use App\BaseModel;

class ParticipantProvider extends BaseModel
{
    protected $table = 'participant_provider';

    protected $primarykey = 'id';


    protected $fillable = [
        'participant_id','provider_id','program_id','is_active','created_by','last_modified_by'
    ];

    //provider
    public function provider()
    {
        return $this->belongsTo('App\User', 'provider_id','id');
    }

    // participant
    public function participant()
    {
        return $this->belongsTo('App\User', 'participant_id', 'id');
    }
}
