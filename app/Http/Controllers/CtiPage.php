<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use DB;
use Excel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;


use App\Models\User;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client as GuzzleClient;
use Mail;
use App\Models\UserCrm;
use App\Models\CrmMaster;
use App\Models\CrmBranding;
use App\Models\CrmForm;
use App\Models\CrmFormField;
use App\Models\CrmFormFieldOption;
use App\Models\CrmCampaign;
use Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use Tymon\JWTAuth\Contracts\JWTSubject;
use App\Models\crmFieldDependencie;
use Illuminate\Support\Facades\Crypt;
use Config;
use Hash;

class CtiPage extends Controller
{

    public function __construct()
    {
        // if(request()->segment(1)) {
        //     $ext_crm = CrmMaster::where('crm_name', request()->segment(1))->first();
        //     if(empty($ext_crm)){
        //         die('Not Found This CRM');
        //     }
        // }

        if ($db = request()->segment(1)) {
            Config::set('database.connections.mysql.database', 'cgcrm_'.$db);
            DB::purge('mysql');
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        try {

            $current_uri = request()->segments();
            $table = $current_uri[2];
            $db = $current_uri[0];
            if (empty($table)) {
                die("Can't empty Cti page name");
            }

            Config::set('database.connections.mysql.database', 'cgcrm_'.$db);
            DB::purge('mysql');

            $user_data =  DB::table('users')->where('emp_id', $request->query('userid'))->first();
            if (empty($user_data)) {
                die("Can't Find this user");
            }

            $form_name = DB::select("SELECT * FROM crm_forms where form_name ='" . $table . "' Limit 1");
            if (empty($form_name)) {
                die("Can't Find cti page name");
            }

            $dep_id = $form_name[0]->cti_depend_form;
            $dep_form_name = DB::select("SELECT * FROM crm_forms where id ='" . $dep_id . "' Limit 1");
            if (empty($dep_form_name)) {
                die("This cti page not link with user input form");
            }

            $table_agent_input = $dep_form_name[0]->form_name;
            $tid = $dep_form_name[0]->id;

            if (empty($request->query())) {

                die("Please pass your unique parameters to url");
            }
            $where = array();
            $fielNAme = '';
            $fielVal = '';
            foreach ($request->query() as $key => $val) {
                if ($key != 'userid') {
                    $fielNAme = $key;
                    $fielVal = $val;
                    $ret[$key] =  $val;
                    $where[] = "$key,$val";
                }
            }
            $slash = "\\";
            $mdName = $slash . $table_agent_input;
            if (sizeof($where) == 1) {
                $whereArr = explode(",", $where[0]);
                $param = $whereArr[0];
                $param1 = $whereArr[1];
                $agent_input_data[] = "App\Models$mdName"::whereEncrypted($param, $param1)->first();
            } else {
                $whereArr = explode(",", $where[0]);
                $param = $whereArr[0];
                $param1 = $whereArr[1];
                $abc = "App\Models$mdName"::whereEncrypted($param, $param1);
                for ($i = 0; $i < sizeof($where); $i++) {
                    if ($i > 0) {
                        $whereArr = explode(",", $where[$i]);
                        $param = $whereArr[0];
                        $param1 = $whereArr[1];
                        $abc = $abc->whereEncrypted($param, $param1);
                    }
                }
                $agent_input_data[] = $abc->first();
            }
            $agent_input_data = json_decode(json_encode($agent_input_data));
            if (empty($agent_input_data[0])) {

                die("Invalid parameters or can't find data");
            }

            $from_data_id = $agent_input_data[0]->id;
            $crmform  = CrmForm::where('form_name', $table)->first();
            if ($crmform) {
                $crm_fields  = CrmFormField::where('crm_form_id', $crmform->id)->orderby('sortBy', 'asc')->get();
                $dep_filed = crmFieldDependencie::where('crm_id', $crmform->id)->orderBy('id', 'DESC')->get()->toArray();
                $row_child = [];
                $row_parent = [];
                if ($dep_filed) {
                    foreach ($dep_filed as $dep_rows) {
                        $row_child[] = $dep_rows['dropdown_id_from'];
                        $row_parent[] = $dep_rows['dropdown_id'];
                    }
                }

                Config::set('database.connections.mysql.database', env('DB_DATABASE'));
                DB::purge('mysql');
                $current_uri = request()->segments();
                $brand_data = CrmBranding::where('crm_id', $current_uri[0])->first();
                if (empty($brand_data)) {
                    die('No Branding Found For This Crm, Please Contact your Admin !');
                }
                Config::set('database.connections.mysql.database', 'cgcrm_'.$db);
                DB::purge('mysql');
                // dd($brand_data);

                $crm_input_history = DB::table('crm_input_history')->where('field_id', $from_data_id)->where('form_id', $form_name[0]->id)->get();
                return view('uploadform.open_agent_cti')->with(compact('crm_fields', 'crmform', 'from_data_id', 'tid', 'agent_input_data', 'user_data', 'crm_input_history', 'row_parent', 'row_child', 'brand_data'));
            } else {
                return view('error');
            }

            return view('uploadform.open_agent_cti');
            return back();
        } catch (\Throwable $ex) {
            // echo $ex->getMessage().'Line:'.$ex->getLine();
            // die($ex->getMessage() . 'Line:' . $ex->getLine());
            $request->session()->flash('error', $ex->getMessage() . 'Line:' . $ex->getLine());
            return redirect()->back();
        }
    }

    public function dummyDailerOpen(Request $request, $id)
    {

        return json_encode($request->query());
    }

    public function openAddChildField(Request $request)
    {


        Config::set('database.connections.mysql.database', 'cgcrm_'.explode('_agent_input', $request->form_name)[0]);
        DB::purge('mysql');

        $data =  DB::select("SELECT * FROM crm_field_options AS fo INNER JOIN crm_fields AS cf ON fo.crm_filed_id = cf.id WHERE cf.crm_form_id = ( SELECT crm_form_id FROM `crm_fields` WHERE  `id` = $request->crm_filed_id ) and fo.parent_name = '$request->parent_name' ");

        if (!empty($data)) {
            $ret = $data;
            return \Response::json(['html' => $ret, 'status' => 'success', 'child' => 'success']);
        } else {
            $data =  DB::select("SELECT id FROM `crm_fields` WHERE field_depend = (SELECT field_name FROM `crm_fields` WHERE id = $request->crm_filed_id limit 1)");
            $ret = $data;
            return \Response::json(['html' => $ret, 'status' => 'success', 'child' => 'failed']);
        }
    }


    public function openSubmitAgentForm(REQUEST $request)
    {
        try {
            $input = $request->all();
            $input_new = $request->all();
            $my_uniue = [];
            $f_my_unique = [];
            $slash = "\\";
            $where = array();
            $mdName = $slash . $request->form_name;

            Config::set('database.connections.mysql.database', 'cgcrm_'.explode('_agent_input', $request->form_name)[0]);
            DB::purge('mysql');

            foreach ($input as $key => $value) {
                if (is_array($value)) {
                    $input[$key] = implode(',', $value);
                }
            }

            $crm_fields  = CrmFormField::where('crm_form_id', $input['form_id'])->where('is_unique', 'yes')->orderby('sortBy', 'desc')->get();
            foreach ($crm_fields as $get_unique) {
                $my_uniue[] = $get_unique->field_name;
            }
            foreach ($input as $inputs_key => $inputs) {
                foreach ($my_uniue as $my_uniues) {
                    if ($inputs_key == $my_uniues) {
                        $f_my_unique[$my_uniues] = $inputs;
                        $where[] = "$my_uniues,$inputs";
                    }
                }
            }
            if (!empty($f_my_unique)) {

                if (sizeof($where) == 1) {
                    $whereArr = explode(",", $where[0]);
                    $param = $whereArr[0];
                    $param1 = $whereArr[1];
                    $search_agent_input_data = "App\Models$mdName"::orWhereEncrypted($param, $param1)->get()->toArray();
                } else {
                    $whereArr = explode(",", $where[0]);
                    $param = $whereArr[0];
                    $param1 = $whereArr[1];
                    $abc = "App\Models$mdName"::orWhereEncrypted($param, $param1);
                    for ($i = 0; $i < sizeof($where); $i++) {
                        if ($i > 0) {

                            $whereArr = explode(",", $where[$i]);
                            $param = $whereArr[0];
                            $param1 = $whereArr[1];
                            $abc = $abc->orWhereEncrypted($param, $param1);
                        }
                    }
                    $search_agent_input_data = $abc->get()->toArray();
                }
                if (!empty($search_agent_input_data)) {
                    $request->session()->flash('error', 'Dublicate entry!');
                    return redirect()->back();
                }
            }
            foreach ($input as $key => $value) {
                if (is_array($value)) {
                    $input[$key] = implode(',', $value);
                }
            }
            unset($input['_token']);
            unset($input['form_id']);
            unset($input['form_name']);
            unset($input_new['_token']);

            $audit['form_id'] = $input_new['form_id'];
            $audit['form_name'] = $input_new['form_name'];
            $audit['field_id'] = $input_new['from_data_id'];
            $audit['created_by'] = $input_new['created_by'];

            unset($input_new['form_id']);
            unset($input_new['form_name']);
            unset($input_new['from_data_id']);
            unset($input_new['tid']);
            unset($input_new['created_by']);

            $get_user_detail = User::where('id', $input['created_by'])->first();

            $audit2['data']['creater_by'] = $get_user_detail->emp_id;
            $audit2['data']['creater_type'] = $get_user_detail->emp_type;
            $audit2['data']['audit_trail'] = $input_new;
            $audit2['data']['created_date'] = date('Y-m-d H:i:s');
            $audit['data'] = json_encode($audit2);

            DB::table('crm_input_history')->insert($audit);
            //    DB::table($request->form_name)->insert($input);
            "App\Models$mdName"::create($input);
            $request->session()->flash('success', 'Data Insert Successfully ');
            return back();
        } catch (\Throwable $ex) {
            $request->session()->flash('error', $ex->getMessage() . 'Line:' . $ex->getLine());
            return redirect()->back();
        }
    }


    public function openSubmitAgentFormWithOut(REQUEST $request)
    {
        try {
            //    dd($request);

            $input = $request->all();
            $input_new = $request->all();
            $my_uniue = [];
            $f_my_unique = [];
            $where = array();

            $slash = "\\";
            $mdName = $slash . $request->form_name;
            Config::set('database.connections.mysql.database', 'cgcrm_'.explode('_agent_input', $request->form_name)[0]);
            DB::purge('mysql');

            $old_url = $input['old_url'];
            foreach ($input as $key => $value) {
                if (is_array($value)) {
                    $input[$key] = implode(',', $value);
                }
            }
            $crm_fields  = CrmFormField::where('crm_form_id', $input['form_id'])->where('is_unique', 'yes')->orderby('sortBy', 'desc')->get();
            foreach ($crm_fields as $get_unique) {
                $my_uniue[] = $get_unique->field_name;
            }
            foreach ($input as $inputs_key => $inputs) {
                foreach ($my_uniue as $my_uniues) {
                    if ($inputs_key == $my_uniues) {
                        $f_my_unique[$my_uniues] = $inputs;
                        $where[] = "$my_uniues,$inputs";
                    }
                }
            }

            if (!empty($f_my_unique)) {
                if (sizeof($where) == 1) {
                    $whereArr = explode(",", $where[0]);
                    $param = $whereArr[0];
                    $param1 = $whereArr[1];
                    $search_agent_input_data = "App\Models$mdName"::orWhereEncrypted($param, $param1)->get()->toArray();
                } else {
                    $whereArr = explode(",", $where[0]);
                    $param = $whereArr[0];
                    $param1 = $whereArr[1];
                    $abc = "App\Models$mdName"::orWhereEncrypted($param, $param1);
                    for ($i = 0; $i < sizeof($where); $i++) {
                        if ($i > 0) {

                            $whereArr = explode(",", $where[$i]); //openSearchAgentDataRandom
                            $param = $whereArr[0];
                            $param1 = $whereArr[1];
                            $abc = $abc->orWhereEncrypted($param, $param1);
                        }
                    }
                    $search_agent_input_data = $abc->get()->toArray();
                }
                if (!empty($search_agent_input_data)) {
                    $request->session()->flash('error', 'Dublicate entry!');
                    return redirect()->to($old_url);
                }
            }

            unset($input['_token']);
            unset($input['form_id']);
            unset($input['form_name']);
            unset($input['old_url']);
            unset($input_new['_token']);

            $audit['form_id'] = $input_new['form_id'];
            $audit['form_name'] = $input_new['form_name'];
            $audit['field_id'] = $input_new['from_data_id'];
            $audit['created_by'] = $input_new['created_by'];

            unset($input_new['form_id']);
            unset($input_new['form_name']);
            unset($input_new['from_data_id']);
            unset($input_new['tid']);
            unset($input_new['created_by']);
            unset($input_new['old_url']);

            $audit2['data']['creater_by'] = Auth::user()->emp_id;
            $audit2['data']['creater_type'] = Auth::user()->emp_type;
            $audit2['data']['audit_trail'] = $input_new;
            $audit2['data']['created_date'] = date('Y-m-d H:i:s');
            $audit['data'] = json_encode($audit2);
            DB::table('crm_input_history')->insert($audit);
            "App\Models$mdName"::create($input);
            $request->session()->flash('success', 'Data Insert Successfully ');
            return redirect()->to($old_url);
        } catch (\Throwable $ex) {
            $request->session()->flash('error', $ex->getMessage() . 'Line:' . $ex->getLine());
            return redirect()->to($old_url);
        }
    }



    public function openSearchAgentData(REQUEST $request)
    {

        try {
            //    dd($request);
            $input = $request->all();
            $table_agent_input = $input['table_agent_input'];
            $crmform = $input['crmform'];
            $user_get_id = $input['user_get_id'];
            $old_url = $input['old_url'];
            $crmform = json_decode($crmform);
            $crmform = $crmform->form_name;



            $user_data =  DB::table('users')->where('emp_id', $user_get_id)->first();
            Config::set('database.connections.mysql.database', 'cgcrm_'.explode('_client_data', $table_agent_input)[0]);
            DB::purge('mysql');
            $crmform  = CrmForm::where('form_name', $crmform)->first();
            $data_agent_input = CrmForm::where('form_name', $table_agent_input)->first();
            $slash = "\\";
            $mdName = $slash . $request->table_agent_input;
            $where = array();

            foreach ($input as $key => $val) {
                if ($key != '_token' && $key != 'tid' && $key != 'table_agent_input' && $key != 'crmform' && $key != 'user_get_id' && $key != 'old_url' && $key != 'from_data_id') {
                    $ret[$key] = $val;
                    $where[] = "$key,$val";
                }
            }

            $dep_form_name = DB::select("SELECT * FROM crm_forms where form_name ='" . $table_agent_input . "' Limit 1");
            $tid = $dep_form_name[0]->id;


            if (sizeof($where) == 1) {
                $whereArr = explode(",", $where[0]);
                $param = $whereArr[0];
                $param1 = $whereArr[1];
                $search_agent_input_data[] = "App\Models$mdName"::orWhereEncrypted($param, $param1)->first();
            } else {
                $whereArr = explode(",", $where[0]);
                $param = $whereArr[0];
                $param1 = $whereArr[1];
                $abc = "App\Models$mdName"::orWhereEncrypted($param, $param1);
                for ($i = 0; $i < sizeof($where); $i++) {
                    if ($i > 0) {

                        $whereArr = explode(",", $where[$i]);
                        $param = $whereArr[0];
                        $param1 = $whereArr[1];
                        $abc = $abc->orWhereEncrypted($param, $param1);
                    }
                }

                 $search_agent_input_data[] = $abc->first();

            }
            $search_agent_input_data = json_decode(json_encode($search_agent_input_data));

            if (empty($search_agent_input_data[0])) {

                $request->session()->flash('error', 'Record Not Found');
                return redirect()->to($old_url);
            }

            $from_data_id = $search_agent_input_data[0]->id;

            if ($crmform) {

                // dd($crmform->id,$request->from_data_id);
                $crm_input_history = DB::table('crm_input_history')->where('form_id', $crmform->id)->where('field_id', $from_data_id)->get();
                // dd($crm_input_history);
                $crm_fields  = CrmFormField::where('crm_form_id', $crmform->id)->orderby('sortBy', 'asc')->get();
                $agent_input_data  = CrmFormField::where('crm_form_id', $data_agent_input->id)->where('is_unique', 'yes')->orderby('sortBy', 'asc')->get();
                $dep_filed = crmFieldDependencie::where('crm_id', $crmform->id)->orderBy('id', 'DESC')->get()->toArray();
                $row_child = [];
                $row_parent = [];
                if ($dep_filed) {
                    foreach ($dep_filed as $dep_rows) {
                        $row_child[] = $dep_rows['dropdown_id_from'];
                        $row_parent[] = $dep_rows['dropdown_id'];
                    }
                }
                return view('uploadform.open_agent_without_cti')->with(compact('crm_fields', 'crmform', 'tid', 'agent_input_data', 'user_data', 'table_agent_input', 'search_agent_input_data', 'user_get_id', 'from_data_id', 'old_url', 'crm_input_history', 'row_child', 'row_parent'));
            } else {

                return view('error');
            }
        } catch (\Throwable $ex) {
            $request->session()->flash('error', $ex->getMessage() . 'Line:' . $ex->getLine());
            return redirect()->back();
        }
    }


    public function openSearchAgentDataRandom(REQUEST $request)
    {

        try {
            $input = $request->all();
            $table_agent_input = $input['table_agent_input'];
            $crmform = $input['crmform'];
            $user_get_id = $input['user_get_id'];
            $old_url = $input['old_url'];
            $crmform = json_decode($crmform);
            $crmform = $crmform->form_name;
            $user_data =  DB::table('users')->where('emp_id', $user_get_id)->first();

            Config::set('database.connections.mysql.database', 'cgcrm_'.explode('_client_data', $table_agent_input)[0]);
            DB::purge('mysql');
            $crmform  = CrmForm::where('form_name', $crmform)->first();
            $data_agent_input = CrmForm::where('form_name', $table_agent_input)->first();
            $slash = "\\";
            $mdName = $slash . $table_agent_input;

            foreach ($input as $key => $val) {
                if ($key != '_token' && $key != 'tid' && $key != 'table_agent_input' && $key != 'crmform' && $key != 'user_get_id' && $key != 'old_url') {
                    $ret[$key] = $val;
                }
            }

            $dep_form_name = DB::select("SELECT * FROM crm_forms where form_name ='" . $table_agent_input . "' Limit 1");
            $tid = $dep_form_name[0]->id;

            $search_agent_input_data = "App\Models$mdName"::where('lead_status', '0')->inRandomOrder()->limit(1)->get()->toArray();
            $search_agent_input_data = json_decode(json_encode($search_agent_input_data));

            if (count($search_agent_input_data) == 0) {
                $request->session()->flash('error', 'Record Not Found');
                return redirect()->to($old_url);
            }

            DB::table($table_agent_input)
                ->where('id', $search_agent_input_data[0]->id)
                ->update(['lead_status' => '1']);

            $from_data_id = $search_agent_input_data[0]->id;

            if ($crmform) {
                Config::set('database.connections.mysql.database', 'cgcrm_'.explode('_client_data', $table_agent_input)[0]);
                DB::purge('mysql');
                $crm_fields  = CrmFormField::where('crm_form_id', $crmform->id)->orderby('sortBy', 'asc')->get();
                // dd( $data_agent_input->id);
                $agent_input_data  = CrmFormField::where('crm_form_id', $data_agent_input->id)->where('is_unique', 'yes')->orderby('sortBy', 'asc')->get();
                $dep_filed = crmFieldDependencie::where('crm_id', $crmform->id)->orderBy('id', 'DESC')->get()->toArray();
                $row_child = [];
                $row_parent = [];
                if (!empty($dep_filed)) {
                    foreach ($dep_filed as $dep_rows) {
                        $row_child[] = $dep_rows['dropdown_id_from'];
                        $row_parent[] = $dep_rows['dropdown_id'];
                    }
                }
                return view('uploadform.open_agent_without_cti_random')->with(compact('crm_fields', 'crmform', 'tid', 'agent_input_data', 'user_data', 'table_agent_input', 'search_agent_input_data', 'user_get_id', 'from_data_id', 'old_url', 'row_child', 'row_parent'));
            } else {

                return view('error');
            }
        } catch (\Throwable $ex) {
            $request->session()->flash('error', $ex->getMessage() . 'Line:' . $ex->getLine());
            return redirect()->to($old_url);
        }
    }



    public function testCti(REQUEST $request, $db, $fr)
    {

        dd($request);
    }

    public function openWithoutCti(REQUEST $request)
    {


        try {

            $current_uri = request()->segments();
            $table = $current_uri[2];
            $agent_input_table = $request->query('agent_input');

            $old_url = $request->fullUrl();
            if (empty($table)) {
                die("Can't empty Cti page name");
            }

            $user_data =  DB::table('users')->where('emp_id', Auth::user()->emp_id)->first();

            if (empty($user_data)) {
                die("Can't Find this user");
            }
            $user_get_id = Auth::user()->emp_id;
            $form_name = DB::select("SELECT * FROM crm_forms where form_name ='" . $table . "' Limit 1");

            if (empty($form_name)) {
                die("Can't Find cti page name");
            }

            $dep_id = $form_name[0]->cti_depend_form;

            $dep_form_name = DB::select("SELECT * FROM crm_forms where id ='" . $dep_id . "' Limit 1");

            if (empty($dep_form_name)) {
                die("This cti page not link with user input form");
            }

            $table_agent_input = $dep_form_name[0]->form_name;
            $tid = $dep_form_name[0]->id;
            $crmform  = CrmForm::where('form_name', $table)->first();
            $agent_input_data = CrmForm::where('form_name', $agent_input_table)->first();
            $from_data_id = '';

            if ($crmform) {
                $crm_fields  = CrmFormField::where('crm_form_id', $crmform->id)->orderby('sortBy', 'asc')->get();
                $agent_input_data  = CrmFormField::where('crm_form_id', $agent_input_data->id)->where('is_unique', 'yes')->orderby('sortBy', 'asc')->get();
                $crm_input_history = DB::table('crm_input_history')->where('field_id', $from_data_id)->where('form_id', $form_name[0]->id)->get();
                $dep_filed = crmFieldDependencie::where('crm_id', $crmform->id)->orderBy('id', 'DESC')->get()->toArray();
                $row_child = [];
                $row_parent = [];
                if ($dep_filed) {
                    foreach ($dep_filed as $dep_rows) {
                        $row_child[] = $dep_rows['dropdown_id_from'];
                        $row_parent[] = $dep_rows['dropdown_id'];
                    }
                }
                return view('uploadform.open_agent_without_cti')->with(compact('crm_fields', 'crmform', 'tid', 'agent_input_data', 'user_data', 'table_agent_input', 'user_get_id', 'from_data_id', 'old_url', 'crm_input_history', 'row_child', 'row_parent'));
            } else {
                return view('error');
            }

            return view('uploadform.open_agent_without_cti');
            return back();
        } catch (\Throwable $ex) {

            // dd($ex->getMessage().'Line:'.$ex->getLine());
            $request->session()->flash('error', $ex->getMessage() . 'Line:' . $ex->getLine());
            return redirect()->back();
        }
    }



    public function openWithoutCtiRandom(REQUEST $request)
    {


        try {

            $current_uri = request()->segments();
            $table = $current_uri[2];
            $agent_input_table = $request->query('agent_input');
            $old_url = $request->fullUrl();
            if (empty($table)) {
                die("Can't empty Cti page name");
            }

            $user_data =  DB::table('users')->where('emp_id', Auth::user()->emp_id)->first();
            if (empty($user_data)) {
                die("Can't Find this user");
            }

            $user_get_id = Auth::user()->emp_id;
            Config::set('database.connections.mysql.database', 'cgcrm_'.explode('_client_data', $agent_input_table)[0]);
            DB::purge('mysql');

            $form_name = DB::select("SELECT * FROM crm_forms where form_name ='" . $table . "' Limit 1");
            if (empty($form_name)) {
                die("Can't Find cti page name");
            }

            $dep_id = $form_name[0]->cti_depend_form;
            $dep_form_name = DB::select("SELECT * FROM crm_forms where id ='" . $dep_id . "' Limit 1");

            if (empty($dep_form_name)) {
                die("This cti page not link with user input form");
            }

            $table_agent_input = $dep_form_name[0]->form_name;
            $tid = $dep_form_name[0]->id;
            $crmform  = CrmForm::where('form_name', $table)->first();
            $agent_input_data = CrmForm::where('form_name', $agent_input_table)->first();

            $from_data_id = '';

            if ($crmform) {
                $crm_fields  = CrmFormField::where('crm_form_id', $crmform->id)->orderby('sortBy', 'asc')->get();
                $agent_input_data  = CrmFormField::where('crm_form_id', $agent_input_data->id)->where('is_unique', 'yes')->orderby('sortBy', 'asc')->get();
                $dep_filed = crmFieldDependencie::where('crm_id', $crmform->id)->orderBy('id', 'DESC')->get()->toArray();
                $row_child = [];
                $row_parent = [];
                if ($dep_filed) {
                    foreach ($dep_filed as $dep_rows) {
                        $row_child[] = $dep_rows['dropdown_id_from'];
                        $row_parent[] = $dep_rows['dropdown_id'];
                    }
                }
                return view('uploadform.open_agent_without_cti_random')->with(compact('crm_fields', 'crmform', 'tid', 'agent_input_data', 'user_data', 'table_agent_input', 'user_get_id', 'from_data_id', 'old_url', 'row_child', 'row_parent'));
            } else {
                return view('error');
            }

            return view('uploadform.open_agent_without_cti_random');
            return back();
        } catch (\Throwable $ex) {
            $request->session()->flash('error', $ex->getMessage() . 'Line:' . $ex->getLine());
            return redirect()->back();
        }
    }







    public function standAlone(Request $request)
    {

        try {

            $current_uri = request()->segments();
            $table = $current_uri[2];
            if (empty($table)) {
                die("Can't empty Cti page name");
            }
            Config::set('database.connections.mysql.database', 'cgcrm_'.explode('_agent_input', $table)[0]);
            DB::purge('mysql');
            $form_name = DB::select("SELECT * FROM crm_forms where form_name ='" . $table . "' Limit 1");
            if (empty($form_name)) {
                die("Can't Find cti page name");
            }
            $tid = 'NA';
            $agent_input_data[] = '';
            $from_data_id = 'NA';
            $crmform  = CrmForm::where('form_name', $table)->first();
            if ($crmform) {
                $crm_fields  = CrmFormField::where('crm_form_id', $crmform->id)->orderby('sortBy', 'asc')->get();
                $dep_filed = crmFieldDependencie::where('crm_id', $crmform->id)->orderBy('id', 'DESC')->get()->toArray();
                $row_child = [];
                $row_parent = [];
                if ($dep_filed) {
                    foreach ($dep_filed as $dep_rows) {
                        $row_child[] = $dep_rows['dropdown_id_from'];
                        $row_parent[] = $dep_rows['dropdown_id'];
                    }
                }
                return view('uploadform.open_agent_stand_alone_cti')->with(compact('crm_fields', 'crmform', 'from_data_id', 'tid', 'agent_input_data', 'row_child', 'row_parent'));
            } else {
                return view('error');
            }
            return view('uploadform.open_agent_stand_alone_cti');
            return back();
        } catch (\Throwable $ex) {
            $request->session()->flash('error', $ex->getMessage() . 'Line:' . $ex->getLine());
            return redirect()->back();
        }
    }





    public function standAloneSubmit(REQUEST $request)
    {
        try {
            $input = $request->all();
            $my_uniue = [];
            $f_my_unique = [];



            foreach ($input as $key => $value) {
                if (is_array($value)) {
                    $input[$key] = implode(',', $value);
                }
            }
            Config::set('database.connections.mysql.database', 'cgcrm_'.explode('_agent_input', $input['form_name'])[0]);
            DB::purge('mysql');
            $crm_fields  = CrmFormField::where('crm_form_id', $input['form_id'])->where('is_unique', 'yes')->orderby('sortBy', 'desc')->get();
            foreach ($crm_fields as $get_unique) {
                $my_uniue[] = $get_unique->field_name;
            }
            foreach ($input as $inputs_key => $inputs) {
                foreach ($my_uniue as $my_uniues) {
                    if ($inputs_key == $my_uniues) {
                        $f_my_unique[$my_uniues] = $inputs;
                        $where[] = "$my_uniues,$inputs";
                    }
                }
            }


            $slash = "\\";
            $mdName = $slash . $request->form_name;

            if (!empty($f_my_unique)) {
                if (sizeof($where) == 1) {
                    $whereArr = explode(",", $where[0]);
                    $param = $whereArr[0];
                    $param1 = $whereArr[1];
                    $search_agent_input_data = "App\Models$mdName"::orWhereEncrypted($param, $param1)->get()->toArray();
                } else {
                    $whereArr = explode(",", $where[0]);
                    $param = $whereArr[0];
                    $param1 = $whereArr[1];
                    $abc = "App\Models$mdName"::orWhereEncrypted($param, $param1);
                    for ($i = 0; $i < sizeof($where); $i++) {
                        if ($i > 0) {

                            $whereArr = explode(",", $where[$i]);
                            $param = $whereArr[0];
                            $param1 = $whereArr[1];
                            $abc = $abc->orWhereEncrypted($param, $param1);
                        }
                    }
                    $search_agent_input_data = $abc->get()->toArray();
                }
                if (!empty($search_agent_input_data)) {
                    $request->session()->flash('error', 'Dublicate entry!');
                    return redirect()->back();
                }
            }


            foreach ($input as $key => $value) {
                if (is_array($value)) {
                    $input[$key] = implode(',', $value);
                }
            }
            unset($input['_token']);
            unset($input['form_id']);
            unset($input['form_name']);
            $slash = "\\";
            $mdName = $slash . $request->form_name;
            "App\Models$mdName"::create($input);
            $request->session()->flash('success', 'Data Insert Successfully ');
            return back();
        } catch (\Throwable $ex) {
            $request->session()->flash('error', $ex->getMessage() . 'Line:' . $ex->getLine());
            return redirect()->back();
        }
    }



    public function clearChunk(Request $request, $table_name)
    {
        try {
            Config::set('database.connections.mysql.database', 'cgcrm_'.explode('_client_data', $table_name)[0]);
            DB::purge('mysql');
            $form_name_cdata =  CrmForm::where('form_name', $table_name)->first();
            if (!empty($form_name_cdata) && $form_name_cdata) {
                $agent_form =  $form_name_cdata->form_name;
                $form_name_cti =  CrmForm::where('cti_depend_form', $form_name_cdata->id)->first();
                if (!empty($form_name_cti) && $form_name_cdata) {
                    $cti_table_name =  $form_name_cti->form_name;
                    $fetch_chunk = DB::select("SELECT * from $agent_form where id NOT IN (select from_data_id from $cti_table_name) or lead_status ='0'");
                    if (!empty($fetch_chunk) && $fetch_chunk) {
                        foreach ($fetch_chunk as $get_chunk) {
                            DB::select("UPDATE $agent_form SET lead_status = '0' where id = $get_chunk->id ");
                        }
                        $request->session()->flash('success', 'Chunk clear Succesfully');
                        return redirect()->back();
                    } else {

                        $request->session()->flash('error', 'Sorry !! Chunk not found');
                        return redirect()->back();
                    }
                } else {

                    $request->session()->flash('error', 'Can not found cti page for this client data');
                    return redirect()->back();
                }
            } else {
                $request->session()->flash('error', 'Invalid client data form');
                return redirect()->back();
            }
        } catch (\Throwable $ex) {
            $request->session()->flash('error', 'Something went wrong');
            return redirect()->back();
        }
    }

    function checkmydate($value)
    {
        if (!$value) {
            return false;
        }
        try {
            new \DateTime($value);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }


    public function authenticate(Request $request)
    {

        $current_uri = request()->segments();
        $db = $current_uri[0];
        Config::set('database.connections.mysql.database', 'cgcrm_'.$db);
        DB::purge('mysql');
        $credentials = $request->only('emp_id', 'password');
        $validator = Validator::make($credentials, [
            'emp_id' => 'required',
            'password' => 'required|string|min:4|max:10'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request is validated
        //Crean token
        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Login credentials are invalid.',
                ], 400);
            }
        } catch (JWTException $e) {
            return $credentials;
            return response()->json([
                'success' => false,
                'message' => 'Could not create token.',
            ], 500);
        }
        //Token created, return with success response and jwt token
        return response()->json([
            'success' => true,
            'token' => $token,
        ]);
    }

