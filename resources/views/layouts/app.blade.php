<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('images/wmu_favicon.png') }}" type="image/png" sizes="32x32">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link href="https://pro.fontawesome.com/releases/v5.1.0/css/all.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,900&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/responsive.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/jquery.mCustomScrollbar.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/iziToast.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-multiselect.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <script type="text/javascript">
        var base_url = "{{ url('/') }}";
    </script>
</head>
<body>
    <div class="loader">
        <span class="dashboard-spinner spinner-md"></span>
    </div>
    <header class="header_cl">
        <div class="web_logo">
            <a href="{{ url('/') }}"><img id="web-logo-image" width="58" height="58" src="{{ asset('images/gas-logo.png') }}"></a>
        </div>
        @if(Auth::user()->user_type_id == organizationAdminUserTypeId() || Auth::user()->user_type_id == superAdminUserTypeId())
            <div class="upload_logo_UI">
             {{ Form::open(array('route' => array('dashboard.image-upload', Auth::user()->id), 'id' => 'userForm')) }}
             @method('PUT')
                @if(!empty(Auth::user()->logo_image))
                    <a href="javascript:void(0);" id="userlogo" class="web-logo-change">
                        <img src="{{ Auth::user()->logo_image }}" id="user-logo-image" accept="image/*" style="height: 97%;width: 99%;filter: none;object-fit: cover;">
                    </a>
                @else
                    <a href="javascript:void(0);" id="userlogo" class="web-logo-change">
                        <img src="{{ asset('images/icon-upload.svg') }}" id="user-logo-image" accept="image/*"><span>Upload your own logo</span>
                    </a>
                @endif
            {{ Form::close() }}  
            </div>
            <input type="file" name="logo_image" id="user-logo" style="display: none;">
        @endif

        <div class="menu_right_header"> 
            <div class="sec_mobile_menuTo">
                <a href="javascript:void(0);" class="toggle_menuswp"><i class="fas fa-bars"></i></a>
                <ul class="formob_device">
                    <li class="{{ (request()->is('dashboard')) ? 'active' : '' }}"><a href="{{ route('dashboard') }}">Home</a></li>
                    @can('accessProgramModule')
                        <li class="{{ (request()->is('program')) ? 'active' : '' }}"><a href="{{ route('program.index') }}">Programs</a></li>
                    @endcan
                     @can('accessOrganizationModule') 
                        <li class="{{ (request()->is('organization')) ? 'active' : '' }}"><a href="{{ route('organization.index') }}">Organizations</a></li>
                    @endcan
                    @can('accessSupervisorModule')        
                        <li class="{{ (request()->is('supervisor')) ? 'active' : '' }}"><a href="{{ route('supervisor.index') }}">Supervisors = {{ \App\Models\Organization::where(['id' => Auth::user()->organization_id])->pluck('supervisor_label')->first() }}</a></li>
                    @endcan
                    @can('accessProviderModule')
                        <li class="{{ (request()->is('provider')) ? 'active' : '' }}"><a href="{{ route('provider.index') }}">Providers</a></li>
                    @endcan
                    @can('accessParticipantModule')
                        <li class="{{ (request()->is('participant')) ? 'active' : '' }}"><a href="{{ route('participant.index') }}">Participants</a></li>
                    @endcan
                    @can('accessGoalModule')
                        <li class="{{ (request()->is('goal')) ? 'active' : '' }}"><a href="{{ route('goal.index') }}">Goals</a></li>
                    @endcan
                    @can('accessReportModule')
                        <li class="{{ (request()->is('reports')) ? 'active' : '' }}"><a href="{{ route('reports') }}">Reports</a></li>
                    @endcan
                </ul>
            </div>           
            <div class="topbar">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="javascript:void(0);" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <img class="img-profile rounded-circle" src="{{!empty(Auth::user()->image) ? Auth::user()->image : ''}}">
                    <span class="d-none d-lg-inline">{{ Auth::user()->first_name.' '.Auth::user()->last_name }}</span>
                </a>
                <!-- Here's the magic. Add the .animate and .slide-in classes to your .dropdown-menu and you're all set! -->
                <div class="dropdown-menu dropdown-menu-right animate slideIn" aria-labelledby="navbarDropdown">
                    @if(Auth::user()->user_type_id == 4)
                        <a class="dropdown-item" href="{{ route('participant.profile.index') }}">My Account</a>
                    @elseif(Auth::user()->user_type_id == 3)
                        <a class="dropdown-item" href="{{ route('provider.profile.index') }}">My Account</a>
                    @elseif(Auth::user()->user_type_id == 2)
                        <a class="dropdown-item" href="{{ route('supervisor.profile.index') }}">My Account</a>
                    @else    
                        <a class="dropdown-item" href="{{ route('admin.profile.index') }}">My Account</a> 
                    @endif

                    @if(Auth::user()->isSuperAdmin() || Auth::user()->isOrganizationAdmin())
                        <a class="dropdown-item" href="{{ route('event.index') }}">Event Logs</a>
                    @endif

                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Sign Out</a>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                </form>
                </li>
            </ul>
            </div>
            <div class="top_sec_menu">               
                <ul class="fordesk_device">
                    <li class="{{ (request()->is('dashboard')) ? 'active' : '' }}"><a href="{{ route('dashboard') }}">Home</a></li>
                    @can('accessProgramModule')
                        <li class="{{ (request()->is('program')) ? 'active' : '' }}"><a href="{{ route('program.index') }}">@if(Auth::user()->isSuperAdmin()) Programs @else {{ \App\Models\Organization::where(['id' => Auth::user()->organization_id])->pluck('program_label')->first() }}s @endif</a></li>
                    @endcan
                    @can('accessOrganizationModule')
                        <li class="{{ (request()->is('organization')) ? 'active' : '' }}"><a href="{{ route('organization.index') }}">Organizations</a></li>
                    @endcan
                    @can('accessSupervisorModule')        
                        <li class="{{ (request()->is('supervisor')) ? 'active' : '' }}"><a href="{{ route('supervisor.index') }}">@if(Auth::user()->isSuperAdmin()) Supervisors @else {{ \App\Models\Organization::where(['id' => Auth::user()->organization_id])->pluck('supervisor_label')->first() }}s @endif</a></li>
                    @endcan
                    @can('accessProviderModule')
                        <li class="{{ (request()->is('provider')) ? 'active' : '' }}"><a href="{{ route('provider.index') }}">@if(Auth::user()->isSuperAdmin()) Providers @else {{ \App\Models\Organization::where(['id' => Auth::user()->organization_id])->pluck('provider_label')->first() }}s @endif</a></li>
                    @endcan
                    @can('accessParticipantModule')
                        <li class="{{ (request()->is('participant')) ? 'active' : '' }}"><a href="{{ route('participant.index') }}">@if(Auth::user()->isSuperAdmin()) Participants @else {{ \App\Models\Organization::where(['id' => Auth::user()->organization_id])->pluck('participant_label')->first() }}s @endif</a></li>
                    @endcan
                    @can('accessGoalModule')
                        <li class="{{ (request()->is('goal')) ? 'active' : '' }}"><a href="{{ route('goal.index') }}">
                            @if(Auth::user()->user_type_id == 4)
                                My Goals
                            @else
                                Goals
                            @endif
                        </a></li>
                    @endcan
                    @can('accessReportModule')
                        <li class="{{ (request()->is('reports')) ? 'active' : '' }}"><a href="{{ route('reports') }}">Reports</a></li>
                    @endcan
                </ul>
            </div>
        </div>
    </header>
    @yield('content')
    <div class="footer">
        <span class="footer-text">© {{config('constants.FOOTER_APP_NAME')}} {{date('Y')}}</span>
    </div>
    <div id="bsModalContent"></div>
</body>
    

<!-- All Scripts -->
<script src="{{ asset('js/jquery-3.4.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/popper.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/select2.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.dataTables.min.js') }}" defer></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}" defer></script>
<script src="{{ asset('js/dataTables.responsive.min.js') }}" defer></script>
<script src="{{ asset('js/dataTables.scroller.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.mCustomScrollbar.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/responsive.bootstrap4.min.js') }}" defer></script>
<script src="{{ asset('js/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('js/iziToast.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/highcharts.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/bootstrap-multiselect.js') }}"></script>
<script src="{{ asset('js/pages/general.js') }}" type="text/javascript"></script>
<!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    jQuery(document).ready(function() {
        jQuery(".toggle_menuswp").click(function(){
            jQuery(".sec_mobile_menuTo").toggleClass("menushw_showmob");
        });
    });

    $(document).ready(function () {
        $('.dropdown-toggle').dropdown();
    });
    
    @if(Session::has('success'))
        commonScripts._toastSuccess("{{ Session::get('success') }}");;
    @endif
</script>
@yield('extra')
</html>