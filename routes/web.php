<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxMasterController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\CrmMasterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CtiPage;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/clear', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:clear');
    Artisan::call('view:clear');
    return "Cache is cleared";
});

Route::get('/welcome', function () {
    return view('welcome');
});

Route::get('/', function () {
    return view('welcome');
});
Route::get('/logout', function () {
    Auth::logout();
    return Redirect::to('login');
});

Route::get('{dbname}/logout-user', function ($process_name) {
    Auth::logout();
    return Redirect::to($process_name.'/login-user');
});

Auth::routes();
// Route::get('/{crm_name}/login', 'App\Http\Controllers\Auth\LoginController@showLoginFormNew');
// Route::get('dashboard', [CustomAuthController::class, 'dashboard']);

Route::get('{crm_name}/login-user', [CustomAuthController::class, 'index'])->name('login-user');
Route::post('custom-login', [CustomAuthController::class, 'customLogin'])->name('login.custom');
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('custom-registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom');
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout');


Route::group(['middleware' => 'auth'], function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/{db}/agent-view', [DashboardController::class, 'agentView'])->name('agentView');
    Route::post('/password/change', [App\Http\Controllers\UserController::class, 'updatePassword'])->name('updatePassword');

    /*Common Route for admin and super-admin users route*/
    Route::group(['middleware' => ['is-common']], function() {
            Route::get('/users', [UserController::class, 'getEmployeesAll'])->name('users');
            Route::get('/users/add', [App\Http\Controllers\UserController::class, 'add'])->name('users.add');
            Route::get('/users/edit/{id}/{dbname}', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
            Route::post('/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
            Route::post('/users/update', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
            Route::get('/users/delete/{id}/{dbname}/', [App\Http\Controllers\UserController::class, 'delete'])->name('users.delete');
            Route::get('/users/getEmployees/', [App\Http\Controllers\UserController::class, 'getEmployees'])->name('users.getEmployees');
            Route::get('/getEmployeesAll', [App\Http\Controllers\UserController::class, 'getEmployeesAll'])->name('users.getEmployeesAll');
            Route::post('/users/getUserCrm', [App\Http\Controllers\UserController::class, 'getUserCrm'])->name('getUserCrm');
            Route::post('/users/UserCrmUpdate', [App\Http\Controllers\UserController::class, 'UserCrmUpdate'])->name('UserCrmUpdate');
            Route::get('/reports', [ReportController::class, 'index'])->name('reports');
            Route::post('/reports', [ReportController::class, 'index'])->name('reports.index');
    });

     // Supper Admin Routes
    Route::group(['middleware' => ['is-super-admin']], function() {
            Route::get('/users-crms', [UserController::class, 'getUsersCrms'])->name('users-crms');
            Route::get('/change-key', [CrmMasterController::class, 'changeKey'])->name('crmmaster.changeKey');
            Route::get('/get-backup', [CrmMasterController::class, 'getBackup'])->name('crmmaster.getBackup');
            Route::get('/key-change', [CrmMasterController::class, 'mamageKey'])->name('crmmaster.mamageKey');
            Route::get('/key-event', [CrmMasterController::class, 'backupAll'])->name('crmmaster.backupAll');

    });

     /* users route end  admin routes */
    // start admin routes //
    Route::group(['middleware' => ['is-admin']], function() {
            Route::get('/getUniquePara', [CrmMasterController::class, 'getUniquePara'])->name('getUniquePara');
            Route::get('/crm-master', [CrmMasterController::class, 'index'])->name('crmmaster');
            Route::get('/crm-masters/add', [CrmMasterController::class, 'add'])->name('crmmaster.add');
            Route::get('/crm-masters/edit/{id}', [CrmMasterController::class, 'edit'])->name('crmmaster.edit');
            Route::post('/crm-masters/create', [CrmMasterController::class, 'create'])->name('crmmaster.create');
            Route::post('/crm-masters/update', [CrmMasterController::class, 'update'])->name('crmmaster.update');
            Route::get('/crm-masters/delete/{id}', [CrmMasterController::class, 'delete'])->name('crmmaster.delete');
            Route::get('/crm-campaign', [CrmMasterController::class, 'manageCampaign'])->name('manageCampaign');
            Route::get('/crm-get-dropdown', [CrmMasterController::class, 'getDropdown'])->name('getDropdown');
            Route::get('/crm-get-dropdown-option', [CrmMasterController::class, 'getOption'])->name('getOption');
            Route::get('/crm-get-dropdown-option-depend', [CrmMasterController::class, 'getOptionDepend'])->name('getOptionDepend');
            Route::get('/crm-get-dropdown-manage-filed', [CrmMasterController::class, 'getDropdownManageFiled'])->name('getDropdownManageFiled');
            Route::get('/crm-get-dropdown-make-depend', [CrmMasterController::class, 'getDropdownMakeDepend'])->name('getDropdownMakeDepend');
            Route::post('/saveCampaigen', [CrmMasterController::class, 'saveCampaigen'])->name('saveCampaigen');
            Route::post('/saveDependFiled', [CrmMasterController::class, 'saveDependFiled'])->name('saveDependFiled');
            Route::get('/deleteCampaign/{id}', [CrmMasterController::class, 'deleteCampaign'])->name('deleteCampaign');
            Route::get('/deleteDependencie/{id}/{dbname}', [CrmMasterController::class, 'deleteDependencie'])->name('deleteDependencie');
            Route::get('/manage-filed-dependencies', [CrmMasterController::class, 'manageFiledDepends'])->name('manage-filed-dependencies');
            /*Manage fileds */
            Route::get('/manage-fields/{id}', [CrmMasterController::class, 'manage_fields'])->name('managefield');
            Route::get('/api-code/{id}', [CrmMasterController::class, 'apiCode'])->name('api-code');
            Route::get('/get-cti-link/{id}', [CrmMasterController::class, 'getCtiLink'])->name('get-cti-link');
            Route::post('/newfields', [CrmMasterController::class, 'newfields'])->name('addNewField');
            Route::post('/updatefields', [CrmMasterController::class, 'updatefields'])->name('updateField');
            Route::post('/createForm', [CrmMasterController::class, 'create_from'])->name('crmmaster.createForm');
            Route::post('/getcrmFormoptions', [CrmMasterController::class, 'getcrmFormoptions'])->name('getcrmFormoptions');
            /*Manage fileds end*/
            /*Manage options */
            Route::get('/manage-options/{id}', [CrmMasterController::class, 'manage_options'])->name('manageoptions');
            Route::post('/get-crmform-fields', [CrmMasterController::class, 'getcrmFormfields'])->name('getcrmFormfields');
            Route::post('/saveOptions', [CrmMasterController::class, 'saveOptions'])->name('crmmaster.saveOptions');
            Route::post('/{dbname}/addChildField', [CrmMasterController::class, 'addChildField'])->name('addChildField');
            Route::post('/get-crmform', [CrmMasterController::class, 'getcrmForm'])->name('getcrmForm');
            Route::post('/get-crmtype', [CrmMasterController::class, 'getcrmType'])->name('getcrmType');
            Route::get('/crm-branding/{dbname}', [CrmMasterController::class, 'crmBranding'])->name('crmBranding');
            Route::post('/saveBranding', [CrmMasterController::class, 'saveBranding'])->name('saveBranding');
    });
         // end admin routes //
          //  Agents Routes
    Route::group(['middleware' => ['is-agent']], function() {
            Route::get('/{dbname}/open-without-cti-page/{slug}', [App\Http\Controllers\CtiPage::class, 'openWithoutCti'])->name('open-without-cti-page');
            Route::post('/{dbname}/openSearchAgentData', [App\Http\Controllers\CtiPage::class, 'openSearchAgentData'])->name('openSearchAgentData');
            Route::post('/{dbname}/openSubmitAgentFormWithOut', [App\Http\Controllers\CtiPage::class, 'openSubmitAgentFormWithOut'])->name('openSubmitAgentFormWithOut');
            Route::get('/{dbname}/open-without-cti-page-random-pick/{slug}', [App\Http\Controllers\CtiPage::class, 'openWithoutCtiRandom'])->name('open-without-cti-page-random-pick');
            Route::post('/{dbname}/openSearchAgentDataRandom', [App\Http\Controllers\CtiPage::class, 'openSearchAgentDataRandom'])->name('openSearchAgentDataRandom');
            Route::get('/{dbname}/open-cti-page-stand-alone/{slug}', [App\Http\Controllers\CtiPage::class, 'standAlone'])->name('open-cti-page-stand-alone');
            Route::any('/{dbname}/updatePasswordCti', [App\Http\Controllers\CtiPage::class, 'updatePasswordCti'])->name('updatePasswordCti');
            /*Manage options end*/
            Route::post('/submit-data', [DashboardController::class, 'SubmitAgentForm'])->name('SubmitAgentForm');
            Route::post('/{dbname}/editAgentForm', [DashboardController::class, 'editAgentForm'])->name('editAgentForm');
            Route::any('/{dbname}/agent-reports/{crmID}/{crmFrm}', [ReportController::class, 'agentReports'])->name('agent-reports');
            // Manage Database Column of CRM
    });


    Route::group(['middleware' => ['is-super-visor']], function() {
        Route::post('/{dbname}/editAgentForm', [DashboardController::class, 'editAgentForm'])->name('editAgentForm');
        Route::any('/{dbname}/agents-reports/{crmID}/{crmFrm}', [ReportController::class, 'agentReports'])->name('agent-reports');
        Route::get('/{dbanme}/upload-csv-agent/', [App\Http\Controllers\CtiPage::class, 'uploadCsvFormat'])->name('upload-csv-agent');
        Route::post('/{dbanme}/upload-csv-agent-submit', [App\Http\Controllers\CtiPage::class, 'uploadCsvFormatPost'])->name('upload-csv-agent-submit');
        Route::get('{crmname}/download-csv/{slug}', [DashboardController::class, 'downloadCsvFormatForAgent']);
     });

        Route::get('/manage-columns/{id}', [CrmMasterController::class, 'manage_columns'])->name('managecolumns');
        Route::post('/get-crmform-columns', [AjaxMasterController::class, 'getcrmColumns'])->name('getcrmColumns');
        Route::post('/updatePassword', [AjaxMasterController::class, 'updatePassword'])->name('updatePassword');
        Route::post('/update-column', [CrmMasterController::class, 'update_column'])->name('update-column');
        Route::get('/form-test', [DashboardController::class, 'ViewPageTest']);
        Route::get('/{slug}', [DashboardController::class, 'ViewPage']);
        Route::get('download-csv/{slug}', [DashboardController::class, 'downloadCsvFormat']);
        Route::get('upload/{slug}', [DashboardController::class, 'uploadCsvFormat']);
        Route::post('upload-csv', [DashboardController::class, 'uploadCsvFormatPost'])->name('upload-csv');
        Route::get('/{dbname}/{slug}/{edit}/{id}', [DashboardController::class, 'editPage']);
        Route::get('/cti-page/{slug}', [App\Http\Controllers\DashboardController::class, 'openCti'])->name('cti-page');
        Route::get('/{dbname}/testCti/{slug}', [App\Http\Controllers\CtiPage::class, 'testCti'])->name('testCti');
});


  Route::get('/{dbanme}/open-cti-page/{slug}', [App\Http\Controllers\CtiPage::class, 'index'])->name('open-cti-page');
  Route::get('clear-chunk/{slug}', [App\Http\Controllers\CtiPage::class, 'clearChunk'])->name('clear-chunk');
  Route::post('/openAddChildField', [App\Http\Controllers\CtiPage::class, 'openAddChildField'])->name('openAddChildField');
  Route::post('/{dbname}/openSubmitAgentForm', [App\Http\Controllers\CtiPage::class, 'openSubmitAgentForm'])->name('openSubmitAgentForm');
  Route::post('/{dbname}/standAloneSubmit', [App\Http\Controllers\CtiPage::class, 'standAloneSubmit'])->name('standAloneSubmit');
  Route::get('/dummy-dailer/{slug}', [App\Http\Controllers\CtiPage::class, 'dummyDailerOpen'])->name('dummy-dailer');
  Route::get('/{dbname}/login-api', [App\Http\Controllers\CtiPage::class, 'authenticate'])->name('login-api');
  Route::group(['middleware' => ['jwt.verify']], function() {
  Route::any('/{dbname}/SubmitAgentApi/{slug}', [App\Http\Controllers\CtiPage::class, 'SubmitAgentApi'])->name('SubmitAgentApi');

});
