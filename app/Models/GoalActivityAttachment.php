<?php

namespace App\Models;
use App\BaseModel;
use Illuminate\Support\Facades\Storage;

class GoalActivityAttachment extends BaseModel
{

	/**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'goal_activity_attachments';

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
        'goal_activity_id', 'name', 'is_active', 'created_by', 'last_modified_by',
    ];

    // Goal Activity Owner
    public function owner(){
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    public function getDateCreatedAttribute() {
        return date('M d, Y', strtotime($this->created_at));
    }

    public function getNameAttribute() {        
        return !empty($this->attributes['name']) && file_exists(Storage::path(config('constants.goal_activity_storage_path').$this->attributes['name'])) ? url(Storage::url(config('constants.goal_activity_storage_path').$this->attributes['name'])) : asset('images/noImg.jpg'); 
    }

    public function getFilenameAttribute() {        
        return !empty($this->attributes['name']) ? $this->attributes['name'] : ''; 
    }

    public function getNamestorageAttribute() {        
        return !empty($this->attributes['name']) && file_exists(Storage::path(config('constants.goal_activity_storage_path').$this->attributes['name'])) ? Storage::path(config('constants.goal_activity_storage_path').$this->attributes['name']) : null; 
    }
}