<?php

                        namespace App\Models;
                        use Illuminate\Database\Eloquent\Factories\HasFactory;
                        use Illuminate\Database\Eloquent\Model;
                        use ESolution\DBEncryption\Traits\EncryptedAttribute;

                        class fom_tracking_agent_input extends Model
                        {
                            use HasFactory,EncryptedAttribute;
                            protected $table= 'fom_tracking_agent_input';
                            protected $fillable = ["subscriber_id","product_type","product_name","tl name",'created_by','from_data_id','tid','lead_status'];
                            protected $encryptable = ["subscriber_id","product_type","product_name","tl name"];
                        }