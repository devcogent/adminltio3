<?php

                        namespace App\Models;
                        use Illuminate\Database\Eloquent\Factories\HasFactory;
                        use Illuminate\Database\Eloquent\Model;
                        use ESolution\DBEncryption\Traits\EncryptedAttribute;

                        class amcfollowuptracker_agent_input extends Model
                        {
                            use HasFactory,EncryptedAttribute;
                            protected $table= 'amcfollowuptracker_agent_input';
                            protected $fillable = ["calling_date","customer_name","register_number","product","serial_number","amount","next_call_date","remarks",'created_by','from_data_id','tid','lead_status'];
                            protected $encryptable = ["calling_date","customer_name","register_number","product","serial_number","amount","next_call_date","remarks"];
                        }