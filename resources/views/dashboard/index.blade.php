@extends('layouts.app') @section('title','WMU | Dashboard') @section('content')
<div class="Wrap_all_class">
    <div class="Wrap_all_class_inner">
        <div class="dashboard_cls_UI_main full_width">
            <div class="row">
                <div class="col-sm-6">
                    @if(Auth::user()->user_type_id == 1)
                    <a class="edxdit_opt add-edit-welcomecontent" data-url="{{route('dashboard.welcome-to-goal.create')}}"><img src="{{ asset('images/icon-edit.svg') }}" /></a>
                    @endif
                    <div class="full_width box_WMUUI marg40">
                        <h1 class="welcome-heading-content">{{(!empty(getSiteConfig('welcome_heading')) ? getSiteConfig('welcome_heading') : 'Welcome to Goal Attainment Scaling!')}}</h1>
                        @if(!empty(getSiteConfig('welcome_to_goal_attainment_scaling')))
                        <p class="welcome-content">{{getSiteConfig('welcome_to_goal_attainment_scaling')}}</p>
                        @else
                        <p class="welcome-content">
                            GAS is a method of measuring goal attainment over time, using a five-point scale to capture all possible outcomes for a given goal. GAS is a unique approach to goal setting, one that promotes success along a
                            continuum rather than the traditional all-or-nothing success vs. failure model. It has been used in healthcare and educational settings since 1968. Numerous studies have found GAS to be highly sensitive to
                            change, unlike other measures that use a generic and broad evaluation, not specific to the needs of each individual. The ability to capture small but meaningful change over time makes it a preferred outcome
                            measure among clinicians, researchers, teachers, and caregivers.
                        </p>
                        @endif
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="full_width box_WMUUI h390 box_WMUUI_innerT">
                        {{ Form::open(array('route'=>'dashboard.contactus','id'=>'contactus')) }}
                        <div class="row">
                            <div class="col-sm-8">
                                <h1>Contact Technical Support</h1>
                            </div>
                            <div class="col-sm-4">
                                <div class="top_bar_info_bar">
                                    <ul>
                                        <li>
                                            <a><img src="{{ asset('images/icon-email.svg') }}" /><span>{{config('constants.CONTACT_US_EMAIL')}}</span></a>
                                        </li>
                                        <li>
                                            <a href="tel:{{config('constants.CONTACT_US_PHONE')}}"><img src="{{ asset('images/icon-phone.svg') }}" /><span>{{config('constants.CONTACT_US_PHONE')}}</span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="full_width form_field_cls mrtop18">
                                    <div class="form-group">
                                        {{ Form::textarea('contactus[messages]', null, array('class' => 'area_dash', 'placeholder' => 'To send a message for support on a technical issue or error, or to share an idea to improve this app, type here...'))}}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="full_width">
                                    <input type="submit" class="btn-cls min-wdth text-center float-right" value="Send" />
                                </div>
                            </div>
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
                <div class="col-sm-6 mrbtd">
                    @if(Auth::user()->user_type_id == 1)
                    <a class="edxdit_opt add-edit-aboutcontent" data-url="{{route('dashboard.about-us.create')}}"><img src="{{ asset('images/icon-edit.svg') }}" /></a>
                    @endif
                    <div class="full_width box_WMUUI h390">
                        <h1 class="aboutus-heading-content">{{(!empty(getSiteConfig('about_us_heading')) ? getSiteConfig('about_us_heading') : 'About Us')}}</h1>
                        <div class="full_width">
                            <div class="row">
                                <div class="col-sm-7">
                                    @if(!empty(getSiteConfig('about_us_content')))
                                    <p class="aboutus-content">{{getSiteConfig('about_us_content')}}</p>
                                    @else
                                    <p>
                                        GAS is a method of measuring goal attainment over time, using a five-point scale to capture all possible outcomes for a given goal. GAS is a unique approach to goal setting, one that promotes success
                                        along a continuum rather than the traditional all-or-nothing success vs. failure model. It has been used in healthcare and educational settings since 1968. Numerous studies have found GAS to be highly
                                        sensitive to change, unlike other measures that use a generic and broad evaluation, not specific to the needs of each individual. The ability to capture small but meaningful change over time makes it
                                        a preferred outcome measure among clinicians, researchers, teachers, and caregivers.
                                    </p>
                                    @endif
                                </div>
                                <div class="col-sm-5">
                                    <div class="for_about_feature">
                                        <img
                                            class="about_us_image"
                                            src="{{(!empty(getSiteConfig('about_us_image')) ? url(Storage::url(config('constants.about_us_image_storage_path').getSiteConfig('about_us_image'))) : asset('images/2.jpg'))}}"
                                        />
                                        <h6 class="aboutus-image-content">{{(!empty(getSiteConfig('about_us_image_content')) ? getSiteConfig('about_us_image_content') : 'Ann Chapleau & Jennifer Harrison')}}</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection @section('extra')
<script src="{{ asset('js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.inputmask.bundle.js') }}" type="text/javascript"></script>

<script type="text/javascript">
    jQuery(".box_WMUUI p").mCustomScrollbar();
</script>
<script src="{{ asset('js/pages/dashboard/index.js') }}" type="text/javascript"></script>
@endsection
