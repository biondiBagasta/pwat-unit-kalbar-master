<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $code
 * @property string $name
 */

class UserRoles extends Model
{
    protected $table = "user_roles";
    protected $guarded = [];

    public $timestamps = false;

    public function users() {
        return $this->hasMany(User::class);
    }
}
