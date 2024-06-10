<?php

            namespace App\Models;
            use Illuminate\Database\Eloquent\Factories\HasFactory;
            use Illuminate\Database\Eloquent\Model;
            use ESolution\DBEncryption\Traits\EncryptedAttribute;

            class demo_crm_client_data extends Model
            {
                use HasFactory,EncryptedAttribute;
                protected $table= 'demo_crm_client_data';
                protected $fillable = ["name","mobile","email","address","follow_up_date","follow_up_date_time",'created_by','from_data_id','tid','lead_status'];
                protected $encryptable = ["name","mobile","email","address","follow_up_date","follow_up_date_time"];
            }