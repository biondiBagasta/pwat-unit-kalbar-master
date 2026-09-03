<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $content
 * @property int $event_category_id
 * @property \Carbon\Carbon $start_date
 * @property \Carbon\Carbon $end_date
 * @property string $start_time
 * @property string $end_time
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */

class Events extends Model
{
    protected $table = "events";
    protected $guarded = [];

    public function event_galleries() {
        return $this->hasMany(EventGalleries::class);
    }

    public function event_category() {
        return $this->belongsTo(EventCategories::class, "event_category_id");
    }
}
