<?php

namespace App\Models;

use App\BaseModel;

class TagGroup extends BaseModel
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tag_groups';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primarykey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'org_type_id', 'is_active', 'created_by', 'last_modified_by',
    ];
}