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
use App\Smslog;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client as GuzzleClient;
use Mail;
use App\Models\UserCrm;
use App\Models\CrmMaster;
use App\Models\CrmForm;
use App\Models\CrmFormField;
use App\Models\crmFieldDependencie;
use App\Models\CrmFormFieldOption;
use Illuminate\Support\Facades\Crypt;
use App\Models\CrmCampaign;
use Illuminate\Support\Facades\Http;
use Config;


class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $type = Auth::user()->emp_type;
        if ($type == "admin" || $type == "super_admin") {
            return view('dashboard');
        } else {
            return redirect('/agent-view');
        }
    }


    public function callApi($url, $token, $data)
    {

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $data,
            CURLOPT_HTTPHEADER => array(
                "Authorization: $token",
                "Content-Type: application/json"
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }


    public function openCti(request $request)
    {

        $current_uri = request()->segments();
        $table = $current_uri[1];
        $from_data_id = $request->query('id');
        $tid = $request->query('tid');
        $table_agent_input = $request->query('tablename');
        $agent_input_data = DB::select("SELECT * FROM $table_agent_input where id = $from_data_id Limit 1");
        $crmform  = CrmForm::where('form_name', $table)->first();

        if ($crmform) {
            $crm_fields  = CrmFormField::where('crm_form_id', $crmform->id)->orderby('sortBy', 'asc')->get();
            return view('uploadform.agent_cti')->with(compact('crm_fields', 'crmform', 'from_data_id', 'tid', 'agent_input_data'));
        } else {
            return view('error');
        }
        return view('uploadform.agent_cti');
    }
    public function agentView($db)
    {

        $crm_name = [];
        $finalForm = [];
        $crm_name = CrmMaster::select('crm_masters.*',)
            ->leftJoin('user_crm',  'user_crm.crm_id', '=', 'crm_masters.id')
            ->where('user_crm.emp_id', Auth::id())->get();
        $final = [];

        foreach ($crm_name as $cname) {
            $crmform  = CrmForm::where('crm_id', $cname->id)->get()->toArray();
            $finalForm = $crmform;
        }
        return view('agentView')->with(compact('crm_name', 'finalForm'));
    }


    public function ViewPage($table)
    {
        $crmform  = CrmForm::where('form_name', $table)->first();
        if ($crmform) {
            $crm_fields  = CrmFormField::where('crm_form_id', $crmform->id)->orderby('sortBy', 'asc')->get();
            return view('inputform.inputForm')->with(compact('crm_fields', 'crmform'));
        } else {
            return view('error');
        }
    }


    public function downloadCsvFormat($table)
    {


        try {

            Config::set('database.connections.mysql.database', 'cgcrm_' . explode('_client_data', $table)[0]);
            DB::purge('mysql');
            $get_form_format  = DB::getSchemaBuilder()->getColumnListing($table);
            $remit_new_format = [];

            foreach ($get_form_format as $remit_format) {

                if ($remit_format != 'created_at' && $remit_format != 'created_by' && $remit_format != 'id' &&  $remit_format != 'updated_at' && $remit_format != 'tid' && $remit_format != 'lead_status' && $remit_format != 'from_data_id') {
                    $remit_new_format[] = $remit_format;
                }
            }
            if (!empty($get_form_format)) {

                $list[] = json_decode(json_encode($remit_new_format), true);
                // unset($list[0][0]);
                $headers = [
                    'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
                    'Content-type'        => 'text/csv',
                    'Content-Disposition' => 'attachment; filename="' . $table . '".csv',
                    'Expires'             => '0',
                    'Pragma'              => 'public'
                ];
                # add headers for each column in the CSV download
                array_keys($list[0]);
                $callback = function () use ($list) {
                    $FH = fopen('php://output', 'w');
                    foreach ($list as $row) {
                        fputcsv($FH, $row);
                    }
                    fclose($FH);
                };
                return response()->stream($callback, 200, $headers);
            } else {
                session()->flash('error', 'Something went wrong!');
                $url = url()->previous();
                return redirect($url);
            }
        } catch (\Exception $ex) {
        dd($ex->getMessage());
            session()->flash('error', $ex->getMessage() . ' Line: ' . $ex->getLine());
            $url = url()->previous();
            return redirect($url);
        }
    }


    public function downloadCsvFormatForAgent($table, $crmname)
    {


        try {

            Config::set('database.connections.mysql.database', 'cgcrm_' . explode('_client_data', $table)[0]);
            DB::purge('mysql');
            $get_form_format  = DB::getSchemaBuilder()->getColumnListing($crmname);
            $remit_new_format = [];

            foreach ($get_form_format as $remit_format) {

                if ($remit_format != 'created_at' && $remit_format != 'created_by' && $remit_format != 'id' &&  $remit_format != 'updated_at' && $remit_format != 'tid' && $remit_format != 'lead_status' && $remit_format != 'from_data_id') {
                    $remit_new_format[] = $remit_format;
                }
            }
            if (!empty($get_form_format)) {

                $list[] = json_decode(json_encode($remit_new_format), true);
                // unset($list[0][0]);
                $headers = [
                    'Cache-Control'       => 'must-revalidate, post-check=0, pre-check=0',
                    'Content-type'        => 'text/csv',
                    'Content-Disposition' => 'attachment; filename="' . $table . '".csv',
                    'Expires'             => '0',
                    'Pragma'              => 'public'
                ];
                # add headers for each column in the CSV download
                array_keys($list[0]);
                $callback = function () use ($list) {
                    $FH = fopen('php://output', 'w');
                    foreach ($list as $row) {
                        fputcsv($FH, $row);
                    }
                    fclose($FH);
                };
                return response()->stream($callback, 200, $headers);
            } else {
                session()->flash('error', 'Something went wrong!');
                $url = url()->previous();
                return redirect($url);
            }
        } catch (\Exception $ex) {
        dd($ex->getMessage());
            session()->flash('error', $ex->getMessage() . ' Line: ' . $ex->getLine());
            $url = url()->previous();
            return redirect($url);
        }
    }







    public function uploadCsvFormat($table)
    {
        Config::set('database.connections.mysql.database', 'cgcrm_' . explode('_client_data', $table)[0]);
        DB::purge('mysql');
        $crmform  = CrmForm::where('form_name', $table)->first();
        if ($crmform) {
            $crm_fields  = CrmFormField::where('crm_form_id', $crmform->id)->orderby('sortBy', 'asc')->get();
            return view('uploadform.upload_csv')->with(compact('crm_fields', 'crmform'));
        } else {
            return view('error');
        }
    }

    public function validate_mobile($mobile)
    {
        $pattern = '/\+[0-9]{2}+[0-9]{10}/s';
        return preg_match($pattern, $mobile);
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



    public function uploadCsvFormatPost(request $request)
    {
        try {
            $ext = $request->file('uplaod_file')->extension();
            if ($ext == 'csv' || $ext == 'txt') {

                $campign = CrmCampaign::where('created_by', Auth::id())->where('crm_id', $request->table_name)->get();
                Config::set('database.connections.mysql.database', 'cgcrm_' . explode('_client_data', $request->table_name)[0]);
                DB::purge('mysql');
                $crmformData  = CrmForm::where('form_name', $request->table_name)->first();
                $crmformDataId = $crmformData->id;
                $crmFields  = CrmFormField::where('crm_form_id', $crmformDataId)->orderby('sortBy', 'desc')->get();

                // dd($crmFields);
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

    public function ViewPageTest()
    {

        $crmform  = CrmForm::where('form_name', 'byjus_marketresearch')->first();
        if ($crmform) {
            $crm_fields  = CrmFormField::where('crm_form_id', $crmform->id)->orderby('id', 'asc')->get();
            //dd($crm_fields);
            return view('inputform.inputFormTest')->with(compact('crm_fields', 'crmform'));
        } else {
            return view('error');
        }
    }
    public function SubmitAgentForm(REQUEST $request)
    {
        try {

            $input = $request->all();
            foreach ($input as $key => $value) {
                if (is_array($value)) {
                    $input[$key] = implode(',', $value);
                }
            }
            unset($input['_token']);
            unset($input['form_id']);
            unset($input['form_name']);
            DB::table($request->form_name)->insert($input);
            $request->session()->flash('success', 'Data Insert Successfully ');
            $url = url()->previous();
            return redirect($url);
        } catch (\Throwable $ex) {

            $request->session()->flash('error', $ex->getMessage() . 'Line:' . $ex->getLine());
            return redirect()->back();
        }
    }


    public function editPage($dbname, $table, $action, $id)
    {

        $id = Crypt::decryptString($id);
        $crmform  = CrmForm::where('form_name', $table)->first();
        $slash = "\\";
        $mdName = $slash . $table;
        if ($crmform) {
            $crm_fields  = CrmFormField::where('crm_form_id', $crmform->id)->orderby('sortBy', 'asc')->get();
            $finalDatas = "App\Models$mdName"::Where('id', $id)->get();
            $dep_filed = crmFieldDependencie::where('crm_id', $crmform->id)->orderBy('id', 'DESC')->get()->toArray();
            $row_child = [];
            $row_parent = [];
            if ($dep_filed) {
                foreach ($dep_filed as $dep_rows) {
                    $row_child[] = $dep_rows['dropdown_id_from'];
                    $row_parent[] = $dep_rows['dropdown_id'];
                }
            }
            $crm_input_history = DB::table('crm_input_history')->where('field_id', $id)->where('form_id', $crmform->id)->get();
            return view('inputform.inputEditForm')->with(compact('crm_fields', 'crmform', 'finalDatas', 'id', 'crm_input_history', 'row_child', 'row_parent'));
        } else {
            return view('error');
        }
    }

    public function editAgentForm(REQUEST $request)
    {
        try {
            $input = $request->all();
            $input_new = $request->all();
            foreach ($input as $key => $value) {
                if (is_array($value)) {
                    $input[$key] = implode(',', $value);
                }
            }
            unset($input['_token']);

            unset($input['form_id']);
            unset($input['form_name']);
            unset($input['field_id']);
            unset($input_new['_token']);

            $audit['form_id'] = $input_new['form_id'];
            $audit['form_name'] = $input_new['form_name'];
            $audit['field_id'] = $input_new['field_id'];
            $audit['created_by'] = $input_new['created_by'];

            unset($input_new['form_id']);
            unset($input_new['form_name']);
            unset($input_new['field_id']);
            unset($input_new['field_id']);
            unset($input_new['created_by']);

            $audit2['data']['creater_by'] = Auth::user()->emp_id;
            $audit2['data']['creater_type'] = Auth::user()->emp_type;
            $audit2['data']['audit_trail'] = $input_new;
            $audit2['data']['created_date'] = date('Y-m-d H:i:s');
            $audit['data'] = json_encode($audit2);
            if (Auth::user()->emp_type == "supervisor") {
                unset($input['created_by']);
            }
            DB::table('crm_input_history')->insert($audit);
            $slash = "\\";
            $mdName = $slash . $request->form_name;
            "App\Models$mdName"::find($request->field_id)->update($input);
            // DB::table($request->form_name)
            //     ->where('id', $request->field_id)
            //     ->update($input);
            $request->session()->flash('success', 'Data Update Successfully ');
            return redirect()->back();
        } catch (\Throwable $ex) {

            echo $ex;
            die;

            $request->session()->flash('error', "Something went wrong!");
            return redirect()->back();
        }
    }
}
