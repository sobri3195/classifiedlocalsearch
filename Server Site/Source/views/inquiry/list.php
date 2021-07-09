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
<h1 class="page-header"><i class="fa fa-envelope fa-fw"></i>Enquries</h1>
</div>
</div>
<div class="row">
   
    
    <div class="col-md-12">

        <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-envelope fa-fw"></i> List Enqury Messages
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">


<div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            
                                            
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Address</th>
                                            <th>Company</th>
                                            <th>Message</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <? foreach($data as $d){ ?>
                                        <tr class="odd gradeX">
                                            <td><?=$d["name"]; ?></td>
                                            <td><?=$d["email"]; ?></td>
                                            <td><?=$d["phone"]; ?></td>
                                            <td><?=$d["address"]; ?><br />
                                            <?="City : ".$d["city"]; ?><br />
                                            <?="State : ".$d["state"]; ?></td>
                                            <td><?=$d["company"]; ?></td>
                                            <td><?="Subject : ".$d["subject"]."<br /><br />".$d["message"]; ?></td>
                                            <td><?=$d["date"]; ?></td>
                                        </tr>
                                     <? } ?>   
                                    </tbody>
                                </table>
                            </div>


                        </div>


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
        $('.onoffswitch-checkbox').change(function(){
           int aproved = 0;
           int id = $(this).data("id");
           if($(this).is(':checked'))
           {
            aproved = 1;
            $.ajax({
                type: "POST",
                url: "index.php?component=review&action=approve.php&id="+id+"&act="+aproved,
                
            })
            .done(function( msg ) {
                
            });
                
                
           } 
        });
    });
    </script>

</body>

</html>
