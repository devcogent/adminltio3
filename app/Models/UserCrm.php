<?php

  
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserCrm extends Model
{
	use HasFactory;
    protected $table = 'user_crm';
	
	
    protected $guarded = [];
	
	
}
