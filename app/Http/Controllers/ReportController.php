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
use App\Models\CrmForm;
use App\Models\CrmFormField;
use App\Models\CrmFormFieldOption;
use Config;

class ReportController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
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
    public function index(Request $request)
    {

        $table_header = [];
        $arr_set = [];

        if ($request->date_from &&  $request->date_from != "" && $request->has('date_to') &&  $request->date_to != "" &&  $request->crm_name != "" && $request->crm_type) {

            $cm_name =  CrmMaster::where('id', $request->crm_name)->first();
            Config::set('database.connections.mysql.database', 'cgcrm_' . $cm_name->crm_name);
            DB::purge('mysql');
            $date_form = date('Y-m-d', strtotime($request->date_from));
            $selected = array();
            $date_to = date('Y-m-d', strtotime($request->date_to));

            $date_to = strtotime($date_to) + 86400;
            $date_to = date('Y-m-d', $date_to);


            $selected['date_from'] = $date_form;
            $selected['date_to'] = $date_to;

            $crm_id = $request->crm_name;
            $crmformNameCdataRemit  = '';
            $getPrifix = '';
            $table1 = '';
            $table2 = '';
            $finalDatas = array();
            $table_header = [];
            $arr_set = [];


            if ($request->crm_type == 1) {
                $getPrifix = '_client_data';
                $crmformNameCdata  = CrmMaster::where('id', $crm_id)->where('crm_type', $request->crm_type)->first();
                $crmformIDsForCti  = CrmForm::where('crm_id', $crm_id)->first();
                if (!empty($crmformIDsForCti)) {
                    $crmformNameCti  = CrmForm::where('cti_depend_form', $crmformIDsForCti->id)->where('cti_type', '3')->first();
                    if (!empty($crmformNameCti)) {
                        $table2 = $crmformNameCti->form_name;
                        $crmformIDsCti  = CrmForm::where('form_name', $table2)->first();
                        $crmformIDsCti = $crmformIDsCti->id;
                        $tblfieldsCti =  DB::select(DB::raw("SELECT field_name as fields from crm_fields where crm_form_id='" . $crmformNameCti->id . "' order by sortby"));
                        foreach ($tblfieldsCti as $rowfieldsCti) {
                            // $selectColumnCti[] = "t3.".$rowfieldsCti->fields;
                            $selectColumnCti[] = "$table2." . $rowfieldsCti->fields;
                        }
                        $tblfieldsCti = implode(",", $selectColumnCti);
                    }
                }
                $table1 = $crmformNameCdata->crm_name . $getPrifix;
                $table1 =  strtolower($table1);
                $slash = "\\";
                $mdName = $slash . $table2;
            } else {

                $getPrifix = '_agent_input';
                $crmformNameCdata  = CrmMaster::where('id', $crm_id)->where('crm_type', $request->crm_type)->first();
                $table1 = $crmformNameCdata->crm_name . $getPrifix;
                $table1 =  strtolower($table1);
                $slash = "\\";
                $mdName = $slash . $table1;
                $crmformIDs  = CrmForm::where('form_name', $table1)->first();
                if (!empty($crmformIDs)) {
                    $crmformIDs = $crmformIDs->id;
                    $tblfields =  DB::select(DB::raw("select field_name as fields from crm_fields where crm_form_id='" . $crmformIDs . "' order by sortby"));
                    $selectColumn[] = "$table1.id";
                    foreach ($tblfields as $rowfields) {
                        $selectColumn[] = "$table1." . $rowfields->fields;
                    }
                    $selectColumn[] = "t2.name as agentname";
                    $selectColumn[] = "$table1.created_at";
                    $selectColumn[] = "$table1.updated_at";
                    $tblfields = implode(",", $selectColumn);
                    $finalDatas = "App\Models$mdName"::leftJoin('users as t2', $table1 . '.created_by', '=', 't2.id')->whereBetween("$table1.created_at", [$date_form, $date_to])->get($selectColumn)->toArray();
                } else {

                    $finalDatas = [];
                }
            }

            $agent_id = Auth::id();
            $selectColumn = array();
            if (!empty($crmformIDsForCti)) {
                $crmformIDs  = CrmForm::where('form_name', $table1)->first();
                if (!empty($crmformIDs)) {
                    $crmformIDs = $crmformIDs->id;
                    $tblfields =  DB::select(DB::raw("select field_name as fields from crm_fields where crm_form_id='" . $crmformIDs . "' order by sortby"));
                    $selectColumn[] = "$table1.id";
                    foreach ($tblfields as $rowfields) {
                        $selectColumn[] = "$table1." . $rowfields->fields;
                    }
                    $selectColumn[] = "t2.name as agentname";
                    $selectColumn[] = "$table1.created_at";
                    $selectColumn[] = "$table1.updated_at";
                    $tblfields = implode(",", $selectColumn);
                    $slash = "\\";
                    $mdName = $slash . $table1;
                    $mdName2 = $slash . $table2;
                    if (!empty($crmformNameCti)) {

                        $temp_arr = [];
                        if ($request->status_by == 1) {

                            $finalDatas = "App\Models$mdName"::whereBetween("$table1.created_at", [$date_form, $date_to])->get()->toArray(); //toSql();
                            $finalDatas2 = "App\Models$mdName2"::all()->toArray();

                            if ($request->record_by == 1) {
                                foreach ($finalDatas2 as $key_temp => $value_temp) {
                                    if ($value_temp['from_data_id'] == $finalDatas2[$key_temp]['from_data_id']) {
                                        $temp_arr[$value_temp['from_data_id']] = $value_temp['id'];
                                    }
                                }
                                $finalDatas2 = [];
                                $finalDatas2 = "App\Models$mdName2"::whereIn('id', array_values($temp_arr))->get()->toArray();
                            }
                        } else {

                            $finalDatas = "App\Models$mdName"::all()->toArray();
                            $finalDatas2 = "App\Models$mdName2"::whereBetween("$table2.created_at", [$date_form, $date_to])->get()->toArray(); //toSql();

                            if ($request->record_by == 1) {
                                foreach ($finalDatas2 as $key_temp => $value_temp) {
                                    if ($value_temp['from_data_id'] == $finalDatas2[$key_temp]['from_data_id']) {
                                        $temp_arr[$value_temp['from_data_id']] = $value_temp['id'];
                                    }
                                }
                                $finalDatas2 = [];
                                $finalDatas2 = "App\Models$mdName2"::whereIn('id', array_values($temp_arr))->whereBetween("$table2.created_at", [$date_form, $date_to])->get()->toArray();
                            }
                        }
                        $get_form_format  = DB::getSchemaBuilder()->getColumnListing($table2);
                        $get_cti_data_array = [];

                        if (!empty($finalDatas)) {
                            if (empty($finalDatas2)) {
                                foreach ($get_form_format as $keys => $rows) {
                                    if ($rows != 'id' && $rows != 'created_at'  && $rows != 'from_data_id' && $rows != 'created_by' && $rows != 'updated_at' && $rows != 'tid' && $rows != 'lead_status') {
                                        $get_cti_data_array[$rows] = '';
                                    }
                                }
                                foreach ($finalDatas as $keys3 => $rows3) {
                                    (array)$rows4 = array_merge($rows3, array_values($get_cti_data_array));
                                    foreach ((array)$rows4 as $k3 => $v3) {
                                        if ($k3 != 'lead_status') {
                                            $get_client_data_array[$keys3][] =  $v3;
                                        }
                                    }
                                }
                                foreach ($finalDatas as $keys5 => $rows5) {
                                    foreach ((array)$rows5 as $k4 => $v4) {
                                        if ($k4 != 'lead_status') {
                                            $get_client_data_array_new[$keys5][$k4] =  $v4;
                                        }
                                    }
                                }
                                $arr_set = $get_client_data_array;
                                $table_header =  array_merge(array_keys($get_client_data_array_new[0]), array_keys($get_cti_data_array));
                            } else {


                                foreach (array_keys($finalDatas2[0]) as $keys => $rows) {
                                    if ($rows != 'id' && $rows != 'created_at' && $rows != 'created_by' && $rows != 'updated_at' && $rows != 'tid') {
                                        $get_cti_data_array[$rows] = '';
                                    }
                                }
                                foreach ($finalDatas2 as $keys => $rows) {

                                    foreach ((array)$rows as $k6 => $v6) {

                                        if ($k6 != 'id' && $k6 != 'created_at' && $k6 != 'created_by' && $k6 != 'updated_at' && $k6 != 'tid') {
                                            $get_cti_data_array_data[$keys][$k6] = $v6;
                                        }
                                    }
                                }

                                foreach ($get_cti_data_array_data[0] as $value9) {
                                    $blank_value[] = '';
                                }

                                $get_client_data_array = [];
                                foreach ($finalDatas as $keys3 => $rows3) {
                                    foreach ($get_cti_data_array_data as $val_key => $value_new) {


                                        if ($request->status_by == 1) {
                                            if ((int)$rows3['id'] == (int)$value_new['from_data_id']) {
                                                (array)$rows4[] = array_merge($rows3, array_values($value_new));
                                            } else {

                                                (array)$rows4[] = array_merge($rows3,  $blank_value);
                                            }
                                        } else {
                                            if ((int)$rows3['id'] == (int)$value_new['from_data_id']) {
                                                (array)$rows4[] = array_merge($rows3, array_values($value_new));
                                            }
                                        }
                                    }
                                }

                                foreach ($finalDatas as $keys5 => $rows5) {
                                    foreach ((array)$rows5 as $k4 => $v4) {
                                        $get_client_data_array_new[$keys5][$k4] =  $v4;
                                    }
                                }
                                $arr_set = array_unique($rows4, SORT_REGULAR); //$rows4;
                                foreach ($arr_set as $gen_value) {
                                    $gen_value =  array_slice(array_values($gen_value), 0, count(array_values($gen_value)) - 1);

                                    $gen_new_data[] = $gen_value;
                                }
                                $arr_set = [];
                                $arr_set = $gen_new_data;
                                $table_header =  array_merge(array_keys($get_client_data_array_new[0]), array_keys($get_cti_data_array));
                                $table_header = array_slice($table_header, 0, count($table_header) - 1);

                                for ($i = 0; $i < 1; $i++) {
                                    $rm_index[] = array_search("lead_status", $table_header);
                                    $rm_index[] = array_search("from_data_id", $table_header);
                                    $rm_index[] = array_search("created_by", $table_header);

                                    $rm_index_var = array_search("lead_status", $table_header);
                                    $rm_index_var_2 = array_search("from_data_id", $table_header);
                                    $rm_index_var_3 = array_search("created_by", $table_header);

                                    unset($table_header[$rm_index_var]);
                                    unset($table_header[$rm_index_var_2]);
                                    unset($table_header[$rm_index_var_3]);
                                }
                                $rm_index = array_filter($rm_index);
                                foreach ($arr_set as $arr_key_get => $arr_val) {
                                    for ($j = 0; $j < count($rm_index); $j++) {
                                        unset($arr_set[$arr_key_get][$rm_index[$j]]);
                                    }
                                }
                            }

                            $finalDatas = [];
                        } else {
                            $finalDatas = [];
                        }
                    } else {

                        $finalDatas = "App\Models$mdName"::leftJoin('users as t2', $table1 . '.created_by', '=', 't2.id')->whereBetween("$table1.created_at", [$date_form, $date_to])->get($selectColumn)->toArray();
                    }
                } else {
                    $finalDatas = [];
                }
            }
        } else {
            $finalDatas = array();
            $selected = array();
        }
        $crm_name = CrmMaster::select(
            'crm_masters.*',
        )->where('created_by', Auth::id())
            ->get();
        
            if(empty($finalDatas) || empty($arr_set))
            {
                  $status = 'error';
                  $message = 'Data not found';
            }else{
                $status = 'success';
                $message = 'Data fetched successfully !';
            }


            $crmtype = $request->crm_type;
            $crmname = $request->crm_name;
            $datefrom = $request->date_from;
            $dateto = $request->date_to;
            $statusby =  $request->status_by;
            $recordby = $request->record_by;


        return view('reports.index',compact('crm_name', 'finalDatas', 'table_header', 'arr_set','crmtype','crmname','datefrom','dateto','statusby','recordby'))->with($status,$message);
    }


    public function agentReports(Request $request, $dbname, $crmID, $crmFrm)
    {


        try {

            Config::set('database.connections.mysql.database', 'cgcrm_' . explode('_agent_input', $crmFrm)[0]);
            DB::purge('mysql');
            $agent_id = Auth::id();
            // dd($agent_id);
            if (Auth::user()->emp_type == "supervisor") {
                $where = [];
            } else {
                $where["$crmFrm.created_by"] = $agent_id;
            }
            $selectColumn = array();

            $crmformIDs  = CrmForm::where('form_name', $crmFrm)->get()->toArray();
            $crmformIDs = $crmformIDs[0]['id'];

            $tblfields =  DB::select(DB::raw("select field_name as fields from crm_fields where crm_form_id='" . $crmformIDs . "' order by sortby"));
            $is_unique =  DB::select(DB::raw("select field_name from crm_fields where crm_form_id='" . $crmformIDs . "' and is_unique = 'yes' order by sortby"));

            foreach ($tblfields as $rowfields) {

                $selectColumn[] = "$crmFrm.id";
                $selectColumn[] = "$crmFrm." . $rowfields->fields;
            }

            $tblfields = implode(",", $selectColumn);
            $slash = "\\";
            $mdName = $slash . $crmFrm;

            if ($request->date_from &&  $request->date_from != "" && $request->has('date_to') &&  $request->date_to != "" && $request->has('crm_form') &&  $request->crm_form != "") {
                $date_form = date('Y-m-d', strtotime($request->date_from));
                $date_to = date('Y-m-d', strtotime($request->date_to));
                $selecteddate_from = date('m/d/Y', strtotime($date_form));
                $selecteddate_to = date('m/d/Y', strtotime($date_to));

                // $date_to = strtotime($date_to) + 86400;
                // $selecteddate_to = date('m/d/Y', $date_to);
                $date_to = strtotime($date_to) + 86400;
                $date_to = date('Y-m-d', $date_to);
                // dd($date_to,$date_form);
                $table = $request->crm_form;
                $tablename = $table;
                $selectColumn[] = "t2.name as agentname";
                $selectColumn[] = "$crmFrm.created_at";
                $selectColumn[] = "$crmFrm.updated_at";
                $finalDatas = "App\Models$mdName"::leftJoin('users as t2', $crmFrm . '.created_by', '=', 't2.id')->where($where)->whereBetween("$crmFrm.created_at", [$date_form, $date_to])->get($selectColumn)->toArray();
                $finalDatas = json_decode(json_encode($finalDatas));
            } else {

                $date_form = date('Y-m-d', strtotime("-7 day"));
                $date_to = date('Y-m-d');
                $date_to = strtotime($date_to) + 86400;
                $date_to = date('Y-m-d', $date_to);
                $selecteddate_from = date('m/d/Y', strtotime($date_form));
                $selecteddate_to = date('m/d/Y', strtotime($date_to));
                $selectColumn[] = "t2.name as agentname";
                $selectColumn[] = "$crmFrm.created_at";
                $selectColumn[] = "$crmFrm.updated_at";
                $finalDatas = "App\Models$mdName"::leftJoin('users as t2', $crmFrm . '.created_by', '=', 't2.id')->where($where)->whereBetween("$crmFrm.created_at", [$date_form, $date_to])->get($selectColumn)->toArray();
                $finalDatas = json_decode(json_encode($finalDatas));
                $selected = array();
                $tablename = $crmFrm;
            }

            $crm_name = CrmMaster::select(
                'crm_masters.*',
            )->leftJoin('user_crm',  'user_crm.crm_id', '=', 'crm_masters.id')->where('user_crm.emp_id', Auth::id())
                ->get();
            // dd($crm_name);

            $is_form_type = DB::select("SELECT * FROM crm_forms where id = '$crmformIDs'");
            if (!empty($is_form_type)) {
                if ($is_form_type[0]->form_type == '2') {
                    $is_form_type_remit = 2;
                } else {
                    $is_form_type_remit = 1;
                }
            } else {
                $is_form_type_remit = 2;
            }

            $cti_page =  DB::select("SELECT * FROM crm_forms where crm_id = $crmID and cti_type = '3' and cti_depend_form = '$crmformIDs'");
            return view('agents.index')->with(compact('crm_name', 'finalDatas', 'tablename', 'crmID', 'crmFrm', 'selecteddate_from', 'selecteddate_to', 'cti_page', 'is_unique', 'crmformIDs', 'is_form_type_remit'));
        } catch (\Throwable $ex) {

            $request->session()->flash('error', "Something went wrong!");
            return redirect()->back();
        }
    }
}
