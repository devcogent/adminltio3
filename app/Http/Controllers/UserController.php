<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use DB;
use Excel;
use App\Models\User;
use App\Models\UserCrm;
use App\Models\CrmMaster;
use Config;
use Carbon\Carbon;


date_default_timezone_set('Asia/Kolkata');

class UserController extends Controller
{
	public function __construct()
	{
		$totalRecords = User::get();
	}


	public function getEmployees(Request $request)
	{

		## Read value
		$draw = $request->get('draw');
		$start = $request->get("start");
		$rowperpage = $request->get("length"); // Rows display per page

		$columnIndex_arr = $request->get('order');
		$columnName_arr = $request->get('columns');
		$order_arr = $request->get('order');
		$search_arr = $request->get('search');

		$columnIndex = $columnIndex_arr[0]['column']; // Column index
		$columnName = $columnName_arr[$columnIndex]['data']; // Column name
		$columnSortOrder = $order_arr[0]['dir']; // asc or desc
		$searchValue = $search_arr['value']; // Search value
		// Total records
		$crmDb = [];

		if (Auth::user()->emp_type != "super_admin") {
			$crmDb = CrmMaster::where('created_by', Auth::id())->orderby('crm_name')->distinct('crm_name')->get();
			foreach ($crmDb as $key) {
				Config::set('database.connections.mysql.database', 'cgcrm_' . $key->crm_name);
				DB::purge('mysql');
				$totalRecords = User::select('count(*) as allcount')->count();
				$totalRecordswithFilter =  User::leftjoin('users as creator', 'creator.id', '=', 'users.created_by')
					->leftjoin('users as updateby', 'updateby.id', '=', 'users.updated_by')
					->select('users.*', 'creator.name as Created_byName', 'updateby.name as Updated_byName')
					->where('users.name', 'like', '%' . $searchValue . '%')
					->where('users.created_by', Auth::id())->where('users.emp_type', '!=', 'super_admin')
					->count();
			}
		} else {
			Config::set('database.connections.mysql.database', 'cogent-crm');
			DB::purge('mysql');
			$totalRecords = User::select('count(*) as allcount')->count();
			$totalRecordswithFilter =  User::leftjoin('users as creator', 'creator.id', '=', 'users.created_by')
				->leftjoin('users as updateby', 'updateby.id', '=', 'users.updated_by')
				->select('users.*', 'creator.name as Created_byName', 'updateby.name as Updated_byName')
				->where('users.name', 'like', '%' . $searchValue . '%')
				->where('users.created_by', Auth::id())->where('users.emp_type', '!=', 'super_admin')
				->count();
		}
		$records = User::query();
		if (Auth::user()->emp_type != "super_admin") {
			$records =	$records->where('users.created_by', Auth::id());
		}

		$records = $records->orderBy($columnName, $columnSortOrder)
			->where('users.name', 'like', '%' . $searchValue . '%')->where('users.emp_type', '!=', 'super_admin')
			->select('users.*')
			->skip($start)
			->take($rowperpage)
			->get();

		$data_arr = array();
		$crm_name = 'none';
		foreach ($records as $recordkey => $record) {
			$id = $record->id;
			$emp_id = $record->emp_id;
			$name = $record->name;
			$email = $record->email;
			$emp_type = $record->emp_type;
			if (Auth::user()->emp_type != "super_admin") {
				foreach ($crmDb as $key) {
					$crm_name = $key->crm_name;
				}
			}

			if (Auth::user()->emp_type == "super_admin") {

				$data_arr[] = array(
					"id" => $record->id,

					"actionButton" => '<a href="' . url("users/edit", $record->id) . '" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit" style="font-size: 10px;"> <i class="fa fa-edit"></i>  </a>
				<a href="javascript:void(0)" id="' . $record->id . '"  onclick="myfun(' . $record->id . ')"   class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete" style="font-size: 10px;"> <i class="fa fa-trash" ></i>  </a>',
					"emp_id" => $emp_id,
					"name" => $name,
					"email" => $email,
					"emp_type" => $emp_type,
					"crm_name" => $crm_name,

				);
			} else {

				$data_arr[][] = array(
					"id" => $record->id,
					"actionButton" => '<a href="' . url("users/edit", $record->id) . '/?process_name=' . $crm_name . '" class="btn btn-primary btn-sm" data-toggle="tooltip" data-placement="top" title="Edit" style="font-size: 10px;"> <i class="fa fa-edit"></i>  </a>
				<a href="javascript:void(0)" id="' . $record->id . '"  onclick="myfun(' . $record->id . ')"class="btn btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Delete" style="font-size: 10px;"> <i class="fa fa-trash" ></i> </a>',
					"emp_id" => $emp_id,
					"name" => $name,
					"email" => $email,
					"emp_type" => $emp_type,
					"crm_name" => $crm_name,

				);
			}
		}

		$response = array(
			"draw" => intval($draw),
			"iTotalRecords" => $totalRecords,
			"iTotalDisplayRecords" => $totalRecordswithFilter,
			"aaData" => $data_arr
		);

		echo json_encode($response);
		exit;
	}
	public function getEmployeesAll()
	{

		$all_users = array();
		if (Auth::user()->emp_type == "supervisor" || Auth::user()->emp_type == "agent") {
			return view('authorization.auth');
		} else {
			$created_by = Auth::id();
			if (Auth::user()->emp_type == "admin") {
				$crmDb = CrmMaster::where('created_by', Auth::id())->orderby('crm_name')->distinct('crm_name')->get();
				foreach ($crmDb as $value) {
					Config::set('database.connections.mysql.database', 'cgcrm_' . $value->crm_name);
					DB::purge('mysql');
					$all_users[] =  User::where('created_by', $created_by)->get();
				}
			} else {
				$all_users[] =  User::where('emp_type', 'admin')->get();
			}
			return view('users.index_new')->with(compact('all_users'));
		}
	}


