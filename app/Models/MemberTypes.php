<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $code
 * @property string $name
 */

class MemberTypes extends Model
{
    protected $table = "member_types";
    protected $guarded = [];

    public $timestamps = false;

    public function members() {
        return $this->hasMany(Members::class);
    }
}
