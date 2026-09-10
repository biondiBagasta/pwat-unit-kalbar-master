<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $image
 * @property int $show_order
*/
class Carousels extends Model
{
    public $timestamps = false;

    protected $table = "carousels";
    protected $guarded = [];
}
