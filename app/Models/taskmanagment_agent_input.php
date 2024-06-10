<?php

                        namespace App\Models;
                        use Illuminate\Database\Eloquent\Factories\HasFactory;
                        use Illuminate\Database\Eloquent\Model;
                        use ESolution\DBEncryption\Traits\EncryptedAttribute;

                        class taskmanagment_agent_input extends Model
                        {
                            use HasFactory,EncryptedAttribute;
                            protected $table= 'taskmanagment_agent_input';
                            protected $fillable = ["project","title","module","description","status","sdate","edate","assignedto",'created_by','from_data_id','tid','lead_status'];
                            protected $encryptable = ["project","title","module","description","status","sdate","edate","assignedto"];
                        }