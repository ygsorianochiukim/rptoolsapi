<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Diagrams extends Model
{
    protected $table = 'diagrams_information';
    protected $fillable = [
        'name',
        'description',
        'json_data',
        'line_category',
        'node_data',
        'is_shareable',
        's_bpartner_i_employee_id',
        'is_active',
        'created_by',
        'created_date',
        'sheet_url',
        'dependency',
        'dependency_value',
    ];
}
