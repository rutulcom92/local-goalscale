<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="{{ asset('images/wmu_favicon.png') }}" type="image/png" sizes="32x32">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Welcome to WMU</title>

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
     <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
     <link href="{{ asset('css/iziToast.css') }}" rel="stylesheet">
     <link href="{{ asset('emoji-icons-lib/css/emoji.css') }}" rel="stylesheet">
     <script type="text/javascript">
        var base_url = "{{ url('/') }}";
    </script>
</head>
<body>
<style>
body {
    color: #2E2F30;
    overflow-x: hidden;
    height: 100%;
    background-color: #fff;
    background-repeat: no-repeat
}

.card0 {
    /* box-shadow: 0px 4px 8px 0px #757575; */
    border-radius: 0px
}

.card2 {
    /* margin: 0px 40px */
}

.logo {
    width: 80px;
    height: 80px;
    margin-top: 20px;
    margin-left: 35px
}

.image {
    width: 360px;
    height: 280px
}

.border-line {
    border-right: 1px solid #EEEEEE
}

.line {
    height: 1px;
    width: 45%;
    background-color: #E0E0E0;
    margin-top: 10px
}

.or {
    width: 10%;
    font-weight: bold
}

.text-sm {
    font-size: 14px !important
}


button:focus {
    -moz-box-shadow: none !important;
    -webkit-box-shadow: none !important;
    box-shadow: none !important;
    outline-width: 0
}

a {
    color: inherit;
    cursor: pointer
}

.btn-yellow {
    background-color: #ffd72e;
    color: #fff;
}

.btn-yellow:hover {
    background-color: #ffeb67;
    color: #fff;
    cursor: pointer
}

.bg-yellow {
    color: #000;
    background-color: #fee7ae
}

.box_WMUUI {
    box-shadow: none !important;
    height:auto;
}

.card2 .box_WMUUI {
    margin-top: 6.3rem;
}

.card1 .box_WMUUI p {
    height: auto;
}

.fixed-bottomx {
    position: fixed;
    right: 0;
    left: 0;
    z-index: 1030;
    bottom: 0;
}

@media only screen and (max-width: 1279px) {
    .fixed-bottomx {
        position: auto;
        right: 0;
        left: 0;
        z-index: 1030;
    }

    .card2 .box_WMUUI {
        margin-top: 0px;
    }
}

