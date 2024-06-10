<?php

                        namespace App\Models;
                        use Illuminate\Database\Eloquent\Factories\HasFactory;
                        use Illuminate\Database\Eloquent\Model;
                        use ESolution\DBEncryption\Traits\EncryptedAttribute;

                        class manage_non_voice_agent_input extends Model
                        {
                            use HasFactory,EncryptedAttribute;
                            protected $table= 'manage_non_voice_agent_input';
                            protected $fillable = ["campaign","subcampaign","empid","ticketno","ticketstatus","customerid","callbackstatus","reasonforpending","pendingwith",'created_by','from_data_id','tid','lead_status'];
                            protected $encryptable = ["campaign","subcampaign","empid","ticketno","ticketstatus","customerid","callbackstatus","reasonforpending","pendingwith"];
                        }