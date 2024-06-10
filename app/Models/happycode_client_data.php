<?php

                        namespace App\Models;
                        use Illuminate\Database\Eloquent\Factories\HasFactory;
                        use Illuminate\Database\Eloquent\Model;
                        use ESolution\DBEncryption\Traits\EncryptedAttribute;

                        class happycode_client_data extends Model
                        {
                            use HasFactory,EncryptedAttribute;
                            protected $table= 'happycode_client_data';
                            protected $fillable = ["srnumber","number","date&time","date","status",'created_by','from_data_id','tid','lead_status'];
                            protected $encryptable = ["srnumber","number","date&time","date","status"];
                        }