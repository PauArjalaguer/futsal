<?php //echo "<pre>";print_r(get_defined_vars()); echo "</pre>"; ?>
<!-- Navbar Right Menu -->
<div class="navbar-custom-menu">
    <ul class="nav navbar-nav">
        <!-- Messages: style can be found in dropdown.less-->
        <li class="dropdown messages-menu" style=''>
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-envelope-o"></i>
                <span class="label label-success"><?php echo count($get_mail_notread); ?></span>
            </a>
            <ul class="dropdown-menu">
                <li class="header">Tens <?php echo count($get_mail_notread); ?> missatges.</li>
                <?php
                $n=0;
                foreach ($get_mail_notread as $row):
                    $n++;
                    if ($n < 6) {
                        echo "<li>
                                    <!-- inner menu: contains the actual data -->
                                    <ul class=\"menu\">
                                        <li>
                                            <a href=\"#\">
                                                <div class=\"pull-left\">
                                                    <img src=\"http://v3.futsal.cat/webImages/clubsImages/" . $row->image . "\" class=\"img-circle\" alt=\"User Image\">
                                                </div>
                                                <h4>
                                                    " . $row->senderName . "
                                                    <small><i class=\"fa fa-clock-o\"></i> " . $row->days . " dies.</small>
                                                </h4>
                                                <p>" . substr($row->message, 0, 20) . "...</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>";
                    }
                endforeach;
                ?>       
                <li class="footer"><a href="#">Veure tots els missatges.</a></li>
            </ul>
        </li>
        <!-- Notifications: style can be found in dropdown.less -->
        <!-- <li class="dropdown notifications-menu" style=''>
             <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                 <i class="fa fa-bell-o"></i>
                 <span class="label label-warning">10</span>
             </a>
             <ul class="dropdown-menu">
                 <li class="header">You have 10 notifications</li>
                 <li>
                    
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
         </li> -->
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
                <span><? echo $name; ?> <i class="caret"></i>&nbsp;</span>
            </a>
            <ul class="dropdown-menu">

                <li class="user-footer">

                    <div class="pull-right">
                        <?php echo "<a href='" . base_url() . "admin/index/logout' "; ?> class="btn btn-default btn-flat" >Sortir</a>
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