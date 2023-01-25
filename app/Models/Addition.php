<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addition extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function taggable(){
        return $this->morphTo('taggable');
    }
}
