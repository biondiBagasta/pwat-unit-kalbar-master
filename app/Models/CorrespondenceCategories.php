<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @property int $id
 * @property string $code
 * @property string $name
 */

class CorrespondenceCategories extends Model
{
    protected $table = "correspondence_categories";
    protected $guarded = [];

    public $timestamps = false;

    public function correspondences() {
        return $this->hasMany(Correspondences::class);
    }
}
