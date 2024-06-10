<?php

                        namespace App\Models;
                        use Illuminate\Database\Eloquent\Factories\HasFactory;
                        use Illuminate\Database\Eloquent\Model;
                        use ESolution\DBEncryption\Traits\EncryptedAttribute;

                        class prospect_agent_input extends Model
                        {
                            use HasFactory,EncryptedAttribute;
                            protected $table= 'prospect_agent_input';
                            protected $fillable = ["phone_number","chat_initiate_time","chat_consent_given_by_customer","call_consent_given_by_customer","attempt_status","call_status","lead_status","remarks",'created_by','from_data_id','tid','lead_status'];
                            protected $encryptable = ["phone_number","chat_initiate_time","chat_consent_given_by_customer","call_consent_given_by_customer","attempt_status","call_status","lead_status","remarks"];
                        }