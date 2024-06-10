

<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <ul class="nav side-menu">
            @php  $crm_get_name = ''; @endphp
            @php $active= collect(request()->segments())->last() @endphp
            @php $segment= request()->segment(2) @endphp
            @php $active= request()->segment(2); @endphp
            <?php
			$type = Auth::user()->emp_type;
			if ($type == "super_admin") { ?>
            <li>
                <a><i class="fa fa-home"></i> Masters <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('users') }}" class="nav-link <?php echo $active == 'users' ? 'active' : ''; ?>"> Users</a></li>
                    <li><a href="{{ route('users-crms') }}" class="nav-link <?php echo $active == 'users-crms' ? 'active' : ''; ?>"> Users CRMs</a></li>
                </ul>
            <li>
                <a><i class="fa fa-flash"></i>Key Management <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li> <a href="{{ url('key-change') }}" class="nav-link <?php echo $active == 'key-change' ? 'active' : ''; ?>"> <i
                                class="fa fa-key"></i> Change Key</a>
                    </li>
                    <li> <a href="{{ url('key-event') }}" class="nav-link <?php echo $active == 'key-event' ? 'active' : ''; ?>"> <i
                                class="fa fa-upload"></i> Key Event</a>
                    </li>
                </ul>

                {{-- <li><a><i class="fa fa-flash"></i>Key Management <span class="fa fa-chevron-down"></span></a> --}}
                {{-- <ul class="nav child_menu">
                    <li> <a href="{{ url('change-key') }}"  onclick="return confirm('Are you sure want to change software key ?')" class="nav-link <?php echo $active == 'change-key' ? 'active' : ''; ?>"> <i
                                class="fa fa-key"></i> Change Key</a></li>
                    <li> <a href="{{ url('get-backup') }}" class="nav-link <?php echo $active == 'get-backup' ? 'active' : ''; ?>"> <i
                                class="fa fa-upload"></i> Upload Backup</a></li>
                </ul> --}}
                {{-- <li> <a href="{{ url('manage-key') }}" class="nav-link <?php echo $active == 'change-key' ? 'active' : ''; ?>"> <i class="fa fa-key"></i> Key
                    Management</a></li>
            <li> <a href="{{ url('backup-manage') }}"  class="nav-link <?php echo $active == 'get-backup' ? 'active' : ''; ?>"> <i class="fa fa-upload"></i>
                    Upload Backup</a></li> --}}
            <li> <a href="{{ route('reports') }}" class="nav-link <?php echo $active == 'reports' ? 'active' : ''; ?>"> <i class="fa fa-line-chart"></i>
                    Reports</a></li>
            <?php } ?>

            <?php
			$type = Auth::user()->emp_type;
			if ($type == "admin") { ?>
            <li><a><i class="fa fa-home"></i> Masters <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="{{ route('users') }}" class="nav-link <?php echo $active == 'users' ? 'active' : ''; ?>"> Users</a></li>
                    <li><a href="{{ route('crmmaster') }}" class="nav-link <?php echo $active == 'crm-master' ? 'active' : ''; ?>"> CRM</a></li>
                    <li><a href="{{ url('crm-campaign') }}" class="nav-link <?php echo $active == 'crm-campaign' ? 'active' : ''; ?>"> Manage Campaign</a>
                    </li>
                    <li><a href="{{ url('manage-filed-dependencies') }}" class="nav-link <?php echo $active == 'manage-filed-dependencies' ? 'active' : ''; ?>"> Filed
                            Dependencies</a></li>
                </ul>
            <li> <a href="{{ route('reports') }}" class="nav-link <?php echo $active == 'reports' ? 'active' : ''; ?>"> <i
                        class="fa fa-line-chart"></i> Reports</a></li>
            <?php } ?>
            </li>
            <?php
            if (Request::segment(1)) {
                $crm_get_name = '';
                $valid_db = App\Models\CrmMaster::where('crm_name', Request::segment(1))->get()->toArray();
                if (!empty($valid_db)) {
                    Config::set('database.connections.mysql.database', 'cgcrm_' . Request::segment(1));
                    DB::purge('mysql');
                    $crm_get_name = Request::segment(1);
                }
            }
            $get_unique = [];
            $crm_name = App\Models\CrmMaster::select('crm_masters.*')->leftJoin('user_crm', 'user_crm.crm_id', '=', 'crm_masters.id')->where('user_crm.emp_id', '=', Auth::id())->get();
            ?>
            @if (!empty($crm_name) && $crm_name->count())
                @foreach ($crm_name as $crm)
                    @if ($type != 'admin' && $type != 'super_admin')
                        <li><a><i class="fa fa-home"></i> {{ strtoupper($crm->crm_name) }}<span
                                    class="fa fa-chevron-down"></span></a>
                            <ul class="nav child_menu">
                                <?php $crmform = App\Models\CrmForm::where('crm_id', $crm->id)
                                    ->where('form_type', 1)
                                    ->get()
                                    ->toArray(); ?>
                                <?php if (count($crmform) > 0) {
						foreach ($crmform as $froms) {
                            $remitUniqeFiled = '';
                             $getFormField  = App\Models\CrmFormField::where('crm_form_id', $froms['id'])->where('is_unique', 'yes')->get()->toArray();
                             if(!empty($getFormField)){

                                foreach ($getFormField as $getUniqeField) {

                                    $remitUniqeFiled .= $getUniqeField['field_name'].'='.'DEMO_TEST'.'&';
                                }
                             }else {
                                 $remitUniqeFiled = '';
                             }
                             $remitUniqeFiled = substr($remitUniqeFiled, 0, -1);
						 ?>
                                <?php }
					} ?>
                                <?php $crmform = App\Models\CrmForm::where('crm_id', $crm->id)
                                    ->where('form_type', 2)
                                    ->where('cti_depend_form', '!=', '')
                                    ->get()
                                    ->toArray(); ?>
                                @if ($type == 'supervisor')
                                    <li>
                                    <a href="{{ url($crm_get_name . '/upload-csv-agent') }}" class="nav-link">Upload Data</a>
                                @endif
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        AGENT INPUT
                                        <i><span class="fa fa-chevron-down"></span></i>

                                    </a>

                                    <ul class="nav nav-treeview">
                                        <?php if (count($crmform) > 0) {
                                foreach ($crmform as $froms) { ?>
                                        <li> <a href="{{ url($crm_get_name . '/agent-reports', ['crmID' => $froms['crm_id'], 'crmFrm' => $froms['form_name']]) }}"
                                                class="nav-link <?php echo $active == 'agent-reports' ? 'active' : ''; ?>" style="color:#e21358f2"> Reports
                                            </a></li>
                                        <?php }
                            }
                            $crmform  = App\Models\CrmForm::where('crm_id', $crm->id)->where('form_type', 2)->where('cti_type', 3)->where('cti_depend_form', '!=', '')->get()->toArray();  ?>
                                        <?php if (count($crmform) > 0) {
                                foreach ($crmform as $froms) {
                                    $parent_name=  DB::table('crm_forms')->where('id', $froms['cti_depend_form'] )->first();
                                    ?>
                                        <?php if ($type == "agent") { ?>
                                        <li> <a href="{{ url($crm_get_name . '/open-without-cti-page/' . $froms['form_name']) }}?agent_input={{ $parent_name->form_name }}"
                                                class="nav-link <?php echo $active == 'open-without-cti-page/' . $froms['form_name'] . '?agent_input=' . $parent_name->form_name ? 'active' : ''; ?>" style="color:#f7f9f8f2">By Search
                                            </a></li>

                                        <li> <a href="{{ url($crm_get_name . '/open-without-cti-page-random-pick/' . $froms['form_name']) }}?agent_input={{ $parent_name->form_name }}"
                                                class="nav-link <?php echo $active == 'open-without-cti-page-random-pick/' . $froms['form_name'] ? 'active' : ''; ?>" style="color:#f7f9f8f2">Random
                                                Pick </a></li>
                                        <?php } ?>
                                        <?php }
                            } ?>



                                        <?php $crmform_alone = App\Models\CrmForm::where('crm_id', $crm->id)
                                            ->where('form_type', 2)
                                            ->where('cti_type', 4)
                                            ->get()
                                            ->toArray(); ?>
                                        <?php if (count($crmform_alone) > 0) {
						foreach ($crmform_alone as $froms_alone) { ?>
                                        <?php if ($type == "agent") { ?>
                                        <li> <a href="{{ url($crm_get_name . '/agent-reports', ['crmID' => $froms_alone['crm_id'], 'crmFrm' => $froms_alone['form_name']]) }}"
                                                class="nav-link <?php echo $active == 'agent-reports' ? 'active' : ''; ?>" style="color:#e21358f2"> Reports
                                            </a></li>
                                        <li> <a href="{{ url($crm_get_name . '/open-cti-page-stand-alone/' . $froms_alone['form_name']) }}"
                                                class="nav-link <?php echo $active == 'open-cti-page-stand-alone' ? 'active' : ''; ?>" style="color:#f7f9f8f2">Agent
                                                Input Stand Alone </a></li>
                                        <?php } ?>
                                        <?php if ($type == "supervisor") { ?>
                                        <li> <a href="{{ url($crm_get_name . '/agent-reports', ['crmID' => $froms_alone['crm_id'], 'crmFrm' => $froms_alone['form_name']]) }}"
                                                class="nav-link <?php echo $active == 'agent-reports' ? 'active' : ''; ?>" style="color:#e21358f2"> Reports
                                            </a></li>
                                        <?php } ?>

                                        <?php }
					} ?>
                                    </ul>
                                </li>

                            </ul>
                        </li>
                    @endif
                @endforeach
            @endif

        </ul>
    </div>


