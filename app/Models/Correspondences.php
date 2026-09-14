<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * @property int $id
 * @property int $correspondence_category_id
 * @property string $letter_number
 * @property string $subject
 * @property string $content
 * @property int $sender
 * @property int $recepient
 * @property \Carbon\Carbon $letter_date
 * @property string $signature
 * @property int $readed
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Correspondences extends Model
{
    protected $table = "correspondences";
    protected $guarded = [];

    public function correspondence_category() {
        return $this->belongsTo(CorrespondenceCategories::class);
    }

    public function sender_data() {
        return $this->belongsTo(Members::class, "sender", "sender_data");
    }

    public function recepient_data() {
        return $this->belongsTo(Members::class, "recepient", "recepient_data");
    }

    public function correspondence_attachments() {
        return $this->hasMany(CorrespondenceAttachments::class);
    }
}
