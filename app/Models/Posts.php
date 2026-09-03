<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string $location
 * @property string $hastag
 * @property int $post_status_id
 * @property int $posted_by
 * @property int $post_category_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */

class Posts extends Model
{
    protected $table = "posts";
    protected $guarded = [];

    public function post_status() {
        return $this->belongsTo(PostStatuses::class, "post_status_id");
    }

    public function posted_by() {
        return $this->belongsTo(Members::class, "posted_by", "member");
    }

    public function post_category() {
        return $this->belongsTo(PostCategories::class, "post_category_id");
    }
}