    public function SubmitAgentApi(REQUEST $request)
    {
        try {

            $current_uri = request()->segments();
            $table = $current_uri[2];
            $db = $current_uri[0];
            Config::set('database.connections.mysql.database', 'cgcrm_'.$db);
            DB::purge('mysql');
            $crmform  = CrmForm::where('form_name', $table)->first();
            if (empty($crmform)) {
                $data = ['status' => 'error', 'msg' => 'invalid client data'];
                return Response::json($data);
            }
            $crmFields  = CrmFormField::where('crm_form_id', $crmform->id)->orderby('sortBy', 'desc')->get();
            $input = $request->all();
            // dd($input);
            $user = JWTAuth::user();
            // $token = JWTAuth::getToken();
            // JWTAuth::refresh($token);
            $input['created_by'] = $user->id;
            foreach ($input as $key => $rowData) {
                foreach ($crmFields as $value) {
                    if ($value->field_name == $key) {
                        $len = strlen($rowData);
                        if ($len < $value->minlength) {
                            $data = ['status' => 'error', 'msg' => "Field Name ($rowData) is too short, minimum characters ($value->minlength max)"];
                            return Response::json($data);
                        }
                        if ($len > $value->length) {
                            $data = ['status' => 'error', 'msg' => "Field Name ($rowData) is too long maximum characters ($value->length min)"];
                            return Response::json($data);
                        }
                        if ($value->is_numaric == 'yes' && !is_numeric($rowData)) {
                            $data = ['status' => 'error', 'msg' => "Field Name ($rowData) is Not Numaric"];
                            return Response::json($data);
                        }
                        if ($value->field_type == 'date_picker' && !$this->checkmydate($rowData)) {
                            $data = ['status' => 'error', 'msg' => "Invalid Date Format ($rowData)"];
                            return Response::json($data);
                        }
                        if ($value->field_type == 'mobile' && !is_numeric($rowData)) {
                            $data = ['status' => 'error', 'msg' => "Field Name ($rowData) is Not Phone no."];
                            return Response::json($data);
                        }
                    }
                }
            }
            $slash = "\\";
            $mdName = $slash . $table;
            $insResult = "App\Models$mdName"::create($input);
            if ($insResult) {
                $data = ['status' => 'success', 'msg' => 'Data Insert Successfully'];
                return Response::json($data);
            } else {
                $data = ['status' => 'error', 'msg' => 'Something went wrong!!'];
                return Response::json($data);
            }
        } catch (\Throwable $ex) {
            $data = ['status' => 'error', 'msg' => 'Something went wrong!'];
            return Response::json($data);
            // $request->session()->flash('error', $ex->getMessage().'Line:'.$ex->getLine());
        }
    }



