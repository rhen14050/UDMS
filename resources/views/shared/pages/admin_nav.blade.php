
<aside class="main-sidebar sidebar-dark-primary elevation-4" style="height: 100vh">

    <!-- System title and logo -->
    <a href="{{ route('blank') }}" class="brand-link">
        <img src="{{ asset('public/images/pricon_logo2.png') }}"
            alt="OITL"
            class="brand-image img-circle elevation-3"
            style="opacity: .8">

        <span class="brand-text font-weight-light font-size"><h5>UDMS</h5></span>
    </a> <!-- System title and logo -->

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item has-treeview">
                    {{-- <a href="{{ route('blank') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a> --}}
                </li>

                <li class="nav-header font-weight-bold">Administrator Management</li>
                <li class="nav-item has-treeview">
                    <a href="" data-toggle="modal" data-target="#modalOnGoing" class="nav-link">
                        <i class="nav-icon fas fa-file-medical"></i>
                        <p>First Module</p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="" data-toggle="modal" data-target="#modalOnGoing" class="nav-link">
                        <i class="nav-icon fas fa-file-medical"></i>
                        <p>Second Module</p>
                    </a>
                </li>

                <li class="nav-item has-treeview fixed-bottom">
                    <a href="{{ url('../RapidX') }}" class="nav-link">
                        <i class="nav-icon fas fa-arrow-left"></i>
                        <p>Return to RapidX</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div><!-- Sidebar -->
</aside>
