<?php

            namespace App\Models;
            use Illuminate\Database\Eloquent\Factories\HasFactory;
            use Illuminate\Database\Eloquent\Model;
            use ESolution\DBEncryption\Traits\EncryptedAttribute;

            class happycode_agent_input extends Model
            {
                use HasFactory,EncryptedAttribute;
                protected $table= 'happycode_agent_input';
                protected $fillable = ["status",'created_by','from_data_id','tid','lead_status'];
                protected $encryptable = ["status"];
            }