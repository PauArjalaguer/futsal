<!DOCTYPE html>
<html>
    <head>
        <style>
            .pointer{cursor:pointer;}
        </style>
        <meta charset="UTF-8">
        <title>FCFS</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <script src="https://www.futsal.cat/bootstrap/AdminLTE-2.3.3/plugins/jQuery/jQuery-2.2.0.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css"> 
        <link href="https://code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="https://www.futsal.cat/bootstrap/AdminLTE-2.3.3/dist/css/_AdminLTE.css" rel="stylesheet" type="text/css" />
        <link href="https://www.futsal.cat/bootstrap/AdminLTE-2.3.3/dist/css/skins/skin-red-light.css"  rel="stylesheet" type="text/css" />
        <script src="https://www.futsal.cat/bootstrap/AdminLTE-2.3.3/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="https://www.futsal.cat/bootstrap/AdminLTE-2.3.3/plugins/datatables/dataTables.bootstrap.min.js"></script>
        <script type="text/javascript" src='<?php echo base_url(); ?>js/app.js' ></script>
        <script src="https://www.futsal.cat/js/dropzone.js"></script>
        <link href="https://www.futsal.cat/js/dropzone.css" type="text/css" rel="stylesheet" /> 
        <script src="https://www.futsal.cat/scripts/wysiwyg-editor-master/js/froala_editor.min.js"></script>
        <script type="text/javascript" src="https://www.futsal.cat/scripts/wysiwyg-editor-master/js/froala_editor.pkgd.min.js" ></script>
        <link rel="stylesheet" href="https://www.futsal.cat/scripts/wysiwyg-editor-master/css/froala_editor.css">
        <link rel="stylesheet" href="https://www.futsal.cat/scripts/wysiwyg-editor-master/css/froala_style.css">
        <link rel="stylesheet" href="https://www.futsal.cat/scripts/wysiwyg-editor-master/css/plugins/code_view.css">
        <link rel="stylesheet" href="https://www.futsal.cat/scripts/wysiwyg-editor-master/css/plugins/draggable.css">
        <link rel="stylesheet" href="https://www.futsal.cat/scripts/wysiwyg-editor-master/css/plugins/colors.css">
        <link rel="stylesheet" href="https://www.futsal.cat/scripts/wysiwyg-editor-master/css/plugins/emoticons.css">
        <link rel="stylesheet" href="https://www.futsal.cat/scripts/wysiwyg-editor-master/css/plugins/image_manager.css">
        <link rel="stylesheet" href="https://www.futsal.cat/scripts/wysiwyg-editor-master/css/plugins/image.css">
        <link rel="stylesheet" href="https://www.futsal.cat/scripts/wysiwyg-editor-master/css/plugins/line_breaker.css">
        <link rel="stylesheet" href="https://www.futsal.cat/scripts/wysiwyg-editor-master/css/plugins/table.css">
        <link rel="stylesheet" href="https://www.futsal.cat/scripts/wysiwyg-editor-master/css/plugins/char_counter.css">
        <link rel="stylesheet" href="https://www.futsal.cat/scripts/wysiwyg-editor-master/css/plugins/video.css">
        <link rel="stylesheet" href="https://www.futsal.cat/scripts/wysiwyg-editor-master/css/plugins/fullscreen.css">
        <link rel="stylesheet" href="https://www.futsal.cat/scripts/wysiwyg-editor-master/css/plugins/file.css">
        <link rel="stylesheet" href="https://www.futsal.cat/scripts/wysiwyg-editor-master/css/plugins/quick_insert.css">
        <link rel="stylesheet" href="https://www.futsal.cat/scripts/wysiwyg-editor-master/css/plugins/help.css">
        <link rel="stylesheet" href="https://www.futsal.cat/scripts/wysiwyg-editor-master/css/third_party/spell_checker.css">
        <link rel="stylesheet" href="https://www.futsal.cat/scripts/wysiwyg-editor-master/css/plugins/special_characters.css">   
        <script src="https://code.jquery.com/ui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <!-- Morris.js charts -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="https://www.futsal.cat/js/plugins/morris/morris.min.js" type="text/javascript"></script>
        <!-- Sparkline -->
        <script src="https://www.futsal.cat/js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <!-- jvectormap -->
        <script src="https://www.futsal.cat/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
        <script src="https://www.futsal.cat/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
        <!-- jQuery Knob Chart -->
        <script src="https://www.futsal.cat/js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
        <!-- daterangepicker -->
        <script src="https://www.futsal.cat/js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
        <!-- datepicker -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.0.0/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>  
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" type="text/css" />
        <script src="https://www.futsal.cat/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <!-- iCheck -->
        <script src="https://www.futsal.cat/js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>
        <!-- AdminLTE App -->
        <script src="https://www.futsal.cat/bootstrap/AdminLTE-2.3.3/dist/js/app.js" type="text/javascript"></script>
        <script src="https://www.futsal.cat/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
        <!-- DATA TABES SCRIPT -->
        <script src="https://www.futsal.cat/js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
        <script src="https://www.futsal.cat/js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <link href="<?php echo base_url(); ?>css/admin_app.css?t=<?php echo time(); ?>"  rel="stylesheet"/>
        <script src="https://adminlte.io/themes/AdminLTE/bower_components/select2/dist/js/select2.full.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/select2.min.css">

    </head>
    <body class="skin-red-light">
        <div class="wrapper"> 
            <header class="main-header">
                <!-- Logo -->
                <a href="index.php" class="logo">
                    <span class="logo-mini"><b>F</b>S</span>
                    <span class="logo-lg">FC<b>FS</b></span>
                </a>
                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>