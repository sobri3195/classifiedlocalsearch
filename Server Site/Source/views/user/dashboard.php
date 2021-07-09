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
                    <h1 class="page-header"><i class="fa fa-dashboard"></i> Dashboard</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    
                   <?
                   if(common::get_session(ADMIN_LOGIN_TYPE)=="user")
                   {
                    ?>
                    

<form role="form" action="" method="post" enctype="multipart/form-data" >
<div class="row">
    <div class="col-md-8">

<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="glyphicon glyphicon-user"></i> Registration Details
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
        
			         <? if ( common::do_show_message() ) {
		          echo common::show_message();	
            } ?> 
                  
                    <div class="form-group">
                        
						<input class="text-input form-control" name="name" value="<? echo common::get_back_value("name"); ?>" type="text"  placeholder="Company Name" /> 
					
                    </div>
                    <div class="form-group">
                        
						<textarea class="text-input small-input form-control" name="address" placeholder="Address Of Company"><? echo common::get_back_value("address"); ?></textarea>
					</div>
                    <div class="col-md-6">
                      <div class="form-group   "> 
                       
						<input class="form-control" name="city" type="text" placeholder="City"  value="<? echo common::get_back_value("city"); ?>"  />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group  "> 
                       
						<input class="form-control" name="state" value="<? echo common::get_back_value("state"); ?>" type="text" placeholder="State"  />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group   "> 
                       
						<input class="form-control" name="zip" value="<? echo common::get_back_value("zip"); ?>" type="text" placeholder="Zip Code"  />
                      </div>
                    </div>
                    
                    
                    <div class="col-md-6">
                     <div class="form-group  input-group ">
                        
                        <span class="input-group-addon">0</span>
						<input class="form-control" name="phone1" value="<? echo common::get_back_value("phone1"); ?>" type="tel" placeholder="2822 244086 (Phone 1)"  />
                        
                    </div>
                    </div>
                    
                   
                    <div class="col-md-6">
                    <div class="form-group  input-group ">
                        
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
						<input class="form-control" name="email1" value="<? echo common::get_back_value("email1"); ?>" type="email" placeholder="Email Address 1"  />
                        
                    </div>
                    </div>
                    
                    
                     
                    
                    <div class="col-md-6 ">
                      <div class="form-group  input-group "> 
                       <span class="input-group-addon"><strong>W</strong></span>
						<input class="form-control" name="website" value="<? echo common::get_back_value("website"); ?>" type="text" placeholder="http://www.yoursite.com"  />
                      </div>
                    </div>
                    
                    
                    
<p>* All Fileds are required no any optional details</p>                   
           
</div>
</div>

    </div>
    <div class="col-md-4">
    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="glyphicon glyphicon-list"></i> Select Category
                        </div>
                         <div class="panel-body">
                      <div class="form-group"> 
 <div class="panel-group" id="accordion">                     
                       <? 
                       $q = new Query();
$q->select()
->from("maincategory")
->run();
$mcats = $q->get_selected();
foreach($mcats as $mc){ ?>

  
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne-<? echo $mc["id"]; ?>">
          <? echo $mc["title"]; ?>
        </a>
      </h4>
    </div>
    <div id="collapseOne-<? echo $mc["id"]; ?>" class="panel-collapse collapse">
      <div class="panel-body">
<?
                       $q = new Query();
$q->select()
->from("categories")
->where_equal_to(array("parent"=>$mc["id"]))
->run();
$cats = $q->get_selected();
//$i = 0;
                       foreach($cats as $cat){
                        ?>
                        <div class="checkbox"><label><input type="checkbox" name="category[]" value="<?=$cat["id"] ?>" <? if(is_array($_REQUEST["category"])){ if(in_array($cat["id"],$_REQUEST["category"])){ echo "checked selected"; } }?> /><?=$cat["title"]; ?> </label></div>
                        <?
                        //$i++;
                       }
                       ?>

</div>
</div>
                       <?
                       } ?>
</div>					   	
                      </div>
                </div>
   </div>
   <input class="btn btn-primary btn-lg col-md-12 " type="submit" name="add" value="Add" />
   </div>
    
   
</div>
</form>

                    <?
                   }else{
                    ?>
                    
                    <div class="row">
                        <div class="col-md-8">
                            <div class="panel panel-default">
                                            <div class="panel-heading">
                                                <i class="glyphicon glyphicon-user"></i> Unverified Company
                                            </div>
                                            <!-- /.panel-heading -->
                                            <div class="panel-body">
                            
                    			         <? if ( common::do_show_message() ) {
                    		          echo common::show_message();	
                                } ?> 
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Company</th>
                                            <th>Email</th>
                                            <th>Logo</th>
                                            <th>Status</th>
                                            <th>Order</th>
                                            <th>GOLD</th>
                                            <th>Verified</th>
                                            <th>Action</th>
                                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                <?
                                foreach($usersdata as $d)
                                {
                                    ?>
                                    <tr class="odd gradeX">
                                            <td><?=$d["id"]; ?></td>
                                            <td><?=$d["company"]; ?></td>
                                            <td><?=$d["email1"]." / ".$d["email2"]; ?></td>
                                            <td><img src="<? if(file_exists("userfiles/contents/icon/".$d["logo"]) && $d["logo"]!=""){
                                                echo "userfiles/contents/icon/".$d["logo"];
                                            }else
                                            {
                                                echo "themes/admin/images/ic_launcher.png";
                                            } ?>
                                            " alt="NO IMAGE" /></td>
                                            <td><?=$d["status"]; ?></td>
                                            <td><?=$d["order"]; ?></td>
                                            <td><?=$d["special"]; ?></td>
                                            <td><?=$d["top"]; ?></td>
                                           
                                            <td class="center"><a href="<?=common::get_component_link(array("company","delete"))."&id=".$d["id"]; ?>" title="delete"><i class="glyphicon glyphicon-remove-circle"></i></a>
                                            <a href="<?=common::get_component_link(array("company","edit"))."&id=".$d["id"]; ?>" title="Edit"><i class="fa fa-edit"></i></a></td>
                                            
                                        </tr>
                                    <?
                                }
                                ?>
                                    </tbody>
                                </table>
                                            </div>
                            </div>
                        </div>
                    </div>
                    <?
                   }
                   ?>
                    
                </div>
                <!-- /.col-lg-4 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- Core Scripts - Include with every page -->
    <script src="<?=ADMIN_THEME ?>js/jquery-1.10.2.js"></script>
    <script src="<?=ADMIN_THEME ?>js/bootstrap.min.js"></script>
    <script src="<?=ADMIN_THEME ?>js/plugins/metisMenu/jquery.metisMenu.js"></script>

    <!-- Page-Level Plugin Scripts - Dashboard 
    <script src="<=ADMIN_THEME ?>js/plugins/morris/raphael-2.1.0.min.js"></script>
    <script src="<=ADMIN_THEME ?>js/plugins/morris/morris.js"></script>
    -->
    
    <!-- Page-Level Plugin Scripts - Tables -->
    <script src="<?=ADMIN_THEME ?>js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="<?=ADMIN_THEME ?>js/plugins/dataTables/dataTables.bootstrap.js"></script>
    <!-- SB Admin Scripts - Include with every page -->
    <script src="<?=ADMIN_THEME ?>js/sb-admin.js"></script>

    <!-- Page-Level Demo Scripts - Dashboard - Use for reference 
    <script src="<=ADMIN_THEME ?>js/demo/dashboard-demo.js"></script>
    -->
     <script>
    $(document).ready(function() {
        $('#dataTables-example').dataTable();
    });
    </script>
</body>

</html>
