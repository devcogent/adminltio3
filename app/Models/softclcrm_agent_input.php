<?php

                        namespace App\Models;
                        use Illuminate\Database\Eloquent\Factories\HasFactory;
                        use Illuminate\Database\Eloquent\Model;
                        use ESolution\DBEncryption\Traits\EncryptedAttribute;

                        class softclcrm_agent_input extends Model
                        {
                            use HasFactory,EncryptedAttribute;
                            protected $table= 'softclcrm_agent_input';
                            protected $fillable = ["mystatus","substatus","comment","my_unique_form_id","remarks ",'created_by','from_data_id','tid','lead_status'];
                            protected $encryptable = ["mystatus","substatus","comment","my_unique_form_id","remarks "];
                        }