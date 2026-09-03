<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $amount
 * @property int $current_balance
 * @property int $finance_category_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */

class Finances extends Model
{
    protected $table = "finances";
    protected $guarded = [];

    public function finance_category() {
        return $this->belongsTo(FinanceCategories::class, "finance_category_id");
    }
}
