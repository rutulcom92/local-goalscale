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
     <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
     <link href="{{ asset('css/iziToast.css') }}" rel="stylesheet">
     <link href="{{ asset('emoji-icons-lib/css/emoji.css') }}" rel="stylesheet">
     <script type="text/javascript">
        var base_url = "{{ url('/') }}";
    </script>
</head>
<body>
    <div class="loader">
        <span class="dashboard-spinner spinner-md"></span>
    </div>
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
<script src="{{ asset('js/responsive.bootstrap4.min.js') }}" defer></script>
<script src="{{ asset('js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/jquery.inputmask.bundle.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<script type="text/javascript" src="{{ asset('js/iziToast.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/highcharts.js')}}"></script>
<script type="text/javascript" src="{{ asset('emoji-icons-lib/js/config.js')}}"></script>
<script type="text/javascript" src="{{ asset('emoji-icons-lib/js/util.js')}}"></script>
<script type="text/javascript" src="{{ asset('emoji-icons-lib/js/jquery.emojiarea.js')}}"></script>
<script type="text/javascript" src="{{ asset('emoji-icons-lib/js/emoji-picker.js')}}"></script>
<script type="text/javascript" src="{{ asset('js/sweetalert.min.js') }}"></script>
<script src="{{ asset('js/pages/general.js') }}" type="text/javascript"></script>
<!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
<script type="text/javascript">
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
</script>
    <script>
      $(function() {
        // Initializes and creates emoji set from sprite sheet
        window.emojiPicker = new EmojiPicker({
          emojiable_selector: '[data-emojiable=true]',
          assetsPath: "{{ asset('emoji-icons-lib/img/') }}",
          popupButtonClasses: 'open-emoji'
        });
        // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
        // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
        // It can be called as many times as necessary; previously converted input fields will not be converted again
        window.emojiPicker.discover();

        $('body').on('click','.open-emoji',function(){
            $('.emoji-menu').toggle('show');
        })
      });
    </script>
@yield('extra')
</html>