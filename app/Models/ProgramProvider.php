<?php

namespace App\Models;

use App\BaseModel;

class ProgramProvider extends BaseModel
{

    protected $table = 'program_provider';

    protected $primaryKey = 'id';

    protected $fillable = [
        'program_id','provider_id','created_by','last_modified_by'
    ];

    // program
    public function program()
    {
        return $this->belongsTo('App\Models\Program', 'program_id','id');
    }

    // supervisor
    public function user()
    {
        return $this->belongsTo('App\User', 'provider_id','id');
    }

}