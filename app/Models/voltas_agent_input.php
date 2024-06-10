<?php

            namespace App\Models;
            use Illuminate\Database\Eloquent\Factories\HasFactory;
            use Illuminate\Database\Eloquent\Model;
            use ESolution\DBEncryption\Traits\EncryptedAttribute;

            class voltas_agent_input extends Model
            {
                use HasFactory,EncryptedAttribute;
                protected $table= 'voltas_agent_input';
                protected $fillable = ["name","email","userid",'created_by','from_data_id','tid','lead_status'];
                protected $encryptable = ["name","email","userid"];
            }