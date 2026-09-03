<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Provinces extends Model
{
    protected $table = "provinces";

    public function regencies() {
        return $this->hasMany(Regencies::class);
    }
}
