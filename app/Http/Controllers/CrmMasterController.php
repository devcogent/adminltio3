<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Session;
use DB;
/*use Illuminate\Support\Facades\Storage;
use DB;
use Excel; aaa*/
use App\Models\User;
use Carbon\Carbon;
use App\Models\CrmMaster;
use App\Models\CrmForm;
use App\Models\CrmFormField;
use App\Models\CrmFormFieldOption;
use App\Models\UserCrm;
use App\Models\CrmCampaign;
use App\Models\crmFieldDependencie;
use App\Models\CrmBranding;
use Artisan;
use Config;

date_default_timezone_set('Asia/Kolkata');
class CrmMasterController extends Controller
{
    public function __construct()
    {
        //DB::enableQueryLog();
        if (request()->segment(1)) {

            $ext_crm = CrmMaster::where('crm_name', request()->segment(1))->first();
            if (!empty($ext_crm)) {
                Config::set('database.connections.mysql.database', 'cgcrm_' . request()->segment(1));
                DB::purge('mysql');
            }
        }
        $this->middleware('auth');
    }


    public function index(Request $request)
    {

        //dd("adasds");
        //	echo Auth::id();
        //	exit;
        $type = Auth::user()->emp_type;
        //exit;
        if ($type == "agent") {

            return redirect('/agent-view');
        }
        $crm_masters = CrmMaster::select('crm_masters.*', 'users.name as created_by', 'u.name as updated_by')
            ->leftJoin('users',  'users.id', '=', 'crm_masters.created_by')
            ->leftJoin('users as u',  'u.id', '=', 'crm_masters.updated_by')
            ->where('crm_masters.created_by', Auth::id())
            ->get();

        return view('crm_masters.index')->with(compact('crm_masters'));
    }
    public function add()
    {
        //$users=User::orderby('usersName','ASC')->get();
        //return view('clients.index');
        return view('crm_masters.add');
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'crm_name' => 'required|string|regex:/^[\s\w-]*$/|max:255|unique:crm_masters',
            'crm_type' => 'required',
        ]);
        $crm_name = strtolower(str_replace(" ", "_",trim($request->crm_name)));


           // Know your databse name in database

               $query = "SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME =  ?";
               $db = DB::select($query, ['cgcrm_' . $crm_name]);
                if (empty($db)){
                    if(CrmMaster::where('crm_name',$crm_name)->exists())
                    {
                        $request->session()->flash('error', $request->crm_name.' Crm Already Exists !');
                        return redirect('/crm-masters/add');
                    }
                    $crm_ins_id = CrmMaster::create([
                        'crm_name' => $crm_name,
                        'crm_type' => $request->crm_type,
                        'created_by' => Auth::id(),

                    ])->id;

                    DB::statement(DB::raw('CREATE DATABASE ' . strtolower('cgcrm_' . $crm_name)));
                    Config::set('database.connections.mysql.database', strtolower('cgcrm_' . $crm_name));
                    DB::purge('mysql');
                    Artisan::call("migrate --database=mysql");
                    sleep(1);
                    CrmMaster::create([
                        'id' => $crm_ins_id,
                        'crm_name' => $crm_name,
                        'crm_type' => $request->crm_type,
                        'created_by' => Auth::id(),
                    ]);

                    $request->session()->flash('success', 'Crm Create Succefully');
                } else {
                    $request->session()->flash('error', 'Database already Exist with this name '.$crm_name);
                }

        return redirect('/crm-master');
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $crm_masters  = CrmMaster::where($where)->first();
        //dd($crm_masters);
        return view('/crm_masters.edit')->with(compact('crm_masters'));
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'crm_name' => 'required|string',

        ]);
        CrmMaster::where('id', $request->id)->update([
            'crm_name' => $request->crm_name,
            'updated_by' => Auth::id(),
        ]);
        $request->session()->flash('success', 'crm Update Succefully');
        return redirect('/crm-master');
    }

    public function delete(Request $request, $id)
    {

        if (CrmMaster::where('id', $id)->count() > 0) {
            $crm_name =  CrmMaster::where('id', $id)->pluck('crm_name')->first();
            CrmBranding::where('crm_id', $crm_name)->delete();
            CrmMaster::where('id', $id)->delete();
           // DB::statement(DB::raw('DROP DATABASE ' .strtolower('cgcrm_' . $crm_name)));

            // if (UserCrm::where('crm_id', $id)->count() > 0) {
            //    UserCrm::where('crm_id', $id)->delete();
            //    dd("dsd");
            //     $a = CrmForm::where('crm_id', $id)->pluck('id')->toArray();
            //     if (is_array($a)) {
            //         $get_crm_name = CrmForm::where('crm_id', $id)->pluck('form_name')->toArray();
            //         CrmForm::where('crm_id', $id)->delete();
            //         if ($b = CrmFormField::whereIn('crm_form_id', $a)->get('id')) {
            //             CrmFormField::whereIn('crm_form_id', $a)->delete('id');
            //             if (CrmFormFieldOption::whereIn('crm_filed_id', $b)->get()) {
            //                 CrmFormFieldOption::whereIn('crm_filed_id', $b)->delete();
            //                 foreach ($get_crm_name as $my_rows) {
            //                     DB::statement("DROP table $my_rows");
            //                 }
            //             }
            //         }
            //     }
            // }
        }
        $request->session()->flash('error', 'Crm Deleted Succefully');
        return redirect('/crm-master');
    }

    public function manage_fields(Request $request, $id)
    {
        $crm_masters  = CrmMaster::where('id', $id)->first();
        $count = CrmForm::where('crm_id', $crm_masters->id)->get();
        $form_count = count($count);
        Config::set('database.connections.mysql.database', 'cgcrm_' . $crm_masters->crm_name);
        DB::purge('mysql');
        $form_type_value =  DB::table('crm_forms')->where('crm_id', $request->crm_id)->where('form_type', 1)->first();
        return view('crm_masters.manage_fields')->with(compact('crm_masters', 'form_count'));
    }
    public function newfields(Request $request)
    {
         $counter = $request->counter + 1;
         $view = view("crm_masters.new_fields", compact('counter'))->render();
         return \Response::json(['html' => $view, 'status' => 'success']);
    }
    public function updatefields(Request $request)
    {

        $counter = $request->counter + 1;
        $view = view("crm_masters.edit_fields", compact('counter'))->render();
        return \Response::json(['html' => $view, 'status' => 'success']);
    }
    public function create_from(Request $request)
    {



        $this->validate($request, [
            'form_name' => 'required|string|required|unique:crm_forms,form_name',
            'form_type' => 'required|string',
        ]);

        if ($request->form_type == 1) {
            $set_unq = [];
            foreach ($_POST['is_unique'] as $unq) {
                if ($unq == 'yes') {
                    $set_unq[] = $unq;
                }
            }
            if (count($set_unq) == 0) {
                $request->session()->flash('error', 'Please Chose atleast one unique filed value');
                return redirect()->back();
            }
        }

        if (!empty(array_diff_assoc($request->field_name, array_unique($request->field_name)))) {

            $request->session()->flash('error', 'Found Dublicate values');
            return redirect()->back();
        }

        Config::set('database.connections.mysql.database', 'cgcrm_' . $request->crm_name);
        DB::purge('mysql');

        $table_name = strtolower($request->crm_name . '_' . str_replace(' ', '_', $request->form_name));
        if ($request->cti_type == 3) {
            $form_type_value =  DB::table('crm_forms')->where('crm_id', $request->crm_id)->where('form_type', 1)->first();
            if (empty($form_type_value)) {
                $request->session()->flash('error', 'You Must To Create Client Data Form');
                return redirect()->back();
            }
            $form_type_enter = $form_type_value->id;
        } else {
            $form_type_enter = '';
        }

        $crmform = CrmForm::create([
            'crm_id' => $request->crm_id,
            'form_name' => $table_name,
            'form_type' => $request->form_type,
            'cti_depend_form' =>  $form_type_enter,
            'cti_type' => isset($request->cti_type) ? $request->cti_type : '',
            'created_by' => Auth::id()]);

        $fields = [];
        if ($request->has('field_type') && count($request->field_type) > 0) {
            foreach ($_POST['field_type'] as $key => $field_type) {

                $crmformField = new CrmFormField();
                $crmformField->field_type = $field_type;
                $crmformField->field_name = strtolower(preg_replace('/\s+/', '_', ltrim(rtrim($_POST['field_name'][$key]))));
                $crmformField->length = $_POST['length'][$key];
                $crmformField->minlength = $_POST['minlength'][$key];
                $crmformField->sortBy = $_POST['sortBy'][$key];
                $crmformField->label_name = strtolower(preg_replace('/\s+/', ' ', ltrim(rtrim($_POST['label_name'][$key]))));
                $crmformField->is_numaric = $_POST['is_numaric'][$key];
                $crmformField->is_required = $_POST['is_required'][$key];
                $crmformField->field_depend = !empty($_POST['field_depend'][$key]) ? $_POST['field_depend'][$key] : ''; //$_POST['field_depend'][$key]; ///
                $crmformField->is_unique = $_POST['is_unique'][$key];
                $crmformField->is_audit = $_POST['is_audit'][$key];
                $crmformField->crm_form_id = $crmform->id;
                $crmformField->created_by =  Auth::id();
                $crmformField->save();
                $fields['field_name'] = $_POST['field_name'][$key];
                $fields['length'] = $_POST['length'][$key];

                if ($field_type != "check_box") {
                    $fields['length'] = $_POST['length'][$key];
                } else {

                    $fields['length'] = '100';
                }
                if ($field_type != "date_picker") {
                    $fields['length'] = $_POST['length'][$key];
                } else {

                    $fields['length'] = '10';
                }
                if ($field_type != "email") {
                    $fields['length'] = $_POST['length'][$key];
                } else {

                    $fields['length'] = '100';
                }
                if ($field_type != "mobile") {
                    $fields['length'] = $_POST['length'][$key];
                } else {

                    $fields['length'] = '10';
                }
                if ($field_type != "zip") {
                    $fields['length'] = $_POST['length'][$key];
                } else {

                    $fields['length'] = '6';
                }

                $finalFileds[] = $fields;
            }

            /* Dynamic Model  */

            $modelPath =  app_path() . '\Models';
            $modelPath1 =  app_path() . '/Models';
            Artisan::call("make:model $table_name"); // create dynamic model
            $createModel = "$modelPath" . "\\" . $table_name . ".php";
            $createModel1 = "$modelPath1" . "/" . $table_name . ".php";

            chmod($modelPath1 . '/' . $table_name . ".php", 0777); // dynamic mode file give permission

            $tbName = 'protected $table= ' . "'$table_name'";
            $field_nameArr = '';
            foreach ($finalFileds as $row) {
                $field_nameArr .= '"' . strtolower(trim($row['field_name'])) . '",';
            }
            $field_nameArr = rtrim($field_nameArr, ',');
            $fillable = 'protected $fillable = [' . str_replace(' ', '_', $field_nameArr) . ",'created_by','from_data_id','tid','lead_status']";

            $encryptable = 'protected $encryptable = [' . str_replace(' ', '_', $field_nameArr) . ']';
            $conent = "<?php

            namespace App\Models;
            use Illuminate\Database\Eloquent\Factories\HasFactory;
            use Illuminate\Database\Eloquent\Model;
            use ESolution\DBEncryption\Traits\EncryptedAttribute;

            class $table_name extends Model
            {
                use HasFactory,EncryptedAttribute;
                $tbName;
                $fillable;
                $encryptable;
            }";

            // dd($createModel1);

            file_put_contents($createModel1, "");

            file_put_contents($createModel1, $conent);



            /* Dynamic Model  */
            //dd($finalFileds);
            if ($request->form_type == 2) {
                $this->createTableCti($table_name, $finalFileds);
            } else {
                $this->createTableUserInput($table_name, $finalFileds);
            }
        }

        $request->session()->flash('success', 'Crm Formm Fields Create Successfully');
        return redirect('/crm-master');
    }

    public function createTableCti($table_name, $fields = [])
    {
        // laravel check if table is not already exists
        if (!Schema::hasTable($table_name)) {
            Schema::create($table_name, function (Blueprint $table) use ($fields, $table_name) {
                $table->increments('id');
                if (count($fields) > 0) {
                    foreach ($fields as $field) {
                        // $table->string($field['field_name'], $field['length'])->nullable();
                        // $table->string(preg_replace('/\s+/', '_', ltrim(rtrim($field['field_name']))), $field['length'])->nullable();
                        $table->text(preg_replace('/\s+/', '_', strtolower(ltrim(rtrim($field['field_name'])))))->nullable();
                    }
                }
                $table->string('created_by', 50);
                $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
                $table->string('from_data_id', 10)->nullable();
                $table->string('tid', 10)->nullable();
                $table->string('lead_status', 10)->default('0');
            });

            return true;
        } else {
            return false;
        }

        return response()->json(['message' => 'Given table is already existis.'], 400);
    }
    public function createTableUserInput($table_name, $fields = [])
    {
        // laravel check if table is not already exists
        if (!Schema::hasTable($table_name)) {
            Schema::create($table_name, function (Blueprint $table) use ($fields, $table_name) {
                $table->increments('id');
                if (count($fields) > 0) {
                    foreach ($fields as $field) {
                        // $table->string($field['field_name'], $field['length'])->nullable();
                        // $table->string(preg_replace('/\s+/', '_', ltrim(rtrim($field['field_name']))), $field['length'])->nullable();
                        //$table->{$field['type']}($field['field_name']);
                        $table->text(preg_replace('/\s+/', '_', strtolower(ltrim(rtrim($field['field_name'])))))->nullable();
                    }
                }
                $table->string('created_by', 50);
                $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
                $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
                $table->string('lead_status', 10)->default('0');
            });

            return true;
        } else {
            return false;
        }

        return response()->json(['message' => 'Given table is already existis.'], 400);
    }

    public function manage_options(Request $request, $id)
    {
        $crm_masters  = CrmMaster::where('id', $id)->first();
        Config::set('database.connections.mysql.database', 'cgcrm_' . $crm_masters->crm_name);
        DB::purge('mysql');
        $crmform  = CrmForm::where('crm_id', $crm_masters->id)->get();
        $crm_name = $crm_masters->crm_name;
        return view('crm_masters.manage_options')->with(compact('crmform', 'crm_name'));
    }



    public function getcrmFormfields(Request $request)
    {
        Config::set('database.connections.mysql.database', 'cgcrm_' . $request->crm_name);
        DB::purge('mysql');

        $data['crm_name'] = $request->crm_name;
        $data['crm_fields']  = CrmFormField::where('crm_form_id', $request->crmform_id)
            ->whereIn('field_type', array('drop_down', 'radio_button', 'check_box'))
            ->get();

        if (count($data['crm_fields']) > 0) {
            $view = view("crm_masters.crm_formoptions_fields", $data)->render();

            return  \Response::json(['html' => $view, 'status' => 'success']);
        } else {
            return \Response::json(['html' => '', 'status' => 'fail']);
        }
    }
    public function getcrmForm(Request $request)
    {

        $crmforms  = CrmForm::where('crm_id', $request->crm_id)->get();
        if (count($crmforms) > 0) {
            $view = '<option value="" selected>Select Form </option>';
            foreach ($crmforms as $st) {
                $view .= '<option value="' . $st->form_name . '">' . $st->form_name . '</option>';
            }
            return \Response::json(['html' => $view, 'status' => 'success']);
        } else {
            return \Response::json(['html' => '', 'status' => 'fail']);
        }
    }


    public function getcrmType(Request $request)
    {
        if (Auth::user()->emp_type == 'super_admin') {
            $crmforms  = CrmMaster::where('crm_type', $request->crm_type)->get();
        } else {
            $crmforms  = CrmMaster::where('crm_type', $request->crm_type)->where('created_by', Auth::user()->id)->get();
        }
        if (count($crmforms) > 0) {
            $view = '<option value="" selected>Select CRM </option>';
            foreach ($crmforms as $st) {
                $view .= '<option value="' . $st->id . '">' . $st->crm_name . '</option>';
            }
            return \Response::json(['html' => $view, 'status' => 'success']);
        } else {
            return \Response::json(['html' => '', 'status' => 'fail']);
        }
    }

    public function getcrmFormoptions(Request $request)
    {

        Config::set('database.connections.mysql.database', 'cgcrm_' . $request->crm_name);
        DB::purge('mysql');

        $crmformFieldoptions  = CrmFormFieldOption::where('crm_filed_id', $request->crm_filed_id)->get();
        $remit = DB::select("SELECT * FROM crm_field_options AS fo INNER JOIN crm_fields AS cf ON fo.crm_filed_id = cf.id WHERE fo.crm_filed_id = (SELECT id  FROM `crm_fields` WHERE `crm_form_id` = (SELECT crm_form_id from crm_fields where id = $request->crm_filed_id limit 1) and `field_name` = (SELECT field_depend from crm_fields where id = $request->crm_filed_id limit 1))");

        $view = '';

        $crmformFieldLimit  = DB::select("SELECT length FROM `crm_fields` WHERE `id` =  $request->crm_filed_id  ");

        $limitLenght = $crmformFieldLimit[0]->length;
        $dep = '';
        if ($request->field_depend == 'null') {
            $dep = '';
        } else {
            $dep = $request->field_depend;
        }

        $view .= "&nbsp<p><b>( $request->field_name ) PARENT : $dep </b><p>";
        foreach ($crmformFieldoptions as $crmformFieldoption) {

            $crmformField  = DB::select("SELECT * FROM `crm_field_options` WHERE `crm_filed_id` =  $request->crm_filed_id AND `options` LIKE '$crmformFieldoption->options' ORDER BY `id` DESC limit 1 ");



            $view .= '<div class="moreRows row" id="moreRows"><div class="col-md-12"> <div class="col-md-3 col-sm-12 col-xs-12 form-group"><input type="text" readonly placeholder="Enter Option" class="form-control" name="option[]" value="' . $crmformField[0]->options . '"></div>';

            if (!empty($remit)) {
                $view .= '<div class="col-md-3 col-sm-12 col-xs-12 form-group"><select readonly class="form-control" name="parent_name[]">';
                $view .= '<option readonly value= "' . $crmformField[0]->parent_name . '"> ' . $crmformField[0]->parent_name . ' </option>';
                $view .= '</select></div>';
            }
            // } else {$view .= "<option readonly value='null'></option>";}

        }

        $view .= '<div class="col-md-3 col-sm-12 col-xs-12 form-group">
           <a href="javascript:void(0)" class="btn btn-warning addoption"><i class="fa fa-plus"> </i></a> </div> </div>  </div>';
        $view .= '<div class="moreRow row" id="moreRow"><div class="col-md-12"></div>';
        $view .= '<script> $(document).ready(function() { $(document).on("click", "removeOptions", function() { $(this).parent().parent().remove(); }); });</script>';
        $view .= '<script> $(".addoption").click(function() { $("#moreRow").append("<div class= col-md-12 ><div class= col-md-3 col-sm-12 col-xs-12 form-group ><input type= text  placeholder= Enter Option  class= form-control  name= option[]  maxlength= ' . $limitLenght . ' ></div> <div class= col-md-3 col-sm-12 col-xs-12 form-group ><select style = display:block  class= form-control  name= parent_name[] >';
        if (!empty($remit)) {
            foreach ($remit as $remitss) {
                $view .= "<option value = '$remitss->options' > $remitss->options </option>";
            }
        } else {
            $view .= "<option value = 'null' > </option>";
        }
        $view .= '</select></div><div class= col-md-3 col-sm-12 col-xs-12 form-group >';
        $view .= "<a href= javascript:void(0)  class= 'btn btn-danger removeOptions'  attrid= 11 > <i class= 'fa fa-minus' > </i></a>";
        $view .= '</div></div") }); </script>';

        return \Response::json(['html' => $view, 'status' => 'success']);
    }
    public function saveOptions(Request $request)
    {

        Config::set('database.connections.mysql.database', 'cgcrm_' . $request->crm_name);
        DB::purge('mysql');
        $array1 = array_map('strtolower', $request->option);
        $array2 = array_map('strtolower', $request->parent_name);
        $result = array_intersect($array1, $array2);

        if (!empty($result)) {
            $request->session()->flash('error', "Child Item Can't Equal To Parent Item");
            $url = url()->previous();
            return redirect($url);
        }

        CrmFormFieldOption::where('crm_filed_id', $request->crm_filed_id)->delete();

        if ($request->has('option') && count($request->option) > 0) {

            foreach ($_POST['option'] as $field_type => $key_value) {
                $crmformFieldoption = new CrmFormFieldOption();
                $crmformFieldoption->options = $key_value;
                $crmformFieldoption->crm_filed_id = $request->crm_filed_id;
                $crmformFieldoption->parent_name = $request->parent_name[$field_type]; //!empty($request->parent_name[$field_type]) ? : '';
                $crmformFieldoption->created_by =  Auth::id();
                // $products_categories->product_id=$product->id;
                $crmformFieldoption->save();
            }
        }

        $request->session()->flash('success', 'Crm Form Fields Options Create Successfully');
        $url = url()->previous();
        return redirect($url);
    }


    public function addChildField(Request $request, $dbname)
    {



        $data =  DB::select("SELECT * FROM crm_field_options AS fo INNER JOIN crm_fields AS cf ON fo.crm_filed_id = cf.id WHERE cf.crm_form_id = ( SELECT crm_form_id FROM `crm_fields` WHERE  `id` = $request->crm_filed_id ) and fo.parent_name = '$request->parent_name'
     ");

        //  $view = '';
        //  foreach ($data as $crmformFieldoption) {
        //     $crmFiledId =$crmformFieldoption->crm_filed_id;
        //     $options =$crmformFieldoption->options;
        //     $view .="<option onclick= getParent('$crmFiledId', '$options') value='$options' >$crmformFieldoption->options </option>";

        //  }

        if (!empty($data)) {
            $ret = $data;
            return \Response::json(['html' => $ret, 'status' => 'success', 'child' => 'success']);
        } else {
            $data =  DB::select("SELECT id FROM `crm_fields` WHERE field_depend = (SELECT field_name FROM `crm_fields` WHERE id = $request->crm_filed_id limit 1)");
            $ret = $data;
            return \Response::json(['html' => $ret, 'status' => 'success', 'child' => 'failed']);
        }
    }

    public function manage_columns(Request $request, $id)
    {


        $getCrm = CrmMaster::where('id', $id)->first();
        $crm_name = $getCrm->crm_name;

        Config::set('database.connections.mysql.database', 'cgcrm_' . $getCrm->crm_name);
        DB::purge('mysql');
        $crmform  = CrmForm::where('crm_id', $getCrm->id)->get();
        return view('crm_masters.manage_columns')->with(compact('crmform', 'crm_name'));
    }


    public function update_column(Request $request)
    {

        try {
            if (!empty(array_diff_assoc($request->field_name, array_unique($request->field_name)))) {

                $request->session()->flash('error', 'Found Dublicate values');
                return redirect()->back();
            }
            $id =  $request->crm_forms;
            Config::set('database.connections.mysql.database', 'cgcrm_' . $request->crm_name);
            DB::purge('mysql');
            $data_form_type =  DB::table('crm_forms')->where('id', $id)->first();
            if ($data_form_type->form_type == 1) {
                $set_unq = [];
                foreach ($_POST['is_unique'] as $unq) {
                    if ($unq == 'yes') {
                        $set_unq[] = $unq;
                    }
                }
                if (count($set_unq) == 0) {
                    $request->session()->flash('error', 'Please Chose atleast one unique filed value');
                    return redirect()->back();
                }
            }

            $delIds = $delColumn = array();

            if ($request->column_name) {

                $column_name =  $request->column_name;
                if (sizeof($column_name) > 0) {

                    for ($k = 0; $k < sizeof($column_name); $k++) {

                        $val = array();
                        $val = explode("@@", $column_name[$k]);
                        $delIds[] = $val[0];
                        $delColumn[] = $val[1];
                    }
                    CrmFormField::where('crm_form_id', $id)->delete();
                    $request->session()->flash('success', 'Column Delete Successfully');
                }
            }



            $crmformAdd = CrmFormField::where('crm_form_id', $id)->orderBy('id', 'desc')->limit(1)->get();

            if (sizeof($crmformAdd) > 0) {
                $afterField = $crmformAdd[0]->field_name;
            } else {
                $afterField = 'id';
            }
            if (empty($afterField)) {
                $afterField = 'id';
            }
            $crmform  = CrmForm::where('id', $id)->get();
            $table_name = $crmform[0]->form_name;

            $fields = [];
            $insop_id = [];
            $new_insop_id = [];
            if ($request->field_type) {
                if (sizeof($request->field_type) > 0) {
                    if ($request->has('field_type') && count($request->field_type) > 0) {
                        $i = 0;
                        foreach ($_POST['field_type'] as $key => $field_type) {
                            $i += 1;
                            $crmformField = new CrmFormField();
                            $crmformField->field_type = $field_type;
                            $crmformField->field_name = isset($_POST['field_name'][$key]) ? preg_replace('/\s+/', '_', strtolower(ltrim(rtrim($_POST['field_name'][$key])))) : '';
                            $crmformField->length = isset($_POST['length'][$key]) ? $_POST['length'][$key] : '';
                            $crmformField->minlength =  isset($_POST['minlength'][$key]) ? $_POST['minlength'][$key] : '';
                            $crmformField->sortBy = isset($_POST['sortBy'][$key]) ? $_POST['sortBy'][$key] : '';
                            $crmformField->label_name = isset($_POST['label_name'][$key]) ? strtolower($_POST['label_name'][$key]) : '';
                            $crmformField->is_numaric = isset($_POST['is_numaric'][$key]) ? $_POST['is_numaric'][$key] : '';
                            $crmformField->is_required = isset($_POST['is_required'][$key]) ? $_POST['is_required'][$key] : '';
                            // $crmformField->is_depend = $_POST['is_depend'][$key];
                            $crmformField->field_depend = isset($_POST['field_depend'][$key]) ? $_POST['field_depend'][$key] : '';
                            $crmformField->is_unique = isset($_POST['is_unique'][$key]) ? $_POST['is_unique'][$key] : '';
                            $crmformField->is_audit = isset($_POST['is_audit'][$key]) ? $_POST['is_audit'][$key] : '';
                            $crmformField->crm_form_id = $id;
                            $crmformField->created_by =  Auth::id();
                            $crmformField->save();
                            $insertedId = $crmformField->id;
                            if (count($delIds) >= $i) {
                                CrmFormFieldOption::where("crm_filed_id", $delIds[$key])->update(["crm_filed_id" => $insertedId]);
                            }
                            // }
                            $fields['field_name'] = $_POST['field_name'][$key];
                            if ($field_type != "check_box") {
                                $fields['length'] = $_POST['length'][$key];
                            } else {

                                $fields['length'] = '100';
                            }
                            if ($field_type != "date_picker") {
                                $fields['length'] = $_POST['length'][$key];
                            } else {

                                $fields['length'] = '10';
                            }
                            if ($field_type != "email") {
                                $fields['length'] = $_POST['length'][$key];
                            } else {

                                $fields['length'] = '100';
                            }
                            if ($field_type != "mobile") {
                                $fields['length'] = $_POST['length'][$key];
                            } else {

                                $fields['length'] = '10';
                            }
                            if ($field_type != "zip") {
                                $fields['length'] = $_POST['length'][$key];
                            } else {

                                $fields['length'] = '6';
                            }

                            $finalFileds[] = $fields;
                        }



                        /* Dynamic Model */
                        $slash = "\\";
                        $mdName = $slash . $table_name;
                        $modelPath =  app_path() . '\Models';
                        $modelPath1 =  app_path() . '/Models';
                        // Artisan::call("make:model $table_name"); // create dynamic model
                        $tbName = 'protected $table= ' . "'$table_name'";
                        $field_nameArr = '';
                        foreach ($finalFileds as $row) {

                            $field_nameArr .= '"' . strtolower(trim($row['field_name'])) . '",';
                        }

                        $field_nameArr = rtrim($field_nameArr, ',');
                        $fillable = 'protected $fillable = [' . str_replace(' ', '_', $field_nameArr) . ",'created_by','from_data_id','tid','lead_status']";
                        $encryptable = 'protected $encryptable = [' . str_replace(' ', '_', $field_nameArr) . ']';
                        $conent = "<?php

                        namespace App\Models;
                        use Illuminate\Database\Eloquent\Factories\HasFactory;
                        use Illuminate\Database\Eloquent\Model;
                        use ESolution\DBEncryption\Traits\EncryptedAttribute;

                        class $table_name extends Model
                        {
                            use HasFactory,EncryptedAttribute;
                            $tbName;
                            $fillable;
                            $encryptable;
                        }";

                        file_put_contents("$modelPath1" . "/" . $table_name . ".php", "");
                        file_put_contents("$modelPath1" . "/" . $table_name . ".php", $conent);
                        // file_put_contents("$modelPath" . "\\" . $table_name . ".php", "");
                        // file_put_contents("$modelPath" . "\\" . $table_name . ".php", $conent);
                        /* Dynamic Model End  */


                        $delFields = $delColumn;
                        $this->updateTable($table_name, $finalFileds, $delFields, $afterField, $_POST['field_name_old'], $id);
                    }

                    $request->session()->flash('success', 'Crm Form Fields Update Successfully');
                    return redirect()->back();
                }
            } else {

                $delFields = $delColumn;
                $finalFileds = array();
                $this->updateTable($table_name, $finalFileds, $delFields, $afterField, $_POST['field_name_old'], $id);
                $request->session()->flash('error', 'No Formm Fields will Update.');
                return redirect()->back();
            }
        } catch (\Throwable $ex) {

            DB::rollback();
            $request->session()->flash('error', $ex->getMessage() . 'Line:' . $ex->getLine());

            return redirect()->back();
        }
    }


    public function updateTable($table_name, $fields = [], $delFields = [], $afterField, $oldFiled, $crm_id)
    {

        $old_sch = Schema::getColumnListing($table_name);
        foreach ($old_sch as $get_schema) {

            if ($get_schema != 'id' && $get_schema != 'tid' && $get_schema != 'updated_at' && $get_schema != 'from_data_id' && $get_schema != 'created_by' && $get_schema != 'created_at' && $get_schema != 'lead_status') {
                $get_after = $get_schema;
                $get_del_old[] = $get_schema;
            }
        }
        Schema::table($table_name, function (Blueprint $table) use ($table_name, $fields, $oldFiled, $get_after, $get_del_old) {

            foreach ($fields as $field_key => $get_field) {
                // $get_field_name =   preg_replace('/\s+/', '_', ltrim(rtrim($get_field['field_name'])));
                if ($oldFiled[$field_key] != preg_replace('/\s+/', '_', strtolower(ltrim(rtrim($get_field['field_name'])))) && $oldFiled[$field_key] != 'null') {
                    DB::statement("ALTER TABLE $table_name CHANGE " . $oldFiled[$field_key] . " " . preg_replace('/\s+/', '_', strtolower(ltrim(rtrim($get_field['field_name'])))) . " TEXT DEFAULT NULL");
                }
                if ($oldFiled[$field_key] == 'null') {
                    DB::statement("ALTER TABLE $table_name ADD " . preg_replace('/\s+/', '_', strtolower(ltrim(rtrim($get_field['field_name'])))) . " TEXT NULL AFTER $get_after");
                }
            }

            foreach ($get_del_old as $key_get_del_old) {
                if (!in_array($key_get_del_old, $oldFiled)) {
                    DB::statement("ALTER TABLE $table_name DROP " . $key_get_del_old);
                }
            }
        });
        return true;
    }

    public function manageCampaign()
    {
        try {
                $data['get_crm'] = CrmMaster::where('created_by', Auth::id())->where('crm_type', 1)->get();
                $data['crm_campaigns'] = CrmCampaign::where('created_by', Auth::id())->orderBy('id', 'DESC')->get();
                return view('crm_masters.manage_campaigen')->with(compact('data'));
        } catch (\Throwable $th) {
              return redirect()->back()->with('error', 'something went wrong !');
        }


    }


    public function saveCampaigen(request $request)
    {

        unset($request['_token']);
        $this->validate($request, [
            'camp_name' => 'required|alpha_dash|string|regex:/^[\s\w-]*$/|max:255|unique:crm_campaigns',
            'token_name' => 'required|unique:crm_campaigns',
            'api_url' => 'required|unique:crm_campaigns',
            'skill_name' => 'required',
            'date_format' => 'required',
            'list_name' => 'required',
        ]);

        if ($request->depend_status == '0') {
            $dropdown_id = 'NA';
            $option_id = 'NA';
        } else {
            $dropdown_id = $request->dropdown_id;
            $option_id = $request->option_id;
        }

        if ($request->depend_status == '1') {

            if (empty($request->option_id) && !isset($request->option_id)) {
                $request->session()->flash('error', 'Can not empty option id');
                return redirect()->back();
            }

            if (empty($request->dropdown_id) && !isset($request->dropdown_id)) {
                $request->session()->flash('error', 'Can not empty dropdown id');
                return redirect()->back();
            }
        }

        try {

            $ins =  CrmCampaign::create([
                'camp_name' => $request->camp_name,
                'skill_name' => $request->skill_name,
                'token_name' => $request->token_name,
                'date_format' => $request->date_format,
                'list_name' => $request->list_name,
                'api_url' => $request->api_url,
                'crm_id' => $request->crm_id,
                'depend_status' => $request->depend_status,
                'dropdown_id' => $dropdown_id,
                'option_id' => $option_id,
                'created_by' => Auth::id(),
            ]);
              $request->session()->flash('success', 'Campaign Create Successfully');
             } catch (\Throwable $th) {
                $request->session()->flash('error', 'Something Went Wrong !');
            }
            return redirect()->back();

    }


    public function deleteCampaign($id, request $request)
    {

        try {
                if (CrmCampaign::where('id', $id)->delete()) {
                    $request->session()->flash('error', 'Campaign deleted Successfully');
                }
            } catch (\Throwable $th) {
                $request->session()->flash('error', 'Something Went Wrong !');
            }
        return redirect()->back();


    }

    public function getDropdown(Request $request)
    {
        try{
            $id = $request->id;
            Config::set('database.connections.mysql.database', 'cgcrm_' . explode('_client_data', $id)[0]);
            DB::purge('mysql');
            $getFormName = CrmForm::where('form_name', $id)->first();
            $CrmFormField  = CrmFormField::where('crm_form_id', $getFormName->id)->where('field_type', 'drop_down')->get();
            $list_dropdown = '';
            $list_dropdown .= '<option value="">--Select--</option>';
            foreach ($CrmFormField as $rows) {
                $list_dropdown .= "<option value='$rows->field_name'>$rows->field_name</option>";
            }
            return $list_dropdown;
        }
            catch (\Throwable $ex) {
                return back()->with('error', $ex->getMessage());
         }
   }


    public function getOption(Request $request)
    {

        try {
            $crm_id = $request->crm_id;
            $field_name = $request->field_name;
            Config::set('database.connections.mysql.database', 'cgcrm_' . explode('_client_data', $crm_id)[0]);
            DB::purge('mysql');
            $getFormName = CrmForm::where('form_name', $crm_id)->first();

            if ($CrmFormField  = CrmFormField::where('crm_form_id', $getFormName->id)->where('field_name', $field_name)->where('field_type', 'drop_down')->first()) {
                $option_id = $CrmFormField->id;
                $list_dropdown = '';
                if ($CrmFormFieldOption  = CrmFormFieldOption::where('crm_filed_id', $option_id)->get()) {
                    foreach ($CrmFormFieldOption as $rows) {
                        $list_dropdown .= "<option value='$rows->options'>$rows->options</option>";
                    }
                    return $list_dropdown;
                }
            }
        } catch (\Throwable $ex) {
               return back()->with('error', $ex->getMessage());
        }


    }



    public function apiCode(request $request, $table)
    {

        try {
            Config::set('database.connections.mysql.database', 'cgcrm_' . explode('_client_data', $table)[0]);
            DB::purge('mysql');
            $crmform  = CrmForm::where('form_name', $table)->first();
            //dd($crmform);
            if ($crmform) {
                $crm_fields  = CrmFormField::where('crm_form_id', $crmform->id)->orderby('sortBy', 'asc')->get();
                // dd($crm_fields);
                return view('uploadform.api_upload')->with(compact('crm_fields', 'crmform'));
            } else {
                return view('error');
            }
        } catch (\Throwable $th) {
                 return back()->with('error', $th->getMessage);
        }


    }


    public function getCtiLink(request $request, $table)
    {
            try {

                Config::set('database.connections.mysql.database', 'cgcrm_' . explode('_client_data', $table)[0]);
                DB::purge('mysql');
                $crmform  = CrmForm::where('form_name', $table)->get()->toArray();
                if ($crmform) {
                    foreach ($crmform as $froms) {
                        $remitUniqeFiled = '';
                        $getFormField  = CrmFormField::where('crm_form_id', $froms['id'])->where('is_unique', 'yes')->get()->toArray();
                        if (!empty($getFormField)) {
                            foreach ($getFormField as $getUniqeField) {
                                $remitUniqeFiled .= $getUniqeField['field_name'] . '=' . 'DEMO' . '&';
                            }
                        } else {
                            $remitUniqeFiled = '';
                        }
                        $remitUniqeFiled = substr($remitUniqeFiled, 0, -1);
                    }
                 return view('uploadform.cti_upload')->with(compact('remitUniqeFiled', 'crmform'));
                } else {
                        return view('error');
                }

            } catch (\Throwable $th) {
                return back()->with('error', $th->getMessage);
            }


    }



    public function manageFiledDepends()
    {

        $data['get_crm'] = CrmMaster::where('created_by', Auth::id())->wherein('crm_type', [2, 1])->get();
        $crmDb = CrmMaster::where('created_by', Auth::id())->wherein('crm_type', [2, 1])->orderby('crm_name')->distinct('crm_name')->get();
         if (!empty($crmDb->toArray())) {
             foreach ($crmDb as $key) {
                Config::set('database.connections.mysql.database', 'cgcrm_' . $key->crm_name);
                DB::purge('mysql');
                $data['crm'][] = $key->crm_name;
                $data['crm_filed_dependencie'][] = crmFieldDependencie::where('created_by', Auth::id())->orderBy('id', 'DESC')->get();
            }
        } else {
            $data['crm'][] = '';
            $data['crm_filed_dependencie'][] = [];
        }
          return view('crm_masters.manage_depend')->with(compact('data'));
    }



    public function getDropdownManageFiled(Request $request)
    {

        $id = $request->id;
        Config::set('database.connections.mysql.database', 'cgcrm_' . explode('_agent_input', $id)[0]);
        DB::purge('mysql');
        $getFormName = CrmForm::where('form_name', $id)->first();
        $CrmFormField  = CrmFormField::where('crm_form_id',  $getFormName->id)->where('field_type', 'drop_down')->get();
        $list_dropdown = '';
        $list_dropdown .= '<option value="" selected>--Select--</option>';
        foreach ($CrmFormField as $rows) {
            $list_dropdown .= "<option value='$rows->field_name'>$rows->field_name ($rows->field_type)</option>";
        }
        return $list_dropdown;
    }


    public function getDropdownMakeDepend(Request $request)
    {

        $id = $request->id;
        Config::set('database.connections.mysql.database', 'cgcrm_' . explode('_agent_input', $id)[0]);
        DB::purge('mysql');
        $getFormName = CrmForm::where('form_name', $id)->first();
        $CrmFormField = CrmFormField::where('crm_form_id', $getFormName->id)->get();
        $crm_dep_data = crmFieldDependencie::where("crm_id", $getFormName->id)->get('dropdown_id_from');
        $remit_data_dep = [];
        foreach ($crm_dep_data as $crm_dep) {
            $remit_data_dep[] = $crm_dep->dropdown_id_from;
        }
        $list_dropdown = '';
        $list_dropdown .= '<option value="" selected>--Select--</option>';
        $count_ar = [];
        foreach ($CrmFormField as $rows) {
            if (!in_array($rows->field_name, $remit_data_dep)) {
                $list_dropdown .= "<option value='$rows->field_name'>$rows->field_name ($rows->field_type)</option>";
                $count_ar[] = $rows->field_name;
            }
        }

        if (count($count_ar) == 1) {
            $list_dropdown = '';
            $list_dropdown .= '<option value="" selected>--Select--</option>';
        }
        return $list_dropdown;
    }


    public function getOptionDepend(Request $request)
    {

        $crm_id = $request->crm_id;
        $field_name = $request->field_name;
        Config::set('database.connections.mysql.database', 'cgcrm_' . explode('_agent_input', $crm_id)[0]);
        DB::purge('mysql');
        $getFormName = CrmForm::where('form_name', $crm_id)->first();
        // dd($getFormName);
        if ($CrmFormField  = CrmFormField::where('crm_form_id', $getFormName->id)->where('field_name', $field_name)->where('field_type', 'drop_down')->first()) {
            $option_id = $CrmFormField->id;
            // dd($option_id);
            $list_dropdown = '';
            $list_dropdown .= '<option value="" selected>--Select--</option>';
            if ($CrmFormFieldOption  = CrmFormFieldOption::where('crm_filed_id', $option_id)->get()) {
                foreach ($CrmFormFieldOption as $rows) {
                    $list_dropdown .= "<option value='$rows->options'>$rows->options</option>";
                }
                return $list_dropdown;
            }
        }
    }


    public function getRemitParent($crm_id, $dropdown_id)
    {

        return crmFieldDependencie::where("crm_id", $crm_id)->where('dropdown_id_from', $dropdown_id)->first();
    }

    public function saveDependFiled(request $request)
    {

        unset($request['_token']);
        // dd($request->all());
        $this->validate($request, [
            'crm_id' => 'required',
            'dropdown_id_from' => 'required',
            'dropdown_id' => 'required',
            'option_id' => 'required',
        ]);

        if ($request->dropdown_id_from == $request->dropdown_id) {

            $request->session()->flash('error', 'Can not depend same item');
            return redirect()->back();
        }

        Config::set('database.connections.mysql.database', 'cgcrm_' . explode('_agent_input', $request->crm_id)[0]);
        DB::purge('mysql');
        $getFormName = CrmForm::where('form_name', $request->crm_id)->first();

        $remit_data_old = crmFieldDependencie::where("crm_id", $getFormName->id)->where('dropdown_id_from', $request->dropdown_id_from)->where('dropdown_id', $request->dropdown_id)->where('option_id', $request->option_id)->first();

        if (!empty($remit_data_old)) {

            $request->session()->flash('error', 'This Filed Already Depend This Item!');
            return redirect()->back();
        }

        $ins = crmFieldDependencie::create([
            'crm_id' =>  $getFormName->id,
            'dropdown_id_from' => $request->dropdown_id_from,
            'dropdown_id' => $request->dropdown_id,
            'option_id' => $request->option_id,
            'created_by' => Auth::id(),
        ]);

        if ($ins) {
            $request->session()->flash('success', 'Filed Saved Successfully');
            return redirect()->back();
        } else {
            $request->session()->flash('error', 'Can not create');
            return redirect()->back();
        }
    }

    public function deleteDependencie($id, $db, request $request)
    {

        Config::set('database.connections.mysql.database', 'cgcrm_' . $db);
        DB::purge('mysql');
        if (crmFieldDependencie::where('id', $id)->delete()) {
            $request->session()->flash('error', 'Deleted Successfully');
            return redirect()->back();
        }
    }


    public function crmBranding($dbname)
    {


        //$brand_data = CrmBranding::where('crm_id', explode('_crm', $dbname)[0])->first();


        $brand_data = CrmBranding::where('crm_id', $dbname)->first();

        if (!$brand_data) {

            $brand_data = [];
        }

        return view('crm_masters.crm_branding')->with(compact('dbname', 'brand_data'));
    }


    public function saveBranding(request $request)
    {


        $request->validate([
            'logo_url' => 'image|mimes:png,jpg,jpeg|max:2048',
            'crm_id' => 'required',
            'footer_text' => 'required',
            'crm_title' => 'required',
            'height_img' => 'required',
            'width_img' => 'required',
        ]);

       if (isset($request->logo_url)) {
            $imageName = time() . '.' . $request->logo_url->extension();
            $request->logo_url->move(public_path('images'), $imageName);
        } else {
            $imageName = $request->old_logo;
        }
        if (CrmBranding::where('crm_id', $request->crm_id)->first()) {

            $ins = CrmBranding::where('crm_id', $request->crm_id)->update([
                'crm_id' => $request->crm_id,
                'crm_title' => $request->crm_title,
                'logo_url' => $imageName,
                'footer_text' => $request->footer_text,
                'height_img' => $request->height_img,
                'width_img' => $request->width_img,
                'created_by' => Auth::user()->id,
            ]);
        } else {

            $ins = CrmBranding::create([
                'crm_id' => $request->crm_id,
                'crm_title' => $request->crm_title,
                'logo_url' => $imageName,
                'footer_text' => $request->footer_text,
                'height_img' => $request->height_img,
                'width_img' => $request->width_img,
                'created_by' => Auth::user()->id,
            ]);
        }
        if ($ins) {
            $request->session()->flash('success', 'Saved Successfully');
            return redirect()->back();
        } else {
            $request->session()->flash('error', 'Can not create');
            return redirect()->back();
        }
    }

    public function mamageKey(request $request)
    {

        return view('crm_masters.key_manage');
    }

    public function backupAll(request $request)
    {

        return view('crm_masters.backup_all');
    }



    public function changeKey(request $request)
    {
        try {
            $crm_masters = CrmMaster::all()->toArray();
            foreach ($crm_masters as $rows) {
                Config::set('database.connections.mysql.database', 'cgcrm_' . $rows['crm_name']);
                DB::purge('mysql');
                if ($rows['crm_type'] == 1) {
                    if (Schema::hasTable($rows['crm_name'] . '_client_data')) {
                        try {
                            $mdName = $rows['crm_name'] . '_client_data';
                            $get_data =  "App\Models\\$mdName"::all()->toArray();
                            if (!empty($get_data)) {
                                if (Schema::hasTable($rows['crm_name'] . '_client_data_temp')) {
                                    DB::statement("DROP table " . $rows['crm_name'] . "_client_data_temp");
                                    DB::statement("CREATE TABLE " . $rows['crm_name'] . "_client_data_temp LIKE " . $rows['crm_name'] . "_client_data");
                                } else {
                                    DB::statement("CREATE TABLE " . $rows['crm_name'] . "_client_data_temp LIKE " . $rows['crm_name'] . "_client_data");
                                }
                                foreach ($get_data as $value) {
                                    $value['created_at']  = date('Y-m-d H:i:s', strtotime($value['created_at']));
                                    $value['updated_at']  = date('Y-m-d H:i:s', strtotime($value['updated_at']));
                                    DB::table($rows['crm_name'] . "_client_data_temp")->insert($value);
                                }
                            }
                        } catch (\Throwable $ex) {
                            $request->session()->flash('error', $ex->getMessage() . 'Line:' . $ex->getLine());
                            return redirect()->back();
                        }
                    }
                } else {

                    if (Schema::hasTable($rows['crm_name'] . '_agent_input')) {
                        try {
                            $mdName = $rows['crm_name'] . '_agent_input';
                            $get_data =  "App\Models\\$mdName"::all()->toArray();
                            if (!empty($get_data)) {
                                if (Schema::hasTable($rows['crm_name'] . '_agent_input_temp')) {
                                    DB::statement("DROP table " . $rows['crm_name'] . "_agent_input_temp");
                                    DB::statement("CREATE TABLE " . $rows['crm_name'] . "_agent_input_temp LIKE " . $rows['crm_name'] . "_agent_input");
                                } else {
                                    DB::statement("CREATE TABLE " . $rows['crm_name'] . "_agent_input_temp LIKE " . $rows['crm_name'] . "_agent_input");
                                }
                                foreach ($get_data as $value) {
                                    $value['created_at']  = date('Y-m-d H:i:s', strtotime($value['created_at']));
                                    $value['updated_at']  = date('Y-m-d H:i:s', strtotime($value['updated_at']));
                                    DB::table($rows['crm_name'] . "_agent_input_temp")->insert($value);
                                }
                            }
                        } catch (\Throwable $ex) {
                            $request->session()->flash('error', $ex->getMessage() . 'Line:' . $ex->getLine());
                            return redirect()->back();
                        }
                    }
                }
            }
            Config::set('database.connections.mysql.database', env('DB_DATABASE'));
            DB::purge('mysql');
            DB::table('crm_key_log')->insert(['user_id' => Auth::user()->id, 'crm_old_key' => env('APP_KEY')]);
            Artisan::call("key:generate");
            return redirect('/login');
        } catch (\Throwable $ex) {
            $request->session()->flash('error', $ex->getMessage() . 'Line:' . $ex->getLine());
            return redirect()->back();
        }
    }



    public function getBackup(request $request)
    {

        try {

            $crm_masters = CrmMaster::all()->toArray();
            foreach ($crm_masters as $rows) {
                Config::set('database.connections.mysql.database', 'cgcrm_' . $rows['crm_name']);
                DB::purge('mysql');
                if ($rows['crm_type'] == 1) {
                    if (Schema::hasTable($rows['crm_name'] . '_client_data')) {
                        $mdName = $rows['crm_name'] . '_client_data';
                        if (Schema::hasTable($rows['crm_name'] . '_client_data_temp')) {
                            $get_all_data_old =  DB::table($rows['crm_name'] . '_client_data_temp')->get()->toArray();
                            if (!empty($get_all_data_old)) {
                                DB::statement("truncate table " . $rows['crm_name'] . "_client_data");
                                foreach ($get_all_data_old as $value_new) {
                                    "App\Models\\$mdName"::create(json_decode(json_encode($value_new), true));
                                }
                                DB::statement("truncate table " . $rows['crm_name'] . "_client_data_temp");
                            }
                        }
                    }
                } else {
                    if (Schema::hasTable($rows['crm_name'] . '_agent_input')) {
                        $mdName = $rows['crm_name'] . '_agent_input';
                        if (Schema::hasTable($rows['crm_name'] . '_agent_input_temp')) {
                            $get_all_data_old =  DB::table($rows['crm_name'] . '_agent_input_temp')->get()->toArray();
                            if (!empty($get_all_data_old)) {
                                DB::statement("truncate table " . $rows['crm_name'] . "_agent_input");
                                foreach ($get_all_data_old as $value_new) {
                                    "App\Models\\$mdName"::create(json_decode(json_encode($value_new), true));
                                }
                                DB::statement("truncate table " . $rows['crm_name'] . "_agent_input_temp");
                            }
                        }
                    }
                }
            }
            $request->session()->flash('success', 'Backup Done Succesfully!');
            return redirect()->back();
        } catch (\Throwable $ex) {
            $request->session()->flash('error', $ex->getMessage() . 'Line:' . $ex->getLine());
            return redirect()->back();
        }
    }



    public function getUniquePara(Request $request)
    {


        Config::set('database.connections.mysql.database', 'cgcrm_' . explode('_client_data', $request->crm_name)[0]);
        DB::purge('mysql');
        $getFormName = CrmForm::where('form_name', $request->crm_name)->first();

        if ($CrmFormField  = CrmFormField::where('crm_form_id', $getFormName->id)->where('is_unique', 'yes')->get()) {

            $list_dropdown = '';
            foreach ($CrmFormField as $rows) {
                $list_dropdown .= "<option value='$rows->field_name'>$rows->field_name</option>";
            }
            return $list_dropdown;
        }
    }

}