</div>
<!-- /sidebar menu -->

<!-- /menu footer buttons -->
<div class="sidebar-footer hidden-small">
    <!--
 <a data-toggle="tooltip" data-placement="top" title="Settings">
  <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
 </a>
 <a data-toggle="tooltip" data-placement="top" title="FullScreen">
  <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
 </a>
 <a data-toggle="tooltip" data-placement="top" title="Lock">
  <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
 </a>
 <a data-toggle="tooltip" data-placement="top" title="Logout" href="{{ url('logout') }}">
  <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
 </a>-->
</div>
<!-- /menu footer buttons -->
</div>
</div>
<!-- top navigation -->
<div class="top_nav">
    <div class="nav_menu">
        <nav>
            @if (!empty(Session::get('crm_logo')))
                <div class="nav toggle">
                    <a id="menu_toggle" onclick="logoShift()"><i class="fa fa-bars"></i></a>
                    <input type="hidden" id="togal_value" value='1'>
                </div>
            @else
                <div class="nav toggle">
                    <a id="menu_toggle" onclick="logoShiftAdmin()"><i class="fa fa-bars"></i></a>
                    <input type="hidden" id="togal_value" value='1'>
                </div>
            @endif

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown"
                        aria-expanded="false">
                        {{ Auth::user()->name }} ({{ Auth::user()->emp_type }})
                       <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        {{-- <li> <a href="#" data-toggle="modal" data-target="#changepassword" class="dropdown-item">
								<i class="fa fa fa-key mr-2"></i></i> Change Password

							</a></li> --}}
                        @if (Auth::user()->emp_type == 'admin' || Auth::user()->emp_type == 'super_admin')
                            <li><a data-toggle="modal" data-target="#exampleModal"><i class="fa fa-key"></i> Change
                                    Password</a></li>
                            <li><a href="{{ url('logout') }}"><i class="fa fa-sign-out"></i> Log Out</a></li>
                        @else
                            <li><a data-toggle="modal" data-target="#exampleModal"><i class="fa fa-key"></i> Change
                                    Password</a></li>
                            <li><a href="{{ url($crm_get_name . '/logout-user') }}"><i class="fa fa-sign-out"></i>
                                    Log Out</a></li>
                        @endif

                    </ul>
                </li>
            </ul>
        </nav>
    </div>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> --}}

                {{-- <form method="POST" action="{{ url('changePassword') }}"> --}}
                {{-- @csrf --}}
                <div class="form-group">
                    <label for="exampleInputEmail1">Old Password</label>
                    <input type="password" class="form-control" name="old_pass" id="old_pass"
                        aria-describedby="emailHelp" placeholder="Old Password">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">New Password</label>
                    <input type="password" class="form-control" name="new_pass" id="new_pass"
                        placeholder="New Password">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Confirm Password</label>
                    <input type="password" class="form-control" name="conf_pass" id="conf_pass"
                        placeholder="Confirm Password">
                </div>
                @if (Auth::user()->emp_type == 'admin' || Auth::user()->emp_type == 'super_admin')
                    <button type="submit" class="btn btn-primary" onclick="changePassword()">Submit</button>
                    <p id="send_error_message"></p>
                @else
                    <button type="submit" class="btn btn-primary" onclick="changePasswordCti()">Submit</button>
                    <p id="send_error_message"></p>
                @endif
                {{-- </form> --}}
            </div>
        </div>
    </div>