    public function updatePasswordCti(Request $request)
	{
        try {
                $crm_name = $request->crm_name;
                Config::set('database.connections.mysql.database', 'cgcrm_' . $crm_name);
                DB::purge('mysql');
                $user = auth()->user();
                if (!Hash::check($request->old_pass, $user->password)) {
                    return 0;
                }
                if($request->new_pass != $request->conf_pass) {
                    return 1;
                }
                $user->fill([
                    'password' => Hash::make($request->new_pass)
                ])->save();
                return 2;
            } catch (\Throwable $th) {
                return 3;
            }
   }

   public function uploadCsvFormat($table)
   {

    try {
            Config::set('database.connections.mysql.database', 'cgcrm_' . explode('_client_data', $table)[0]);
            DB::purge('mysql');
            $crmform  = CrmForm::where('form_name', $table.'_client_data')->first();
            if ($crmform) {
                $crm_fields  = CrmFormField::where('crm_form_id', $crmform->id)->orderby('sortBy', 'asc')->get();
                return view('uploadform.upload_csv_agent')->with(compact('crm_fields', 'crmform'));
            } else {
                return view('error');
            }
        } catch (\Throwable $th) {
           return redirect()->back()->with('error', 'something went wrong !');
        }

   }

   public function uploadCsvFormatPost(request $request)
   {

    // dd($request->all());
       try {
           $ext = $request->file('uplaod_file')->extension();
           if ($ext == 'csv' || $ext == 'txt') {

               $campign = CrmCampaign::where('created_by', Auth::id())->where('crm_id', $request->table_name)->get();


               Config::set('database.connections.mysql.database', 'cgcrm_' . explode('_client_data', $request->table_name)[0]);
               DB::purge('mysql');
               $crmformData  = CrmForm::where('form_name', $request->table_name)->first();
               $crmformDataId = $crmformData->id;
               $crmFields  = CrmFormField::where('crm_form_id', $crmformDataId)->orderby('sortBy', 'desc')->get();

               //dd($crmFields);
               $path = $request->file('uplaod_file')->getRealPath();
               $path = str_replace('\\', '/', trim($path));
               $rows_data_find = array_map('str_getcsv', file($path));
               if (count($rows_data_find) < 2) {
                   $request->session()->flash('error', "Please insert some record in this file");
                   $url = url()->previous();
                   return redirect($url);
               }
               $get_form_format  = DB::getSchemaBuilder()->getColumnListing($request->table_name);
               $remit_new_format = [];

               foreach ($get_form_format as $remit_format) {

                   if ($remit_format != 'created_at' && $remit_format != 'created_by' && $remit_format != 'id' &&  $remit_format != 'updated_at' && $remit_format != 'tid' && $remit_format != 'lead_status' && $remit_format != 'from_data_id') {
                       $remit_new_format[] = $remit_format;
                   }
               }

               $array_diff = array_diff($rows_data_find[0], $remit_new_format);
               if (!empty($array_diff)) {
                   $request->session()->flash('error', "Please upload valid file");
                   $url = url()->previous();
                   return redirect($url);
               }

               foreach (array_slice($rows_data_find, 1) as $ext_rows) {
                   $data_validate = [];
                   foreach ($rows_data_find[0] as $gu => $gn) {
                       $data['created_by'] = Auth::id();
                       if ($gn == 'order_id') {
                           $data[$gn] = hexdec($ext_rows[$gu]);
                       }
                       foreach ($crmFields as $rowFields) {
                           if ($rowFields->field_name == $gn) {

                               $len = strlen($ext_rows[$gu]);
                               if ($len < $rowFields->minlength) {
                                   $request->session()->flash('error', "Field Name ($gn) is too short, minimum characters ($rowFields->minlength max)");
                                   $url = url()->previous();
                                   return redirect($url);
                                   die;
                               }

                               if ($len > $rowFields->length) {
                                   $request->session()->flash('error', "Field Name ($gn) is too long maximum characters ($rowFields->length min).");
                                   $url = url()->previous();
                                   return redirect($url);
                                   die;
                               }

                               if ($rowFields->is_numaric == 'yes' && !is_numeric($ext_rows[$gu])) {
                                   $request->session()->flash('error', "Field Name ($gn) is Not Numaric");
                                   $url = url()->previous();
                                   return redirect($url);
                                   die;
                               }

                               if ($rowFields->field_type == 'date_picker' && !$this->checkmydate($ext_rows[$gu])) {
                                   $request->session()->flash('error', "Invalid Date Format");
                                   $url = url()->previous();
                                   return redirect($url);
                                   die;
                               }

                               if ($rowFields->field_type == 'mobile' && !is_numeric($ext_rows[$gu]) && !$this->validate_mobile($ext_rows[$gu])) {
                                   $request->session()->flash('error', "Field Name ($gn) is Not Phone no.");
                                   $url = url()->previous();
                                   return redirect($url);
                                   die;
                               }

                               if ($rowFields->is_unique == 'yes') {
                                   $getMyData[$rowFields->field_name][] = $ext_rows[$gu];
                                   $myUniqueFiled[] = $rowFields->field_name;
                               }
                           }
                       }
                       $data[$gn] = $ext_rows[$gu] != '' ? trim($ext_rows[$gu]) : 'NA';
                       $data_validate[$gn] = $ext_rows[$gu] != '' ? trim($ext_rows[$gu]) : 'NA';
                   }
                   $array_key_data = array_values($data_validate);

                   if ($campign && !empty($campign)) {
                       foreach ($campign as $campignRow) {
                           if ($campignRow->crm_type == 2) {
                               $myUniqueFiled = array_unique($myUniqueFiled);
                               $url_data = [];
                               foreach ($myUniqueFiled as $myUniqueData) {

                                   $url_data[$myUniqueData] = $data[$myUniqueData];
                               }

                               if ($campignRow->depend_status == '0') {
                                   $fix_para['campname'] = $campignRow->camp_name;
                                   $fix_para['qname'] = $campignRow->skill_name;
                                   $fix_para['status'] = 'NEW';
                                   $fix_para['listname'] = $campignRow->list_name . date($campignRow->date_format);
                                   $dailer_data = json_encode(array_merge($fix_para, $url_data));
                                   $response = $this->callApi($campignRow->api_url, $campignRow->token_name, $dailer_data);
                                   $response_insert =  [
                                       "campaign_id" => $campignRow->id,
                                       "crm_id"  => $crmformDataId,
                                       "camp_response" => $response,
                                       "dailer_url" => $dailer_data,
                                       "api_type" => $campignRow->crm_type,
                                       "created_by" => Auth::id()
                                   ];
                                   DB::table('crm_campaigns_log')->insert($response_insert);
                               } else {

                                   if (in_array($campignRow->option_id, $array_key_data)) {
                                       $fix_para['campname'] = $campignRow->camp_name;
                                       $fix_para['qname'] = $campignRow->skill_name;
                                       $fix_para['status'] = 'NEW';
                                       $fix_para['listname'] = $campignRow->list_name . date($campignRow->date_format);
                                       $dailer_data = json_encode(array_merge($fix_para, $url_data));
                                       $response = $this->callApi($campignRow->api_url, $campignRow->token_name, $dailer_data);
                                       $response_insert =  [
                                           "campaign_id" => $campignRow->id,
                                           "crm_id"  => $crmformDataId,
                                           "camp_response" => $response,
                                           "dailer_url" => $dailer_data,
                                           "api_type" => $campignRow->crm_type,
                                           "created_by" => Auth::id()
                                       ];
                                       DB::table('crm_campaigns_log')->insert($response_insert);
                                   }
                               }
                           } else {
                               try {
                                   $api_parameters = json_decode($campignRow->api_parameters, true);
                                   $api_url = $campignRow->api_url . '&domainname=' . $campignRow->domain_name . '&campname=' . $campignRow->camp_name . '&qname=' . $campignRow->q_name . '&listname=' . $campignRow->list_name . '&status=NEW&skillname=' . $campignRow->skill_name;

                                   foreach ($api_parameters as $keys => $rows_url) {
                                       $api_url .= '&' . $keys . '=' . $data[$rows_url];
                                   }
                                   $response = file_get_contents(trim($api_url));
                                   $response_insert =  [
                                       "campaign_id" => $campignRow->id,
                                       "crm_id"  => $crmformDataId,
                                       "camp_response" => $response,
                                       "dailer_url" => trim($api_url),
                                       "api_type" => $campignRow->crm_type,
                                       "created_by" => Auth::id()
                                   ];
                                   DB::table('crm_campaigns_log')->insert($response_insert);
                               } catch (\Exception $ex) {


                                   //echo $ex->getMessage() . $ex->getLine();
                                   $request->session()->flash('error', $ex->getMessage() . ' Line: ' . $ex->getLine());
                                   $url = url()->previous();
                                   return redirect($url);
                               }
                           }
                       }
                   }
                   $slash = "\\";
                   $mdName = $slash . $request->table_name;
                   $result = "App\Models$mdName"::create($data);
                   //   $result = DB::table($request->table_name)->insert($data);
               }

               if ($result) {
                   $request->session()->flash('success', 'Data has been successfully Imported.');
                   $url = url()->previous();
                   return redirect($url);
               } else {
                   $request->session()->flash('error', 'Something went wrong!');
                   $url = url()->previous();
                   return redirect($url);
               }
           } else {
               $request->session()->flash('error', 'Please Select CSV file');
               $url = url()->previous();
               return redirect($url);
           }
       } catch (\Exception $ex) {


           echo $ex->getMessage() . $ex->getLine();
           $request->session()->flash('error', $ex->getMessage() . ' Line: ' . $ex->getLine());
           $url = url()->previous();
           return redirect($url);
       }
   }

}
