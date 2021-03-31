<?php

namespace App\Models;

use App\BaseModel;

class SiteContent extends BaseModel
{
    protected $table = 'site_content';

    protected $primaryKey = 'id';

    protected $fillable = [
        'reference_key','content', 'is_active','created_by','last_modified_by'
    ];
}