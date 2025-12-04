<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shareable extends Model
{
    protected $table = 'shareables';
    protected $fillable = [
        'diagram_id',
        'user_id',
        'is_active',
        'created_by',
        'created_date',
    ];
}
