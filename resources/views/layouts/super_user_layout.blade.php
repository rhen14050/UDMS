@php
    session_start();
    $isLogin = false;
    if(isset($_SESSION['rapidx_user_id'])){
        $isLogin = true;
    }

    $isAuthorized = false;
    $user_level = 0;
@endphp

@if($isLogin)
    <!--
        *These are the sessions in RapidX System(for reference only)

        $_SESSION["rapidx_user_id"] = Auth::user()->id;
        $_SESSION["rapidx_user_level_id"] = Auth::user()->user_level_id;
        $_SESSION["rapidx_username"] = Auth::user()->username;
        $_SESSION["rapidx_name"] = Auth::user()->name;
        $_SESSION["rapidx_department_id"] = Auth::user()->department_id;

        $user_accesses = UserAccess::on('mysql')->where('user_id', Auth::user()->id)
                        ->where('user_access_stat', 1)
                        ->get();

        $arr_user_accesses = [];
        for($index = 0; $index < count($user_accesses); $index++) {
            // $arr_user_accesses['module_id'] = $user_accesses[$index]->module_id;
            // $arr_user_accesses['user_level_id'] = $user_accesses[$index]->user_level_id;
            array_push($arr_user_accesses, array(
                'module_id' => $user_accesses[$index]->module_id,
                'user_level_id' => $user_accesses[$index]->user_level_id
            ));
        }

        $_SESSION["rapidx_user_accesses"] = $arr_user_accesses;
    -->

    @if($_SESSION['rapidx_user_level_id'] == 5) <!-- 1-Super User, 2-Administrator, 3-User, 4-QAD Admin, 5-Other Section -->
        @if(count($_SESSION['rapidx_user_accesses']) > 0) <!-- Count the rapidx_user_accesses session based on RapidX session -->
            @for($index = 0; $index < count($_SESSION['rapidx_user_accesses']); $index++) <!-- Loop the rapidx_user_accesses session based on RapidX session -->
                <!--
                    You will see the module_id on the table inside modules(table) under db_rapidx(database) since Customer Claim Database System id is 11
                    you are free to change below module_id equals to your module_id
                -->
                @if($_SESSION['rapidx_user_accesses'][$index]['module_id'] == 11) <!-- 11-Customer Claim Database System Module -->
                    @php
                        $isAuthorized = true;
                        $user_level = $_SESSION['rapidx_user_accesses'][$index]['user_level_id']; // Collect the user_level_id
                    @endphp
                    @break
                @endif
            @endfor

            @if(!$isAuthorized)
                <script type="text/javascript">
                    window.location = '../RapidX/';
                </script>
            @endif
        @else
            <script type="text/javascript">
                window.location = '../RapidX/';
            </script>
        @endif
    @endif

    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <title>UDMS | @yield('title')</title>
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link rel="shortcut icon" type="image/png" href="{{ asset('public/images/favicon.ico') }}">

            <!-- CSS LINKS -->
            @include('shared.css_links.css_links')
            <style>
                .modal-xl-custom{
                    width: 95% !important;
                    min-width: 90% !important;
                }
            </style>
        </head>
        <body class="hold-transition sidebar-mini">
            <div class="modal" tabindex="-1" role="dialog" id="modalOnGoing">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-dark">
                            <h4 class="modal-title"><i class="fas fa-info-circle"></i>&nbsp;On-going Module</h4>
                            <button type="button" style="color: #fff;" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>This is an On-Going Feature</p>
                        </div>
                        <div class="modal-footer">

                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="wrapper">
                @include('shared.pages.admin_header')
                @include('shared.pages.super_user_nav')
                @yield('content_page')
                @include('shared.pages.admin_footer')
            </div>

            <!-- JS LINKS -->
            @include('shared.js_links.js_links')
            @yield('js_content')
        </body>
    </html>
@else
    <script type="text/javascript">
        window.location = "../RapidX/";
    </script>
@endif
