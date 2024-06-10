<?php

                        namespace App\Models;
                        use Illuminate\Database\Eloquent\Factories\HasFactory;
                        use Illuminate\Database\Eloquent\Model;
                        use ESolution\DBEncryption\Traits\EncryptedAttribute;

                        class fom_conversion_tracking_client_data extends Model
                        {
                            use HasFactory,EncryptedAttribute;
                            protected $table= 'fom_conversion_tracking_client_data';
                            protected $fillable = ["subscriber_id","sale_type","product_type",'created_by','from_data_id','tid','lead_status'];
                            protected $encryptable = ["subscriber_id","sale_type","product_type"];
                        }