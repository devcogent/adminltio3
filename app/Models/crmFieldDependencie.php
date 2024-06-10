<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class crmFieldDependencie extends Model
{
    use HasFactory;
    protected $table = 'crm_field_dependencies';
    protected $fillable = [
        'crm_id', 'dropdown_id_from', 'dropdown_id', 'option_id','created_by'
    ];
}
