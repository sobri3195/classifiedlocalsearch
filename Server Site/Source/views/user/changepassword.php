<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Start Bootstrap - SB Admin Version 2.0 Demo</title>

    <!-- Core CSS - Include with every page -->
    <link href="<?=ADMIN_THEME ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=ADMIN_THEME ?>font-awesome/css/font-awesome.css" rel="stylesheet">

    <!-- Page-Level Plugin CSS - Dashboard -->
    <link href="<?=ADMIN_THEME ?>css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
    <link href="<?=ADMIN_THEME ?>css/plugins/timeline/timeline.css" rel="stylesheet">

    <!-- SB Admin CSS - Include with every page -->
    <link href="<?=ADMIN_THEME ?>css/sb-admin.css" rel="stylesheet">
    <link href="<?=ADMIN_THEME ?>css/style.css" rel="stylesheet">
</head>

<body>

    <div id="wrapper">

        <? echo common::elements("adminnav"); ?>
        <div id="page-wrapper">
<div class="row">
<div class="col-lg-12">
<h1 class="page-header"><i class="fa fa-lock fa-fw"></i> Change Password</h1>
</div>
</div>
<div class="row">
    <div class="col-md-6">

<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-lock fa-fw"></i> Change Password
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
        <? if ( common::do_show_message() ) {
		          echo common::show_message();	
            } ?>
			<form id="form" action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                    
                    <div class="form-group">
                        <label for="text1" class="control-label col-lg-4">Current Password</label>
                        <div class="col-lg-8">
						<input class="form-control" name="password" type="password" />
					</div>
                    </div>
                    <div class="form-group">
                        <label for="text1" class="control-label col-lg-4">New Password</label>
                        <div class="col-lg-8">
						<input class="form-control" name="newpassword" type="password" />
					</div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-8">
						<input class="btn" type="submit" name="set" value="Change Password" />
					       </div>
                    </div>
                    </div>
            </form>
</div>
</div>


    

    
</div>

            
            
			</div>
                  </div>
    <!-- /#wrapper -->

    <!-- Core Scripts - Include with every page -->
    <script src="<?=ADMIN_THEME ?>js/jquery-1.10.2.js"></script>
    <script src="<?=ADMIN_THEME ?>js/bootstrap.min.js"></script>
    <script src="<?=ADMIN_THEME ?>js/plugins/metisMenu/jquery.metisMenu.js"></script>


    <!-- Page-Level Plugin Scripts - Tables -->
    <script src="<?=ADMIN_THEME ?>js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="<?=ADMIN_THEME ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <!-- SB Admin Scripts - Include with every page -->
    <script src="<?=ADMIN_THEME ?>js/sb-admin.js"></script>

    <!-- Page-Level Demo Scripts - Dashboard - Use for reference -->
    
        <script>
    $(document).ready(function() {
        $('#dataTables-example').dataTable();
    });
    </script>

</body>

</html>
