@include('admin.template.head')

<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    @yield('pageName', 'Master') <small>@yield('pageSubName', '')</small>
                </h1>
                <div class="row">
                    @yield('content')
                </div>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

@include('admin.template.footer')