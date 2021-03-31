<?php

namespace App\Models;

use App\BaseModel;

class Tag extends BaseModel
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tags';

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
        'tag', 'tag_type_id', 'tag_group_id', 'org_type_id', 'is_active', 'created_by', 'last_modified_by',
    ];

    // Group
    public function group()
    {
        return $this->belongsTo('App\Models\TagGroup', 'tag_group_id', 'id')->withDefault(['name' => '']);
    }
}