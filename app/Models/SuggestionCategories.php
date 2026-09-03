<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $code
 * @property string $name
 */

class SuggestionCategories extends Model
{
    protected $table = "suggestion_categories";
    protected $guarded = [];

    public $timestamps = false;

    public function suggestions() {
        return $this->hasMany(Suggestions::class);
    }
}
