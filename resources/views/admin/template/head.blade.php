<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Zolotaya</title>

    <!-- Bootstrap Core CSS -->
    <link href="/admin/css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/admin/css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/admin/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">


    <!-- jQuery -->
    <script src="/admin/js/jquery.js"></script>

    <link href="/admin/plugins/summernote/summernote.css" rel="stylesheet">
    <script src="/admin/plugins/summernote/summernote.js"></script>


    <link href="/admin/plugins/bootstrap-fileinput/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
    <!-- the main fileinput plugin file -->
    <script src="/admin/plugins/bootstrap-fileinput/js/fileinput.min.js"></script>

    <link href="/admin/plugins/chosen/chosen.css" rel="stylesheet">
    <script src="/admin/plugins/chosen/chosen.jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" src="/admin/plugins/moment/min/moment.min.js"></script>
    <script type="text/javascript" src="/admin/plugins/moment/min/locales.min.js"></script>
    <script src="/admin/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/admin/plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet" href="/admin/plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css" />

    <link rel="stylesheet" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
    <script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>

    <script src="/admin/plugins/bootstrap-fileinput/js/locales/ru.js"></script>
    <script src="/admin/js/main.js"></script>
</head>

<body>

<div id="wrapper">
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/superuser/">Zolotaya</a>
        </div>
        @include('admin.template.sidebar')
    </nav>