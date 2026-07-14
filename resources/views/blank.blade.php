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
@section('title', 'Blank Page')

@section('content_page')

<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h1>Dashboard</h1> --}}
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('blank') }}">Dashboard</a></li>
                        {{-- <li class="breadcrumb-item active">Dash Board</li> --}}
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        {{-- <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            {{-- <h3 class="card-title">DashBoard</h3> --}}
                        </div>
                        <div class="card-body">
                            {{-- Start Coding Here --}}
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}
    </section>
</div>
@endsection

@section('js_content')
    <script type="text/javascript">

        $(document).ready(function () {
            bsCustomFileInput.init();
        });

    </script>
@endsection