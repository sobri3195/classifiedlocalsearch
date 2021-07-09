<div id="helpModal" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4 class="modal-title">Modal title</h4>
          </div>
          <div class="modal-body">
            <p>
              Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor
              in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            </p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal --><!-- /#helpModal -->
    
      <div id="top">

        <!-- .navbar -->
        <nav class="navbar navbar-inverse navbar-static-top">

          <!-- Brand and toggle get grouped for better mobile display -->
          <header class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
              <span class="sr-only">Toggle navigation</span> 
              <span class="icon-bar"></span> 
              <span class="icon-bar"></span> 
              <span class="icon-bar"></span> 
            </button>
            <a href="index.php" class="navbar-brand">
              <img src="assets/img/logo.png" alt="">
            </a> 
          </header>
          <div class="topnav">
            <div class="btn-toolbar">
              <div class="btn-group">
                <a data-placement="bottom" data-original-title="Fullscreen" data-toggle="tooltip" class="btn btn-default btn-sm" id="toggleFullScreen">
                  <i class="glyphicon glyphicon-fullscreen"></i>
                </a> 
              </div>
              <div class="btn-group">
                <a data-placement="bottom" data-original-title="Show / Hide Sidebar" data-toggle="tooltip" class="btn btn-success btn-sm" id="changeSidebarPos">
                  <i class="fa fa-expand"></i>
                </a> 
              </div>
              
              <div class="btn-group">
         
                <a data-toggle="modal" data-original-title="Help" data-placement="bottom" class="btn btn-default btn-sm" href="#helpModal">
                  <i class="fa fa-question"></i>
                </a> 
              </div>
              <div class="btn-group">
                <a href="<?=common::get_component_link(array("home","logout")); ?>" data-toggle="tooltip" data-original-title="Logout" data-placement="bottom" class="btn btn-metis-1 btn-sm">
                  <i class="fa fa-power-off"></i>
                </a> 
              </div>
            </div>
          </div><!-- /.topnav -->
          <div class="collapse navbar-collapse navbar-ex1-collapse">

            <!-- .nav -->
            <ul class="nav navbar-nav">
              <li class="active">
                <a href="index.php">Dashboard</a> 
              </li>
              <li> <a href="#"></a>  </li>
              <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Users<b class="caret"></b></a> 
                <ul class="dropdown-menu">
                    <li><a href="<?=common::get_component_link(array("admin","add")); ?>">Add User</a></li>
                    <li><a href="<?=common::get_component_link(array("admin","list")); ?>">List Users</a></li>
                </ul>  
              </li>
              <li class='dropdown '>
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  Orders
                  <b class="caret"></b>
                </a> 
                <ul class="dropdown-menu">
                    <li> <a href="<?=common::get_component_link(array("order","list")); ?>&filter=today">Todays Order</a></li>    
                    <li> <a href="<?=common::get_component_link(array("order","list")); ?>&filter=all">All</a></li>
                  <li> <a href="<?=common::get_component_link(array("order","list")); ?>&filter=pending">Pending Orders</a>  </li>
                  <li> <a href="<?=common::get_component_link(array("order","list")); ?>&filter=complete">Complete Orders</a>  </li>
                </ul>
              </li>
            </ul><!-- /.nav -->
          </div>
        </nav><!-- /.navbar -->

        <!-- header.head -->
        <header class="head">
         

          <!-- ."main-bar -->
          <div class="main-bar">
            <h3>
              <i class="fa fa-dashboard"></i>Dashboard</h3>
          </div><!-- /.main-bar -->
        </header>

        <!-- end header.head -->
      </div><!-- /#top -->