@media screen and (max-width: 991px) {
    .logo {
        margin-top: 0px;
        margin-left: 0px
    }
    .logo_divn {
        float: left;
        width: 100%;
        text-align: center;
        /* margin-bottom: 50px; */
    }

    .aboutus-heading-content, .welcome-heading-content {
        text-align: center;
    }

    .card2 .box_WMUUI {
        margin-top: 0px;
    }

    .image {
        width: 300px;
        height: 220px
    }

    .border-line {
        border-right: none
    }

    .card2 {
        border-top: 1px solid #EEEEEE !important;
        margin: 0px 15px
    }
}
</style>
<div class="Wrap_all_class--">
    <div class="Wrap_all_class_inner">
        <div class="dashboard_cls_UI_main full_width">
            <div class="row">

                <div class="col-sm-6">
                    <div class="card1 card border-0">
                        <div class="logo_divn">
                            <a href="{{ url('/') }}">
                                <img id="web-logo-image" class="logo" src="{{ asset('images/gss-logo-big.png') }}">
                            </a>
                        </div>
                        <div class="row px-3 border-line">
                            <div class="full_width box_WMUUI">
                                <h1 class="welcome-heading-content">{{(!empty(getSiteConfig('welcome_heading')) ? getSiteConfig('welcome_heading') : 'Welcome to Goal Attainment Scaling!')}}</h1>
                                @if(!empty(getSiteConfig('welcome_to_goal_attainment_scaling')))
                                <p class="welcome-content text-justify">{{getSiteConfig('welcome_to_goal_attainment_scaling')}}</p>
                                @else
                                <p class="welcome-content text-justify">
                                    GAS is a method of measuring goal attainment over time, using a five-point scale to capture all possible outcomes for a given goal. GAS is a unique approach to goal setting, one that promotes success along a
                                    continuum rather than the traditional all-or-nothing success vs. failure model. It has been used in healthcare and educational settings since 1968. Numerous studies have found GAS to be highly sensitive to
                                    change, unlike other measures that use a generic and broad evaluation, not specific to the needs of each individual. The ability to capture small but meaningful change over time makes it a preferred outcome
                                    measure among clinicians, researchers, teachers, and caregivers.
                                </p>
                                @endif

                                <p class="text-center">
                                    <a href="{{route('login')}}" class="btn_cool text-center">Proceed to Login</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="card2 mb-5">
                        <div class="row justify-content-center">
                            <div class="full_width box_WMUUI h390">
                                <h1 class="aboutus-heading-content">{{(!empty(getSiteConfig('about_us_heading')) ? getSiteConfig('about_us_heading') : 'About Us')}}</h1>
                                <div class="full_width">
                                    <div class="row">
                                        <div class="col-md-7 col-sm-4">
                                            @if(!empty(getSiteConfig('about_us_content')))
                                            <p class="aboutus-content text-justify">{{getSiteConfig('about_us_content')}}</p>
                                            @else
                                            <p class="text-justify">
                                                GAS is a method of measuring goal attainment over time, using a five-point scale to capture all possible outcomes for a given goal. GAS is a unique approach to goal setting, one that promotes success
                                                along a continuum rather than the traditional all-or-nothing success vs. failure model. It has been used in healthcare and educational settings since 1968. Numerous studies have found GAS to be highly
                                                sensitive to change, unlike other measures that use a generic and broad evaluation, not specific to the needs of each individual. The ability to capture small but meaningful change over time makes it
                                                a preferred outcome measure among clinicians, researchers, teachers, and caregivers.
                                            </p>
                                            @endif
                                        </div>
                                        <div class="col-md-5 col-sm-2">
                                            <div class="for_about_feature">
                                                <img
                                                    class="about_us_image"
                                                    src="{{(!empty(getSiteConfig('about_us_image')) ? url(Storage::url(config('constants.about_us_image_storage_path').getSiteConfig('about_us_image'))) : asset('images/2.jpg'))}}"
                                                />
                                                <h6 class="aboutus-image-content">{{(!empty(getSiteConfig('about_us_image_content')) ? getSiteConfig('about_us_image_content') : 'Ann Chapleau & Jennifer Harrison')}}</h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                    <p class="text-center">
                                        <a href="javascript:showContactForm();" class="btn_cool text-center">Contact Us</a>
                                    </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="fixed-bottomx bg-yellow py-2">
                <div class="text-center">
                    <h6 class="">Goal Scaling Solutions</h6>
                    <small class="">Copyright &copy; <?php echo date('Y')?>. All rights reserved.</small>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- The Modal -->


<div class="modal fade" id="contact_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
	aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header text-center">
				<h4 class="modal-title w-100 font-weight-bold">Drop Us a Message</h4>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body mx-3">
                {{ Form::open(array('route'=>'contactus','id'=>'contactus')) }}
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="text" name="contactus[name]" class="form-control" placeholder="Your Name *" value="" />
                            </div>
                            <div class="form-group">
                                <input type="text" name="contactus[email]" class="form-control" placeholder="Your Email *" value="" />
                            </div>
                            <div class="form-group">
                                <input type="text" name="contactus[phone]" class="form-control mobile-input-mask" placeholder="Your Phone Number *" value="" />
                            </div>
                        <!-- </div> -->
                        <!-- <div class="col-md-6"> -->
                            <div class="form-group">
                                <textarea name="contactus[message]" class="form-control" placeholder="Your Message *" style="width: 100%; height: 150px;"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" name="btnSubmit" class="btn_cool mt-1">Send <i class="fas fa-paper-plane-o ml-1"></i></button>
                    </div>
                {{ Form::close() }}
			</div>

		</div>
	</div>
</div>

</body>
<script src="{{ asset('js/jquery-3.4.1.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.inputmask.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.mCustomScrollbar.js') }}" type="text/javascript"></script>
<!-- <script src="{{ asset('js/pages/general.js') }}" type="text/javascript"></script> -->
<script type="text/javascript" src="{{ asset('js/iziToast.js') }}"></script>
<script src="{{ asset('js/pages/landing.js') }}" type="text/javascript"></script>
<script type="text/javascript">
    //jQuery(".box_WMUUI p").mCustomScrollbar();
</script>
</html>
