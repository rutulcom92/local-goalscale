<?php

namespace App\Models;
use App\BaseModel;

class GoalActivity extends BaseModel
{

	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'goal_activity';

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
        'goal_id', 'update_text', 'activity_ranking', 'participant_id', 'date_of_activity', 'parent_activity_id', 'is_active', 'created_by', 'last_modified_by',
    ];

    // Goal Activity Owner
    public function owner(){
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    // Goal
    public function goal(){
        return $this->belongsTo('App\Models\Goal', 'goal_id', 'id');
    }

    public function getDateCreatedAttribute() {
        return date('M d, Y', strtotime($this->created_at));
    }

    public function getDateOfActivityAttribute() {
        return date('m/d/y, h:i A', strtotime($this->attributes['date_of_activity']));
    }

     // Attachments
    public function attachments()
    {
        return $this->hasMany('App\Models\GoalActivityAttachment', 'goal_activity_id', 'id');
    }

    // Child Activities
    public function childActivities()
    {
        return $this->hasMany('App\Models\GoalActivity', 'parent_activity_id', 'id');
    }
}