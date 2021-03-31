<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramOrgAdmin extends Model
{

    protected $table = 'program_org_admin';

    protected $primaryKey = 'id';

    protected $fillable = [
        'program_id','admin_id','created_by','last_modified_by'
    ];

    // program
    public function program()
    {
        return $this->belongsTo('App\Models\Program', 'program_id','id');
    }

    // supervisor
    public function user()
    {
        return $this->belongsTo('App\User', 'admin_id','id');
    }

}