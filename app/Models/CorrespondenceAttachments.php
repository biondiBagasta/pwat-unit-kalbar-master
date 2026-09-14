<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $file_name
 * @property int $correspondence_id
 */

class CorrespondenceAttachments extends Model
{
    public function correspondence() {
        return $this->belongsTo(Correspondences::class, "correspondence_id");
    }
}
