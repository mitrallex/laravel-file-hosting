<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Extension extends Model
{
    public $timestamps = false;

    public function type()
    {
        return $this->belongsTo(Type::class);
    }
}
