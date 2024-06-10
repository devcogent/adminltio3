<?php

  
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CrmFormField extends Model
{
	use HasFactory;
    protected $table = 'crm_fields';
	
	
   
    protected $guarded = [];
	
}
