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
<h1 class="page-header"><i class="fa fa-user fa-fw"></i> Edit User</h1>
</div>
</div>
<div class="row">
    <div class="col-md-6">

<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-user fa-fw"></i> Edit user
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
        
			<form id="form" action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <div class="form-group">
                        <label for="text1" class="control-label col-lg-4">User Name</label>
                        <div class="col-lg-8">
						<input class="form-control" name="username" value="<?=$data["username"]; ?>" type="text" />
					   </div>
                    </div>
                    <div class="form-group">
                        <label for="text1" class="control-label col-lg-4">Password</label>
                        <div class="col-lg-8">
                        <input class="form-control" name="temppassword" value="<?=$data["password"]; ?>" type="hidden" />
						<input class="form-control" name="password" value="<?=$data["password"]; ?>" type="password" />
					</div>
                    </div>
                    <div class="form-group">
                        <label for="text1" class="control-label col-lg-4">Email</label>
                        <div class="col-lg-8">
						<input class="form-control" name="email" type="email" value="<?=$data["email"]; ?>" />
					</div>
                    </div>
                    <div class="form-group">
                        <label for="text1" class="control-label col-lg-4">Type</label>
                        <div class="col-lg-8">
						<select name="type" class="form-control">
                            <option><?=$data["type"]; ?></option>
                            <option>admin</option>
                            <option>user</option>
                        </select>
					</div>
                    </div>
                    <div class="form-group">
                        <label for="text1" class="control-label col-lg-4">Active</label>
                        <div class="col-lg-8">
						<select name="active" class="form-control">
                            <option value="<?=$data["active"]; ?>"></option>
                            <option value="1">Yes</option>
                            <option value="0">No</option>
                        </select>
					</div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-8">
						<input class="btn" type="submit" name="submit" value="Add" />
					       </div>
                    </div>
                    </div>
            </form>
</div>
</div>


    
    <div class="col-md-6">

    

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
