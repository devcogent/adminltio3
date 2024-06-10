<?php

            namespace App\Models;
            use Illuminate\Database\Eloquent\Factories\HasFactory;
            use Illuminate\Database\Eloquent\Model;
            use ESolution\DBEncryption\Traits\EncryptedAttribute;

            class testtata_agent_input extends Model
            {
                use HasFactory,EncryptedAttribute;
                protected $table= 'testtata_agent_input';
                protected $fillable = ["test",'created_by','from_data_id','tid','lead_status'];
                protected $encryptable = ["test"];
            }