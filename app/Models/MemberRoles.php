<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $code
 * @property string $name
 */

class MemberRoles extends Model
{
    protected $table = "member_roles";
    protected $guarded = [];

    public $timestamps = false;

    public function members() {
        return $this->hasMany(Members::class);
    }
}
