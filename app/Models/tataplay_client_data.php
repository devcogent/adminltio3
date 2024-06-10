<?php

            namespace App\Models;
            use Illuminate\Database\Eloquent\Factories\HasFactory;
            use Illuminate\Database\Eloquent\Model;
            use ESolution\DBEncryption\Traits\EncryptedAttribute;

            class tataplay_client_data extends Model
            {
                use HasFactory,EncryptedAttribute;
                protected $table= 'tataplay_client_data';
                protected $fillable = ["customerid","rmn_no","subscriber id","repeatbucket","repeattype","cityregion",'created_by','from_data_id','tid','lead_status'];
                protected $encryptable = ["customerid","rmn_no","subscriber id","repeatbucket","repeattype","cityregion"];
            }