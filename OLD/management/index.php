<?
include ("Classes/db.inc");
include("Classes/cPanel_Class.php");
/*
$vars = get_defined_vars();
echo "<pre>";
print_r($vars);
echo "</pre>";*/
?>
<!DOCTYPE html>
<html>
    <head>
	<style>
		.pointer{cursor:pointer;}
	</style>
        <meta charset="UTF-8">
        <title>FCFS Dashboard</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<script src="bootstrap/AdminLTE-2.3.3/plugins/jQuery/jQuery-2.2.0.min.js"></script>
		   <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
        <link href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.0/css/font-awesome.min.css"> 
        <link href="http://code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="bootstrap/AdminLTE-2.3.3/dist/css/_AdminLTE.css" rel="stylesheet" type="text/css" />
		<link href="bootstrap/AdminLTE-2.3.3/dist/css/skins/skin-red-light.css"  rel="stylesheet" type="text/css" />
		
		<script src="bootstrap/AdminLTE-2.3.3/plugins/datatables/jquery.dataTables.min.js"></script>
		
       <script src="bootstrap/AdminLTE-2.3.3/plugins/datatables/dataTables.bootstrap.min.js"></script>
        <script type="text/javascript" src='js/js.js' /></script>
		<script src="js/dropzone.js"></script>
		<link href="js/dropzone.css" type="text/css" rel="stylesheet" /> 
	<script src="../scripts/ckeditor/ckeditor.js"></script>
	
	
 
    <script src="http://code.jquery.com/ui/1.11.1/jquery-ui.min.js" type="text/javascript"></script>
    <!-- Morris.js charts -->
    <script src="http://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
    <script src="js/plugins/morris/morris.min.js" type="text/javascript"></script>
    <!-- Sparkline -->
    <script src="js/plugins/sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
    <!-- jvectormap -->
    <script src="js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js" type="text/javascript"></script>
    <script src="js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js" type="text/javascript"></script>
    <!-- jQuery Knob Chart -->
    <script src="js/plugins/jqueryKnob/jquery.knob.js" type="text/javascript"></script>
    <!-- daterangepicker -->
    <script src="js/plugins/daterangepicker/daterangepicker.js" type="text/javascript"></script>
    <!-- datepicker -->
  
	<script src="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.0.0/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>  
	<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.min.css" type="text/css" />
    <script src="js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="js/plugins/iCheck/icheck.min.js" type="text/javascript"></script>

    <!-- AdminLTE App -->
    <script src="bootstrap/AdminLTE-2.3.3/dist/js/app.js" type="text/javascript"></script>



    <script src="js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js" type="text/javascript"></script>
    
     <!-- DATA TABES SCRIPT -->
    <script src="js/plugins/datatables/jquery.dataTables.js" type="text/javascript"></script>
    <script src="js/plugins/datatables/dataTables.bootstrap.js" type="text/javascript"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
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
      <!-- Navbar Right Menu -->
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu" style='display:none;'>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-envelope-o"></i>
              <span class="label label-success">4</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 4 messages</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- start message -->
                    <a href="#">
                      <div class="pull-left">
                        <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <!-- end message -->
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        AdminLTE Design Team
                        <small><i class="fa fa-clock-o"></i> 2 hours</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Developers
                        <small><i class="fa fa-clock-o"></i> Today</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="dist/img/user3-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Sales Department
                        <small><i class="fa fa-clock-o"></i> Yesterday</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <div class="pull-left">
                        <img src="dist/img/user4-128x128.jpg" class="img-circle" alt="User Image">
                      </div>
                      <h4>
                        Reviewers
                        <small><i class="fa fa-clock-o"></i> 2 days</small>
                      </h4>
                      <p>Why not buy a new awesome theme?</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">See All Messages</a></li>
            </ul>
          </li>
          <!-- Notifications: style can be found in dropdown.less -->
          <li class="dropdown notifications-menu" style='display:none;'>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">10</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 10 notifications</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-aqua"></i> 5 new members joined today
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                      page and may cause design problems
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-users text-red"></i> 5 new members joined
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                    </a>
                  </li>
                  <li>
                    <a href="#">
                      <i class="fa fa-user text-red"></i> You changed your username
                    </a>
                  </li>
                </ul>
              </li>
              <li class="footer"><a href="#">View all</a></li>
            </ul>
          </li>
          <!-- Tasks: style can be found in dropdown.less -->
          <li class="dropdown tasks-menu" style='display:none;'>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-flag-o"></i>
              <span class="label label-danger">9</span>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 9 tasks</li>
              <li>
                <!-- inner menu: contains the actual data -->
                <ul class="menu">
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Design some buttons
                        <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Create a nice theme
                        <small class="pull-right">40%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">40% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Some task I need to do
                        <small class="pull-right">60%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">60% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                    <a href="#">
                      <h3>
                        Make beautiful transitions
                        <small class="pull-right">80%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">80% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                </ul>
              </li>
              <li class="footer">
                <a href="#">View all tasks</a>
              </li>
            </ul>
          </li>
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">
								<i class="glyphicon glyphicon-user"></i>
								<span><? echo $_COOKIE['userName']; ?><i class="caret"></i>&nbsp;</span>
							</a>
							<ul class="dropdown-menu">
								<li class="user-header bg-light-blue">
									<img src="img/avatar3.png" class="img-circle" alt="User Image" />
									<p>
										<? echo $_COOKIE['userName']; ?> - <? echo $_COOKIE['userRole']; ?>
                                    </p>
								</li>
								<li class="user-footer">
									<div class="pull-left">
										<a href="#" class="btn btn-default btn-flat" style='display: none;'>Profile</a>
									</div>
									<div class="pull-right">
										<a href="../logout.php" class="btn btn-default btn-flat" >Sign out</a>
									</div>
								</li>
							</ul>
						</li>
          <!-- Control Sidebar Toggle Button -->
          <li style='display:none;'>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>

    </nav>
	
		</header>
        <aside class="left-side sidebar-offcanvas">
            <section class="sidebar">
				<ul class="sidebar-menu">
					
                        <?
                        $idUser = $_COOKIE['userId'];
                        $cPanel = new cPanel;
                        $data = $cPanel->cPanelGetSectionsByUser($idUser);

                        foreach ($data as $cp) {
                            echo "\n\t\t\t<li class=\"treeview\">";
                            if (empty($cp[2])) {
                                $action = "";
                            } else {
                                $action = "onClick='" . $cp[2] . "()'";
                            }
                            echo "\n\t\t\t\t<a href=\"#\" $action><i class=\"" . $cp[3] . "\"></i> " . utf8_encode($cp[1]) . "";
                            $data2 = $cPanel->cPanelGetSubSectionsByUser($idUser, $cp[0]);


                            if (is_array($data2)) {
                                echo "\n\t\t\t\t <i class=\"fa fa-angle-left pull-right\"></i></a><ul class='nav nav-second-level treeview-menu'>";
                                foreach ($data2 as $cp2) {
                                    echo "\n\t\t\t\t\t<li><a href='#' onClick='" . $cp2[2] . "()'><i class=\"fa fa-angle-double-right\"></i> " . utf8_encode($cp2[1]) . "</a></li>";
                                }
                                echo "\n\t\t\t\t</ul>";
                            } else {
                                echo "</a>";
                            }
                            echo "\n\t\t\t</li>";
                        }
                        ?>

                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

      
        <aside class="right-side" id="page-container">
           
        </aside>
    </div><!-- ./wrapper -->

    <!-- add new calendar event modal -->


   




</body>
</html>
<script>
    Dropzone.autoDiscover = false;

    Dropzone.options.myId = {
        maxFilesize: 100,
        init: function() {
            //this.on("drop", function(file) { alert("Dropped file."); });
            //this.on("success", function(file) { fillImageContainer(); });
        }
    };
	
	
    Dropzone.options.myId.addRemoveLinks= true;

    Dropzone.options.myId.dictDefaultMessage="<span style='font-size:26px; color:#2a6496;'>\n\<i style='font-size:28px;' class=\"fa fa-cloud-upload fa-fw\"></i> Insertar arxiu per a pujar.";


	
</script>


