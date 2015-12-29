<?php

namespace CodeProject\Entities;

use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;

class ProjectFiles extends Model implements Transformable
{
    use TransformableTrait;

    protected $fillable = ['name','description','extension'];
    
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
    
    public function getFileName()
    {
        return $this->id.'.'.$this->extension;
    }

}
