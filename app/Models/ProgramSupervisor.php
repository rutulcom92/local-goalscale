<?php

namespace App\Models;

use App\BaseModel;

class ProgramSupervisor extends BaseModel
{

    protected $table = 'program_supervisor';

    protected $primaryKey = 'id';

    protected $fillable = [
        'program_id','supervisor_id','is_active','created_by','last_modified_by'
    ];

    // program
    public function program()
    {
        return $this->belongsTo('App\Models\Program', 'program_id','id');
    }

    // supervisor
    public function user()
    {
        return $this->belongsTo('App\User', 'supervisor_id','id');
    }

}