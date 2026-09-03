<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regencies extends Model
{
    protected $table = "regencies";

    public function province() {
        return $this->belongsTo(Provinces::class, "province_id");
    }

    public function members() {
        return $this->hasMany(Members::class);
    }
}
