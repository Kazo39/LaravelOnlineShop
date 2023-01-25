<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Snack extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function additions(){
        return $this->morphMany(Addition::class, 'taggable');
    }
}
