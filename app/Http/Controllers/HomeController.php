<?php

namespace App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
/*use Illuminate\Support\Facades\Storage;
use DB;
use Excel; */


use App\Models\User;
use Carbon\Carbon;
use App\Models\CrmMaster;

date_default_timezone_set('Asia/Kolkata');

class CrmController extends Controller
{
	public function __construct()
	{
		//DB::enableQueryLog();
		$this->middleware('auth');
	}


	public function index(Request $request)
	{
		//dd("adasds");
		$crm_masters = CrmMaster::select('crm_masters.*', 'users.name as created_by', 'u.name as updated_by')
			->leftJoin('users',  'users.id', '=', 'crm_masters.created_by')
			->leftJoin('users as u',  'u.id', '=', 'crm_masters.updated_by')
			->get();
		//dd($result);
		//$users = User::all();

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
		//print_r($_POST);exit;
		$this->validate($request, [
			'crm_name' => 'required|string',

		]);
		CrmMaster::create([
			'crm_name' => $request->crm_name,
			'created_by' => Auth::id(),

		]);
		$request->session()->flash('success', 'Crm Create Succefully');
		return redirect('/crm_masters');
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
		return redirect('/crm_masters');
	}

	public function delete(Request $request, $id)
	{

		CrmMaster::where('id', $id)->delete();
		$request->session()->flash('error', 'crm Delete Succefully');
		return redirect('/crm_masters');
	}
}
