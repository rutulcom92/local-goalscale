<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use App\Scopes\StatusScope;
use App\Scopes\DeleteScope;

class BaseModel extends Model
{
    use SoftDeletes;

    public function getTableName() 
    {
        return $this->getTable();
    }

    /*
    * Auto-sets values on creation
    */
    protected static function boot()
    {
        parent::boot();
        // static::addGlobalScope(new StatusScope);
        static::addGlobalScope(new DeleteScope);
    }
}