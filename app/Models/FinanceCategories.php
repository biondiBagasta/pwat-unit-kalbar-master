<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $code
 * @property string $name
 */

class FinanceCategories extends Model
{
    protected $table = "finance_categories";
    protected $guarded = [];

    public $timestamps = false;

    public function finances() {
        return $this->hasMany(Finances::class);
    }
}
