<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $code
 * @property string $name
 */

class PostCategories extends Model
{
    protected $table = "post_categories";
    protected $guarded = [];

    public $timestamps = false;

    public function posts() {
        return $this->hasMany(Posts::class);
    }
}
