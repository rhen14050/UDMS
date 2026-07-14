@php $layout = 'layouts.super_user_layout'; @endphp

@auth
    @php
        if(Auth::user()->user_level_id == 1){
            $layout = 'layouts.super_user_layout';
        }
        else if(Auth::user()->user_level_id == 2){
            $layout = 'layouts.admin_layout';
        }
        else if(Auth::user()->user_level_id == 3){
            $layout = 'layouts.user_layout';
        }
    @endphp
@endauth

{{-- Here I removed the @auth because the dashboard isn't loading properly --}}
@extends($layout)
@section('title', 'Dashboard')

@section('content_page')
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-xl-4 col-lg-4 mt-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fas fa-tachometer-alt"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Reports</span>
                                <span class="info-box-number">3,773</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 mt-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-success"><i class="fa fa-file"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Claim</span>
                                <span class="info-box-number">233</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 mt-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="fa fa-user"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total CAPA</span>
                                <span class="info-box-number">9,139</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 mt-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-black"><i class="fa fa-users"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Users</span>
                                <span class="info-box-number">9,132</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 mt-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger"><i class="fa fa-star"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Pending</span>
                                <span class="info-box-number">139</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-4 col-lg-4 mt-4">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="fa fa-star"></i></span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Records</span>
                                <span class="info-box-number">93,139</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

<!--     {{-- JS CONTENT --}} -->
@section('js_content')
    <script type="text/javascript">
        // $(document).ready(function () {
            //============================== GET TOTAL WORKLOADS FOR DASHBOARD ==============================
            // function totalWorkloads(){
            //     $.ajax({
            //         url: "get_total_workloads",
            //         method: "get",
            //         dataType: "json",
            //         success: function (response) {
            //             $('.totalWorkloads').text(response['totalWorkloads']);
            //             console.log(response['totalWorkloads']);
            //         }
            //     });
            // }
            // totalWorkloads();


            // //============================== GET TOTAL USERS FOR DASHBOARD ==============================
            // function totalUsers(){
            //     $.ajax({
            //         url: "get_total_users",
            //         method: "get",
            //         dataType: "json",
            //         success: function (response) {
            //             $('.totalUsers').text(response['totalUsers']);
            //             console.log(response['totalUsers']);
            //         }
            //     });
            // }
            // totalUsers();


            // //============================== SIGN OUT ==============================
            // $(document).ready(function(){
            //     $("#formSignOut").submit(function(event){
            //         event.preventDefault();
            //         SignOut();
            //     });
            // });
        // });
    </script>
@endsection
