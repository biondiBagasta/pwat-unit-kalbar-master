<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $total
*/
class Balances extends Model
{
    protected $table = 'balances';
    protected $guarded = [];
}
