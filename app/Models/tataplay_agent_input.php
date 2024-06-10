<?php

                        namespace App\Models;
                        use Illuminate\Database\Eloquent\Factories\HasFactory;
                        use Illuminate\Database\Eloquent\Model;
                        use ESolution\DBEncryption\Traits\EncryptedAttribute;

                        class tataplay_agent_input extends Model
                        {
                            use HasFactory,EncryptedAttribute;
                            protected $table= 'tataplay_agent_input';
                            protected $fillable = ["reasonforrepeat","agentid","callingstatus","identifiedtype","identifiedsubtype","outcome","timeoffollowup","waivertype","reasoncode","amountifgiven","asmtalkedto","feassigned","escalatedto","reasonforescalation","ticketnumber","appointmentpreferredtime","remarks",'created_by','from_data_id','tid','lead_status'];
                            protected $encryptable = ["reasonforrepeat","agentid","callingstatus","identifiedtype","identifiedsubtype","outcome","timeoffollowup","waivertype","reasoncode","amountifgiven","asmtalkedto","feassigned","escalatedto","reasonforescalation","ticketnumber","appointmentpreferredtime","remarks"];
                        }