<?php

            namespace App\Models;
            use Illuminate\Database\Eloquent\Factories\HasFactory;
            use Illuminate\Database\Eloquent\Model;
            use ESolution\DBEncryption\Traits\EncryptedAttribute;

            class testingdivya_agent_input extends Model
            {
                use HasFactory,EncryptedAttribute;
                protected $table= 'testingdivya_agent_input';
                protected $fillable = ["name","fdsdf","sdf","dsff","sadf","af","adfg",'created_by','from_data_id','tid','lead_status'];
                protected $encryptable = ["name","fdsdf","sdf","dsff","sadf","af","adfg"];
            }