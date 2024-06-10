<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrmBranding extends Model
{
    use HasFactory;
    protected $table = 'crm_brandings';
    protected $fillable = [
        'crm_id','crm_title','logo_url','footer_text','height_img','width_img','created_by'
    ];
}