</div>
<script>
    function logoShift() {

        togal_value = $('#togal_value').val();
        old_width = $('img').attr("width");
        old_height = $('img').attr("height");
        if (togal_value == '1') {
            $('#togal_value').val('0');
        } else {
            $('#togal_value').val('1');
        }
        togal_value = $('#togal_value').val();
        console.log(togal_value);
        if (togal_value == 0) {
            $('#logo_img').attr("width", "50");
            $('#logo_img').attr("height", "50");
        } else {
            $('#logo_img').attr("width", `73%`);
            $('#logo_img').attr("height", `73`);

        }
    }


    function logoShiftAdmin() {

        togal_value = $('#togal_value').val();
        old_width = $('img').attr("width");
        old_height = $('img').attr("height");
        if (togal_value == '1') {
            $('#togal_value').val('0');
        } else {
            $('#togal_value').val('1');
        }
        togal_value = $('#togal_value').val();
        console.log(togal_value);
        if (togal_value == 0) {
            $('#logo_img').attr("width", "50");
            $('#logo_img').attr("height", "50");
            $('#logo_img').attr("src", 'http://192.168.220.20/o3/public/images/cog44.png');
            // $('#logo_img').attr("src", 'public/images/cog44.png');
            $('#logo_img').attr("style", 'border-radius:50%');
        } else {
            $('#logo_img').attr("width", `73%`);
            $('#logo_img').attr("height", `73`);
            $('#logo_img').attr("src", 'http://192.168.220.20/o3/public/images/cog.png');
            $('#logo_img').attr("style", '');


        }
    }
