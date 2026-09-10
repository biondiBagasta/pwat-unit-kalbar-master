<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $full_name
 * @property string $address
 * @property string $phone_number
 * @property string $job
 * @property string $husband_name
 * @property string $husband_occupation
 * @property string|null $photo
 * @property string $regency_id
 * @property int $status
 * @property int $user_id
 * @property int $member_role_id
 * @property int $member_type_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */

class Members extends Model
{
    protected $table = "members";
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class, "user_id");
    }

    public function member_role() {
        return $this->belongsTo(MemberRoles::class, "member_role_id");
    }

    public function member_type() {
        return $this->belongsTo(MemberTypes::class, "member_type_id");
    }

    public function regency() {
        return $this->belongsTo(Regencies::class, "regency_id");
    }

    public function posts() {
        return $this->hasMany(Posts::class, "posted_by");
    }

    public function event_galleries() {
        return $this->hasMany(EventGalleries::class);
    }
}
