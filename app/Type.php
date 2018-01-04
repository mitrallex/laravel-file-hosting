<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    public $timestamps = false;

    public function files()
    {
        return $this->hasMany(File::class);
    }

    public function extensions()
    {
        return $this->hasMany(Extension::class);
    }
}