</script>

<script>
    function changePassword() {

        old_pass = $('#old_pass').val();
        new_pass = $('#new_pass').val();
        conf_pass = $('#conf_pass').val();

        if (old_pass == '' || new_pass == '' || conf_pass == '') {
            $('#send_error_message').text('* All Filed Are Required').css('color', 'red');
        } else {
            $.ajax({
                url: "{{ url('updatePassword') }}",
                type: 'POST',
                data: {
                    old_pass: old_pass,
                    new_pass: new_pass,
                    conf_pass: conf_pass,
                    emp_type: "{{ Auth::user()->emp_type }}",
                    crm_name: "{{ $crm_get_name }}",
                    _token: '{!! csrf_token() !!}',
                },
                success: function(result) {

                    if (result == 0) {
                        $('#send_error_message').text('* Old password Not Match').css('color', 'red');
                    } else if (result == 1) {
                        $('#send_error_message').text('* Confirm password Not Match').css('color', 'red');
                    } else {
                        $('#exampleModal').modal('hide');
                    }
                    // alert('success');
                }
            });
            $('#send_error_message').text('Please Wait ..').css('color', 'blue');
        }

    }

    function changePasswordCti() {

        old_pass = $('#old_pass').val();
        new_pass = $('#new_pass').val();
        conf_pass = $('#conf_pass').val();

        if (old_pass == '' || new_pass == '' || conf_pass == '') {
            $('#send_error_message').text('* All Filed Are Required').css('color', 'red');
        } else {
            $.ajax({
                url: "{{ url($crm_get_name . '/' . 'updatePasswordCti') }}",
                type: 'POST',
                data: {
                    old_pass: old_pass,
                    new_pass: new_pass,
                    conf_pass: conf_pass,
                    emp_type: "{{ Auth::user()->emp_type }}",
                    crm_name: "{{ $crm_get_name }}",
                    _token: '{!! csrf_token() !!}',
                },
                success: function(result) {

                    if (result == 0) {
                        $('#send_error_message').text('* Old password Not Match').css('color', 'red');
                    } else if (result == 1) {
                        $('#send_error_message').text('* Confirm password Not Match').css('color', 'red');
                    } else {
                        $('#exampleModal').modal('hide');
                    }
                    // alert('success');
                }
            });
            $('#send_error_message').text('Please Wait ..').css('color', 'blue');
        }

    }
</script>
<!-- /top navigation -->
