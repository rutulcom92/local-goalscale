<?php

namespace App\Models;

use App\BaseModel;

class GoalScale extends BaseModel
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'goal_scale';

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
        'goal_id', 'value', 'name', 'description', 'is_active', 'created_by', 'last_modified_by',
    ];
}