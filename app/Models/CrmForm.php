<?php

  
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CrmForm extends Model
{
	use HasFactory;
    protected $table = 'crm_forms';
	
	
   
    protected $guarded = [];
	
}
