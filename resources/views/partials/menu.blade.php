<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="/dist/img/smartosc-logo.png" alt="SmartOSC Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">SmartOSC</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{$store["logo"]}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{$store["name"]}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item has-treeview menu-open">
                    <a href="#" class="nav-link active">
                        <i class="nav-icon fas fas fa-search"></i>
                        <p>
                            Advanced search
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a  href="/" class="nav-link" >
{{--                        <i class="nav-icon fas fa-sync"></i>--}}
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Home
                        </p>
                    </a>
                </li>
                <li class="nav-item" id="synLink">
                    <a  href="#" class="nav-link" >
                        <i class="nav-icon fas fa-sync"></i>
                        <p>
                            Synchronize
                            <span class="right badge badge-danger">For fist time</span>
                        </p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="/report" class="nav-link">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Report</p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-file-export"></i>
                        <p>
                            Export
                            <i class="fas fa-angle-left right"></i>
                            <span class="badge badge-info right">2</span>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/ExportKeywordDetail" class="nav-link">
                                <i class="fas fa-arrow-circle-down nav-icon"></i>
                                <p>Keyword search detail</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/ExportKeywordCount" class="nav-link">
                                <i class="fas fa-arrow-circle-down nav-icon"></i>
                                <p>Keyword search count</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item has-treeview">
                    <a href="/config" class="nav-link">
                        <i class="nav-icon fas fa-cog" aria-hidden="true"></i>
                        <p>Configuration</p>
                    </a>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class=" nav-icon fa fa-user" aria-hidden="true"></i>
                        <p>About us</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
<script type="text/javascript">
    $(document).ready(function(e) {

       $("#synLink").click(function () {
           alert("Waiting for few second");
           synAjax();
       })
    });
    function synAjax()
    {
        $.ajax({
            url: "/backup",
            type: "GET",
            success: function f(result){
                alert("Your data is backing up");
            }
        })
    }

</script>
