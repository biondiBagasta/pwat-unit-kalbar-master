<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $content
 * @property int $member_id
 * @property int $suggestion_category_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */

class Suggestions extends Model
{
    protected $table = "suggestions";
    protected $guarded = [];

    public function suggestion_category() {
        return $this->belongsTo(SuggestionCategories::class, "suggestion_category_id");
    }
}
