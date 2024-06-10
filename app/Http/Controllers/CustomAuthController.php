<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use App\Models\CrmMaster;
use App\Models\CrmBranding;
use Illuminate\Support\Facades\Auth;
use Config;
use DB;
use Exception;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\RateLimiter;

class CustomAuthController extends Controller
{



    public function index(Request $request, $crm_name)
    {

        if (request()->segment(1)) {
            $ext_crm = CrmMaster::where('crm_name', request()->segment(1))->first();
            if (empty($ext_crm)) {

                return back()->withError('CRM Not Found!');
            }
        }
        $current_uri = request()->segments();
        $brand_data = CrmBranding::where('crm_id', $current_uri[0])->first();
        if (empty($brand_data)) {
           // die('No Branding Found For This Crm, Please Contact your Admin !');
           return back()->withError('No Branding Found For This Crm, Please Contact your Admin !');
        }

        if ($full_url = $request->fullurl()) {
        } else {

            $full_url = '';
        }


        $request->session()->put('crm_logo', isset($brand_data->logo_url) ? $brand_data->logo_url : '');
        $request->session()->put('footer_text', isset($brand_data->footer_text) ? $brand_data->footer_text : '');
        $request->session()->put('crm_title', isset($brand_data->crm_title) ? $brand_data->crm_title : '');
        return view('auth.custom.login')->with(compact('full_url', 'brand_data'));
    }

    public function customLogin(Request $request)
    {
        try {

            $request->validate([
                'emp_id' => 'required',
                'password' => 'required',
                'db' => 'required',
            ]);

            $login_url = $request->full_url;
            Config::set('database.connections.mysql.database', 'cgcrm_' . $request->db);
            DB::purge('mysql');
            $credentials = $request->only('emp_id', 'password');
            if (Auth::attempt($credentials)) {

                RateLimiter::clear($this->throttleKey());
                return redirect()->intended($request->db . '/agent-view')
                    ->with('success','Signed in succesfully');
            }else{
                $this->checkTooManyFailedAttempts();

            }
            RateLimiter::hit($this->throttleKey(), $seconds = 1800);
            return redirect($login_url)->with('error','These credentials do not match our records.');
        } catch (Exception $error) {
            // dd($error->getMessage());
            $login_url = $request->full_url;
            return redirect($login_url)->with('error','Try To login After 30 Minutes!');
        }
    }




    /**
     * Get the rate limiting throttle key for the request.
     *
     * @return string
     */
    public function throttleKey()
    {
        return Str::lower(request('email')) . '|' . request()->ip();
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @return void
     */
    public function checkTooManyFailedAttempts()
    {
        if (!RateLimiter::tooManyAttempts($this->throttleKey(), 3)) {
            return;
        }

        throw new Exception('IP address banned. Too many login attempts.');
    }


    public function signOut()
    {
        Session::flush();
        Auth::logout();
        return Redirect('login');
    }
}
