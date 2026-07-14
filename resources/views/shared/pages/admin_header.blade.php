<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="" class="nav-link">UDMS</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-user"></i>
                @php
                    echo $_SESSION["rapidx_name"];
                @endphp
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="dropdown-divider"></div>
                <span href="#" class="dropdown-item" id="aLogout" data-toggle="modal" data-target="#modalLogout">
                    <i class="fas fa-user mr-2"></i>Logout
                </span>
            </div>
        </li>
    </ul>
</nav>

<div class="modal fade" id="modalLogout">
    <div class="modal-dialog">
        <div class="modal-content modal-sm">
            <div class="modal-header bg-dark">
                <h4 class="modal-title"><i class="fa fa-user"></i> Logout</h4>
                <button type="button" style="color: #fff" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formSignOut">
                @csrf
                <div class="modal-body">
                    <label id="lblSignOut" class="text-secondary mt-2">Are you sure to logout your account?</label>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="submit" id="btnSignOut" class="btn btn-dark"><i id="iBtnSignOutIcon" class="fa fa-check"></i> Yes</button>
                </div>
            </form>
        </div>
    </div>
</div>
