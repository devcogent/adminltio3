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
use Excel; */

use App\Models\User;
use Carbon\Carbon;
use App\Models\CrmMaster;
use App\Models\CrmForm;
use App\Models\CrmFormField;
use App\Models\CrmFormFieldOption;
use Config;
use Hash;

date_default_timezone_set('Asia/Kolkata');
class AjaxMasterController extends Controller
{
	public function __construct()
	{
		//DB::enableQueryLog();
		$this->middleware('auth');
	}


	public function index(Request $request)
	{


	}
	public function getcrmColumns(Request $request)
	{

		// dd($request->crmform_id);

        try {
            $crm_name = $request->crm_name;
            Config::set('database.connections.mysql.database', 'cgcrm_' . $crm_name);
            DB::purge('mysql');
            $data['crm_forms'] = $request->crmform_id;
            $data['crm_name'] = $request->crm_name;
            $data['crm_fields'] = CrmFormField::where('crm_form_id', $request->crmform_id)->orderBy('sortBy', 'asc')
                ->get();
            $dependencies = CrmFormField::where('crm_form_id', $request->crmform_id)->where('field_depend', '!=', "null")->where('field_type', 'drop_down')->get('field_depend');
            $data['get_dep'][] = '';
            foreach ($dependencies as $depend) {
                $data['get_dep'][] = $depend->field_depend;
            }
            if (count($data['crm_fields']) > 0) {
                $view = view("crm_masters.crm_formcolumns_fields", $data)->render();
                return \Response::json(['html' => $view, 'status' => 'success']);
            } else {
                $view = view("crm_masters.crm_formcolumns_fields", $data)->render();
                return \Response::json(['html' => $view, 'status' => 'success']);
            }
        } catch (\Throwable $ex) {
            return \Response::json(['message'=>'something went wrong !','status' => 'error']);
        }

	}

	public function updatePassword(Request $request)
	{
        try {

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

}
