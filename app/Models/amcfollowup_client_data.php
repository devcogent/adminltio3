<?php

                        namespace App\Models;
                        use Illuminate\Database\Eloquent\Factories\HasFactory;
                        use Illuminate\Database\Eloquent\Model;
                        use ESolution\DBEncryption\Traits\EncryptedAttribute;

                        class amcfollowup_client_data extends Model
                        {
                            use HasFactory,EncryptedAttribute;
                            protected $table= 'amcfollowup_client_data';
                            protected $fillable = ["call_date","customer_name","register_number","product","serial_number","amount","next_call_date",'created_by','from_data_id','tid','lead_status'];
                            protected $encryptable = ["call_date","customer_name","register_number","product","serial_number","amount","next_call_date"];
                        }