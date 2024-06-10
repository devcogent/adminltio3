
<body class="sidebar-mini layout-fixed sidebar-collapse text-sm">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="javascript:void(0)" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>

            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Welcome&nbsp; {{ Auth::user()->name }} &nbsp;
                        ({{ Auth::user()->emp_type }})
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                     @php $crm_name =  Request::segment(1); @endphp

                        <a class="dropdown-item" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-key"></i>
                            {{ __('Change Password') }}</a>
                           @if (Auth::user()->emp_type == 'admin' || Auth::user()->emp_type == 'super_admin')
                         <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <div class="nav-item">
                                    <a class="nav-link" href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                this.closest('form').submit(); "
                                        role="button">
                                        <i class="fas fa-sign-out-alt"></i>
                                        {{ __('Log Out') }}
                                    </a>

                                </div>
                            </form>
                            @else
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ url($crm_name. '/logout-user') }}"><i class="fa fa-sign-in" aria-hidden="true"></i>

                                Log Out</a>
                            @endif
                      </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <div class="user-panel d-flex" style="background-color: white;height: 3.6rem;">
            <!-- For Small Logo -->

            @if(!empty(Session::get('crm_logo')))
                @php $logo = Session::get('crm_logo'); @endphp
            @else
               @php $logo = "logo.png"; @endphp
            @endif

            @if(Auth::user()->emp_type == 'agent')
                @php $favicon = 'public/images/'.$logo; @endphp
            @else
                @php $favicon = 'public/img/cog44.png'; @endphp
            @endif

            <img src="{{ asset($favicon) }}" alt="o3" class="brand-image-xs logo-xs mt-2" style="height: 23px; width: 24px;
            margin-left: -0.2rem; position: relative; left: 27px;">


            <!-- For Big Logo -->
            <img src="{{ asset('public/images/'.$logo) }}" alt="o3" class="brand-image-xl logo-xl" style="height: 2.7rem;width: 12rem;margin-left: 1rem;">
        </div>



            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user (optional) -->
                 <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        @php  $crm_get_name = ''; @endphp
                        @php $slug= request()->segment(2); @endphp
                        @php $active= collect(request()->segments())->last() @endphp
                        @php  $type = Auth::user()->emp_type; @endphp

                        @if($type == "super_admin")

                            <li class="nav-item">
                                <a href="{{ route('users') }}" class="nav-link <?php echo $active == 'users' ? 'active' : ''; ?>">
                                  <i class="nav-icon fas fa-users"></i>
                                  <p>Users</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('users-crms') }}" class="nav-link <?php echo $active == 'users-crms' ? 'active' : ''; ?>">
                                  <i class="nav-icon fas fa-th"></i>
                                  <p>Users CRMs</p>
                                </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{ url('key-change') }}" class="nav-link <?php echo $active == 'key-change' ? 'active' : ''; ?>">
                                  <i class="nav-icon fa fa-key"></i>
                                  <p>Change Key</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('key-event') }}" class="nav-link <?php echo $active == 'key-event' ? 'active' : ''; ?>">
                                  <i class="nav-icon fa fa-key"></i>
                                  <p>Key Event</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('reports') }}" class="nav-link <?php echo $active == 'reports' ? 'active' : ''; ?>">
                                  <i class="nav-icon fas fa-th"></i>
                                  <p>Reports</p>
                                </a>
                            </li>
                        @endif



                        @if($type == "admin")

                            <li class="nav-item">
                                <a href="{{ route('users') }}" class="nav-link <?php echo $active == 'users' ? 'active' : ''; ?>">
                                  <i class="nav-icon fas fa-users"></i>
                                  <p>Users</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('crmmaster') }}" class="nav-link <?php echo $active == 'crm-master' ? 'active' : ''; ?>">
                                    <i class="nav-icon fas fa-th"></i>
                                  <p>CRM Master</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('crm-campaign') }}" class="nav-link <?php echo $active == 'crm-campaign' ? 'active' : ''; ?>">
                                    <i class="nav-icon fa fa-list" aria-hidden="true"></i>
                                  <p>Manage Campaign</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ url('manage-filed-dependencies') }}" class="nav-link <?php echo $active == 'manage-filed-dependencies' ? 'active' : ''; ?>">
                                <i class="nav-icon fas fa-th"></i>
                                  <p>Filed Dependencies</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('reports') }}" class="nav-link <?php echo $active == 'reports' ? 'active' : ''; ?>">
                                  <i class="nav-icon fas fa-th"></i>
                                    <p>Reports</p>
                                </a>
                            </li>


                       @endif

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
                                                <li class="nav-item">
                                                    <a href="{{ url($crm_get_name . '/upload-csv-agent') }}" class="nav-link <?php echo $slug == 'upload-csv-agen' ? 'active' : ''; ?>">
                                                      <i class="nav-icon fas fa-th"></i>
                                                        <p>Upload Data</p>
                                                    </a>
                                                </li>

                                            @endif


                                            @php $reports = 'agent-reports'; @endphp
                                            @if($type != 'agent')
                                              @php $reports = 'agents-reports'; @endphp
                                            @endif
                                                    <?php if (count($crmform) > 0 ) {

                                            foreach ($crmform as $froms) { ?>
                                                       <li class="nav-item">
                                                            <a href="{{ url($crm_get_name . '/'.$reports, ['crmID' => $froms['crm_id'], 'crmFrm' => $froms['form_name']]) }}" class="nav-link <?php echo $slug == 'agent-reports' ? 'active' : ''; ?>">
                                                              <i class="nav-icon fa fa-file-excel"></i>
                                                                 <p>Reports</p>
                                                            </a>
                                                        </li>

                                                    <?php }
                                        }
                                        $crmform  = App\Models\CrmForm::where('crm_id', $crm->id)->where('form_type', 2)->where('cti_type', 3)->where('cti_depend_form', '!=', '')->get()->toArray();  ?>
                                                    <?php if (count($crmform) > 0) {
                                            foreach ($crmform as $froms) {
                                                $parent_name=  DB::table('crm_forms')->where('id', $froms['cti_depend_form'] )->first();
                                                ?>
                                                    <?php if ($type == "agent") { ?>


                                                        <li class="nav-item">
                                                            <a href="{{ url($crm_get_name . '/open-without-cti-page/' . $froms['form_name']) }}?agent_input={{ $parent_name->form_name }}" class="nav-link <?php echo $slug == 'open-without-cti-page' ? 'active' : ''; ?>">
                                                              <i class="nav-icon fas fa-search"></i>
                                                                <p>By Search</p>
                                                            </a>
                                                        </li>

                                                        <li class="nav-item">
                                                            <a href="{{ url($crm_get_name . '/open-without-cti-page-random-pick/' . $froms['form_name']) }}?agent_input={{ $parent_name->form_name }}" class="nav-link <?php echo $slug == 'open-without-cti-page-random-pick' ? 'active' : ''; ?>">
                                                              <i class="nav-icon fa fa-random"></i>
                                                                <p>Random Pick</p>
                                                            </a>
                                                        </li>

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

                                                    <li class="nav-item">
                                                        <a href="{{ url($crm_get_name . '/agent-reports', ['crmID' => $froms_alone['crm_id'], 'crmFrm' => $froms_alone['form_name']]) }}" class="nav-link  <?php echo $active == 'agent-reports' ? 'active' : ''; ?>">
                                                          <i class="nav-icon fa fa-file-excel"></i>
                                                            <p>Reports</p>
                                                        </a>
                                                    </li>

                                                    <li class="nav-item">
                                                        <a href="{{ url($crm_get_name . '/open-cti-page-stand-alone/' . $froms_alone['form_name']) }}" class="nav-link <?php echo $active == 'open-cti-page-stand-alone' ? 'active' : ''; ?>">
                                                          <i class="nav-icon fa fa-retweet"></i>
                                                            <p>Agent Input Stand Alone</p>
                                                        </a>
                                                    </li>

                                                    <?php } ?>
                                                    <?php if ($type == "supervisor") { ?>
                                                       <li class="nav-item">
                                                            <a href="{{ url($crm_get_name . '/agents-reports', ['crmID' => $froms_alone['crm_id'], 'crmFrm' => $froms_alone['form_name']]) }}" class="nav-link  <?php echo $active == 'agents-reports' ? 'active' : ''; ?>">
                                                              <i class="nav-icon fa fa-file-excel"></i>
                                                                <p>Reports</p>
                                                            </a>
                                                        </li>
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
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>
        <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  <h1>@isset($title){{ $title }}@endisset </h1>
                </div>
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">@isset($title) Home @endisset</a></li>
                    <li class="breadcrumb-item active">@isset($title){{ $title }}@endisset</li>
                  </ol>
                </div>
              </div>
            </div>
          </section>
    @yield('content')

