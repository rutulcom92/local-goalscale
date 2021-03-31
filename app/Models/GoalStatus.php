<?php

namespace App\Models;

use App\BaseModel;

class GoalStatus extends BaseModel
{
	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'goal_status';

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
        'name', 'is_active', 'created_by', 'last_modified_by',
    ];
}