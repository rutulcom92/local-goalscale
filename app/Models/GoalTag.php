<?php

namespace App\Models;

use App\BaseModel;

class GoalTag extends BaseModel
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'goal_tag';

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
        'tag_id','goal_id', 'is_active', 'created_by', 'last_modified_by',
    ];
}