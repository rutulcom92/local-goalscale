<?php

namespace App\Models;

use App\BaseModel;

class UserType extends BaseModel
{
    protected $table = 'users_types';

    protected $primarykey = 'id';

    protected $fillable = [
        'name','is_active','created_by','last_modified_by'
    ];
}
