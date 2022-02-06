<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = [];

    public function projects(){
        return $this->belongsToMany('App\Models\Project','projects_categories','category_id','project_id')->withTimestamps();
    }
}

