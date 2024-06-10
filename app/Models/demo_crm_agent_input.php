<?php

            namespace App\Models;
            use Illuminate\Database\Eloquent\Factories\HasFactory;
            use Illuminate\Database\Eloquent\Model;
            use ESolution\DBEncryption\Traits\EncryptedAttribute;

            class demo_crm_agent_input extends Model
            {
                use HasFactory,EncryptedAttribute;
                protected $table= 'demo_crm_agent_input';
                protected $fillable = ["status","remarks","follow_up_date","follow_up_time",'created_by','from_data_id','tid','lead_status'];
                protected $encryptable = ["status","remarks","follow_up_date","follow_up_time"];
            }