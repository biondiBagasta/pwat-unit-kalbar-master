<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $code
 * @property string $name
 */

class PostStatuses extends Model
{
    protected $table = "post_statuses";
    protected $guarded = [];

    public $timestamps = false;

    public function posts() {
        return $this->hasMany(Posts::class);
    }
}