	public function getUsersCrms()
	{

		$all_users = array();
		if (Auth::user()->emp_type == "supervisor" || Auth::user()->emp_type == "agent" || Auth::user()->emp_type == "admin") {
			return view('authorization.auth');
		} else {
			$allCrms = CrmMaster::join('users', 'users.id', '=', 'crm_masters.created_by')->get(['crm_masters.*', 'users.emp_id', 'users.emp_type', 'users.crm_limit']);
			// dd($allCrms);

			return view('users.users_crms')->with(compact('allCrms'));
		}
	}
	public function index(Request $request)
	{
		if (Auth::user()->emp_type == "admin") {
			//$users=User::orderby('usersName','ASC')->get();
			$users = User::leftjoin('users as creator', 'creator.id', '=', 'users.created_by')
				->leftjoin('users as updateby', 'updateby.id', '=', 'users.updated_by')
				->select('users.*', 'creator.name as Created_byName', 'updateby.name as Updated_byName')
				->get();
			return view('users.index')->with(compact('users'));
		} else {
			$request->session()->flash('error', '! Access Denied');
			return redirect('/');
		}
	}
	public function add()
	{
		$crm_list = CrmMaster::where('created_by', Auth::id())->orderby('id', 'desc')->get();
		return view('users.add')->with(compact('crm_list'));
	}


	public function create(Request $request)
	{


		if (Auth::user()->emp_type == 'admin') {
			$this->validate($request, [

				'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
				'emp_id' => 'required|unique:users,emp_id',
				'emp_type' => 'required',
				'password' => 'required|string|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
				'process_name' => 'required',
				'user_access' => 'required',
			]);
		} else {

			$this->validate($request, [

				'name' => 'required|string|max:255',
				'email' => 'required|string|email|max:255|unique:users,email',
				'emp_id' => 'required|unique:users,emp_id',
				'emp_type' => 'required',
				'password' => 'required|string|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
				'user_access' => 'required',
				'crm_limit' => 'required',

			]);
		}

		if (Auth::user()->emp_type == 'admin') {
			$my_crm =  CrmMaster::where('crm_name', $request->process_name)->first();
			Config::set('database.connections.mysql.database', 'cgcrm_' . $request->process_name);
			DB::purge('mysql');
		}

		$user_detail = User::where('email', '=', $request->email)->orWhere('emp_id', '=', $request->emp_id)->first();
		if (!empty($user_detail)) {

			$request->session()->flash('error', 'User Already Exists');
			return redirect('/users');
		}

		if (Auth::user()->emp_type == 'admin') {
			$inserted_user_id = User::create([
				'name' => $request->name,
				'email' => $request->email,
				'emp_id' => $request->emp_id,
				'emp_type' => $request->emp_type,
				'password' =>  Hash::make($request->password),
				'process_name' =>  $request->process_name,
				'user_access' =>  $request->user_access,
				'created_by' => Auth::id(),

			])->id;
		} else {
			$inserted_user_id = User::create([
				'name' => $request->name,
				'email' => $request->email,
				'emp_id' => $request->emp_id,
				'emp_type' => $request->emp_type,
				'password' =>  Hash::make($request->password),
				'user_access' =>  $request->user_access,
				'crm_limit' =>  $request->crm_limit,
				'created_by' => Auth::id(),

			])->id;
		}

		if (Auth::user()->emp_type == 'admin') {
			UserCrm::create([
				'emp_id' =>  $inserted_user_id,
				'crm_id' =>  $my_crm->id,
			]);
		}

        $users = Auth::user()->emp_type == 'admin' ? 'Agent' : 'Admin';
    	$request->session()->flash('success', $users.' Create Succefully');
		return redirect('/users');
	}

	public function edit($id, $db)
	{
		if (Auth::user()->emp_type == "super_admin") {

			Config::set('database.connections.mysql.database', $db);
		} else {


			Config::set('database.connections.mysql.database', 'cgcrm_' . $db);
		}
		DB::purge('mysql');
		$where = array('id' => $id);
		$users  = User::where($where)->first();
		return view('users.edit')->with(compact('users', 'db'));
	}

