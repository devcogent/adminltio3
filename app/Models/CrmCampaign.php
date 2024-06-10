<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrmCampaign extends Model
{
    use HasFactory;
    protected $table = 'crm_campaigns';
    protected $fillable = [
        'crm_type', 'domain_name', 'q_name', 'enter_parameters', 'api_parameters',  'camp_name', 'token_name', 'skill_name', 'date_format', 'list_name','api_url', 'crm_id','depend_status', 'dropdown_id', 'option_id', 'created_by'
    ];


}
