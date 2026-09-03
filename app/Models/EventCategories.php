<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $code
 * @property string $name
 */

class EventCategories extends Model
{
    protected $table = "event_categories";
    protected $guarded = [];

    public $timestamps = false;

    public function Events() {
        return $this->hasMany(Events::class);
    }
}
