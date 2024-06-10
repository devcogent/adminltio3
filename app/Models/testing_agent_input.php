<?php

            namespace App\Models;
            use Illuminate\Database\Eloquent\Factories\HasFactory;
            use Illuminate\Database\Eloquent\Model;
            use ESolution\DBEncryption\Traits\EncryptedAttribute;

            class testing_agent_input extends Model
            {
                use HasFactory,EncryptedAttribute;
                protected $table= 'testing_agent_input';
                protected $fillable = ["customerid",'created_by','from_data_id','tid','lead_status'];
                protected $encryptable = ["customerid"];
            }