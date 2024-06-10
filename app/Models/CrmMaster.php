<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CrmMaster extends Model
{
	use HasFactory;
    protected $table = 'crm_masters';


    protected $fillable = [
        'id','crm_name', 'crm_type', 'created_by','updated_at'
    ];


}
