<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $photo
 * @property int $event_id
 * @property int $uploaded_by
 */

class EventGalleries extends Model
{
    protected $table = "event_galleries";
    protected $guarded = [];

    public function event() {
        return $this->belongsTo(Events::class, "event_id");
    }

    public function member() {
        return $this->belongsTo(Members::class, "uploaded_by");
    }
}