	public function update(Request $request)
	{
		if (Auth::user()->emp_type == "super_admin") {

			Config::set('database.connections.mysql.database', $request->db);

			DB::purge('mysql');
			if ($request->password != null && $request->password != '') {
				$this->validate($request, [
					'name' => 'required|string|max:255',
					'email' => 'required|string|email|max:255|unique:users,email,' . $request->id,
					'emp_id' => 'required|unique:users,emp_id,' . $request->id,
					'emp_type' => 'required',
					'password' => 'required|string|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
					'user_access' => 'required',
					'crm_limit' => 'required',

				]);
			} else {

				$this->validate($request, [
					'name' => 'required|string|max:255',
					'email' => 'required|string|email|max:255|unique:users,email,' . $request->id,
					'emp_id' => 'required|unique:users,emp_id,' . $request->id,
					'emp_type' => 'required',
					'user_access' => 'required',
					'crm_limit' => 'required',

				]);
			}
		} else {

			Config::set('database.connections.mysql.database', 'cgcrm_' . $request->db);
			DB::purge('mysql');
			if ($request->password != null && $request->password != '') {
				$this->validate($request, [
					'name' => 'required|string|max:255',
					'email' => 'required|string|email|max:255|unique:users,email,' . $request->id,
					'emp_id' => 'required|unique:users,emp_id,' . $request->id,
					'emp_type' => 'required',
					'password' => 'required|string|min:6|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
					'user_access' => 'required',

				]);
			} else {
				$this->validate($request, [
					'name' => 'required|string|max:255',
					'email' => 'required|string|email|max:255|unique:users,email,' . $request->id,
					'emp_id' => 'required|unique:users,emp_id,' . $request->id,
					'emp_type' => 'required',
					'user_access' => 'required',

				]);
			}
		}

		if (Auth::user()->emp_type == "super_admin") {
			if ($request->password != null && $request->password != '') {
				User::where('id', $request->id)->update([
					'name' => $request->name,
					'email' => $request->email,
					'emp_id' => $request->emp_id,
					'emp_type' => $request->emp_type,
					'password' => Hash::make($request->password),
					'user_access' => $request->user_access,
					'crm_limit' => $request->crm_limit,
					'updated_by' => Auth::id(),
				]);
			} else {
				User::where('id', $request->id)->update([
					'name' => $request->name,
					'email' => $request->email,
					'emp_id' => $request->emp_id,
					'emp_type' => $request->emp_type,
					'user_access' => $request->user_access,
					'crm_limit' => $request->crm_limit,
					'updated_by' => Auth::id(),
				]);
			}
		} else {


			if ($request->password != null && $request->password != '') {
				User::where('id', $request->id)->update([
					'name' => $request->name,
					'email' => $request->email,
					'emp_id' => $request->emp_id,
					'emp_type' => $request->emp_type,
					'password' => Hash::make($request->password),
					'user_access' => $request->user_access,
					'updated_by' => Auth::id(),
				]);
			} else {
				User::where('id', $request->id)->update([
					'name' => $request->name,
					'email' => $request->email,
					'emp_id' => $request->emp_id,
					'emp_type' => $request->emp_type,
					'user_access' => $request->user_access,
					'updated_by' => Auth::id(),
				]);
			}
		}






		$request->session()->flash('success', 'User Update Succefully');
		return redirect('/users');
	}

	public function delete(Request $request, $id, $db)
	{

		if (Auth::user()->emp_type == "super_admin") {

			Config::set('database.connections.mysql.database', $db);
		} else {


			Config::set('database.connections.mysql.database', 'cgcrm_' . $db);
		}
		// Config::set('database.connections.mysql.database', 'cgcrm_'.$db);
		DB::purge('mysql');
		User::where('id', $id)->delete();
		$request->session()->flash('error', 'users Delete Succefully');
		return redirect('/users');
	}


	public function updatePassword(Request $request)
	{

		$check = User::where('emp_id', $request->emp_id)->update([
			'password' =>  Hash::make($request->new_password),
		]);
		if ($check) {
			return back()->with('success', 'Password Change Successfully ');
		}
	}
	public function getUserCrm(Request $request)
	{
		$crm_masters = CrmMaster::select('crm_masters.*', 'users.name as created_by', 'u.name as updated_by')
			->leftJoin('users',  'users.id', '=', 'crm_masters.created_by')
			->leftJoin('users as u',  'u.id', '=', 'crm_masters.updated_by')
			->where('crm_masters.created_by', Auth::id())
			->get();
		$usercrm = UserCrm::where('emp_id', $request->user_id)->pluck('crm_id')->toArray();
		$uc = array_values($usercrm);
		$view = view("users.usercrmlist", compact('uc', 'crm_masters'))->render();
		return \Response::json(['html' => $view, 'status' => 'success']);
	}
	public function UserCrmUpdate(Request $request)
	{
		UserCrm::where('emp_id', $request->USerid)->delete();
		if ($request->has('crmList') && count($request->crmList) > 0) {
			foreach ($_POST['crmList'] as $crm_id) {
				$crmformFieldoption = new UserCrm();
				$crmformFieldoption->crm_id = $crm_id;
				$crmformFieldoption->emp_id = $request->USerid;
				$crmformFieldoption->save();
			}
		}

		$request->session()->flash('success', 'CRM Successfully assign to user');
		return redirect('/users');
	}
}
