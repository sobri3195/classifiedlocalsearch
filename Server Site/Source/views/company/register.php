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
    <link rel="stylesheet" type="text/css" href="<?=ADMIN_THEME ?>lib/wysihtml5/src/bootstrap-wysihtml5.css"></link>
</head>

<body>

    <div id="wrapper">

        <? echo common::elements("adminnav"); ?>
        <div id="page-wrapper">
<div class="row">
<div class="col-lg-12">
<h1 class="page-header"><i class="fa fa-suitcase fa-fw"></i> Registration</h1>
</div>
</div>
<form role="form" action="" method="post" enctype="multipart/form-data" >
<div class="row">
    <div class="col-md-5">

<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-suitcase fa-fw"></i> Add New Business 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
        
			         <? if ( common::do_show_message() ) {
		                          echo common::show_message();	
                        } ?> 
                  
                    <div class="form-group">
                        
						<input class="text-input form-control" name="name" type="text"  placeholder="Company Name" value="<? echo common::get_back_value("name") ; ?>" /> 
					
                    </div>
                    <div class="form-group">
                        
						<textarea class="text-input small-input form-control" name="address" placeholder="Address Of Company"> <? echo common::get_back_value("address") ; ?> </textarea>
					</div>
                    <div class="col-md-6">
                      <div class="form-group   "> 
                       
						<input class="form-control" name="city" type="text" placeholder="City"   value="<? echo common::get_back_value("city") ; ?>"  />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group  "> 
                       
						<input class="form-control" name="state" type="text" placeholder="State"  value="<? echo common::get_back_value("stage") ; ?>"   />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group   "> 
                       
						<input class="form-control" name="zip" type="text" placeholder="Zip Code"  value="<? echo common::get_back_value("zip") ; ?>"   />
                      </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group   "> 
                            &nbsp;
                        </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group  input-group "> 
                        <span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
						<input class="form-control" name="lat"  value="<? echo common::get_back_value("lat") ; ?>"  type="tel" placeholder="Latitude"  />
                      </div>
                    </div>
                    
                    <div class="col-md-6 ">
                        <div class="form-group  input-group ">
                        <span class="input-group-addon"><i class="fa fa-location-arrow"></i></span>
						<input class="form-control" name="log"  value="<? echo common::get_back_value("log") ; ?>"  type="tel" placeholder="Longitude"  />
                        </div>
                    </div>
                    <div class="col-md-6">
                     <div class="form-group  input-group ">
                        
                        <span class="input-group-addon">+91</span>
						<input class="form-control" name="phone1"  value="<? echo common::get_back_value("phone1") ; ?>"  type="tel" placeholder="02822 244086 (Phone 1)"  />
                        
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group  input-group ">
                        
                        <span class="input-group-addon">+91</span>
						<input class="form-control" name="phone2"  value="<? echo common::get_back_value("phone2") ; ?>"  type="tel" placeholder="02822 244086 (Phone 2)"  />
                        
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group  input-group ">
                        
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
						<input class="form-control" name="person1"  value="<? echo common::get_back_value("person1") ; ?>"  type="tel" placeholder="Key Person 1 (+91 98765 43210)"  />
                        
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group  input-group ">
                        
                        <span class="input-group-addon"><i class="fa fa-user"></i></span>
						<input class="form-control" name="person2"  value="<? echo common::get_back_value("person2") ; ?>"  type="tel" placeholder="Key Person 2 (+91 98765 43210)"  />
                        
                    </div>
                    </div>
                     <div class="col-md-6">
                    <div class="form-group  input-group ">
                        
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
						<input class="form-control" name="email1"  value="<? echo common::get_back_value("email1") ; ?>"  type="email" placeholder="Email Address 1"  />
                        
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group  input-group ">
                        
                        <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
						<input class="form-control" name="email2"  value="<? echo common::get_back_value("email2") ; ?>"  type="email" placeholder="Email Address 2"  />
                        
                    </div>
                    </div>
                    
                      <div class="col-md-6">
                    <div class="form-group  input-group ">
                        
                        <span class="input-group-addon"><i class="fa fa-android"></i></span>
						<input class="form-control" name="android"  value="<? echo common::get_back_value("android") ; ?>"  type="text" placeholder="Playstore Link"  />
                        
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group  input-group ">
                        
                        <span class="input-group-addon"><i class="fa fa-apple"></i></span>
						<input class="form-control" name="iphone"  value="<? echo common::get_back_value("iphone") ; ?>"  type="text" placeholder="Appstore Link"  />
                        
                    </div>
                    </div>
                    <div class="col-md-6 ">
                      <div class="form-group  input-group "> 
                       <span class="input-group-addon"><strong>W</strong></span>
						<input class="form-control" name="website"  value="<? echo common::get_back_value("website") ; ?>"  type="text" placeholder="http://www.yoursite.com"  />
                      </div>
                    </div>
                    
                    
                                       <div class="clearfix"></div>
                    <div class="col-md-6">
                        <div class="col-md-8">
                            STATUS ACTIVE
                        </div>
                        <div class="col-md-4">
                            <div class="onoffswitch">
                            <input type="checkbox" name="status" class="onoffswitch-checkbox"  id="statonoffswitch" <? if(common::get_back_value("status")){ echo "checked"; } ?> >
                            <label class="onoffswitch-label" for="statonoffswitch">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                            </label>
                            </div> 
                        
                        </div>
                    
                    </div>    
                     <div class="clearfix"></div> 
                    <div class="col-md-6">
                        <div class="col-md-8">
                            IS A GOLD MEMBER
                        </div>
                        <div class="col-md-4">
                            <div class="onoffswitch">
                            <input type="checkbox" name="gold" class="onoffswitch-checkbox" id="goldonoffswitch" <? if(common::get_back_value("status")){ echo "checked"; } ?> >
                            <label class="onoffswitch-label" for="goldonoffswitch">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                            </label>
                            </div> 
                        
                        </div>
                    
                    </div>  
                    <div class="col-md-6">
                        <div class="col-md-8">
                            IS A VARIFIED MEMBER
                        </div>
                        <div class="col-md-4">
                            <div class="onoffswitch">
                            <input type="checkbox" name="varified" class="onoffswitch-checkbox" id="varifiedonoffswitch" <? if(common::get_back_value("status")){ echo "checked"; } ?> >
                            <label class="onoffswitch-label" for="varifiedonoffswitch">
                            <span class="onoffswitch-inner"></span>
                            <span class="onoffswitch-switch"></span>
                            </label>
                            </div> 
                        
                        </div>
                    
                    </div>     
                    
                   <div class="col-md-6">
                        <div class="form-group  input-group ">
                        
                        <span class="input-group-addon">Set Listing Order</span>
						<input class="form-control" name="order" type="number" placeholder="" value="<? echo common::get_back_value("order") ; ?>"   />
                        
                        </div>
                    </div> 
                   
           
</div>
</div>

    </div>
    <div class="col-md-2">
    <div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-list fa-fw"></i> Select Category
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
   </div>
    <div class="col-md-5">

<div class="panel panel-default">
                        <div class="panel-heading">
                            <i class="fa fa-text-height fa-fw"></i> About Registration
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="form-group  ">
                        	<textarea class="textarea form-control" name="content" placeholder="Enter text ..." style="width: 100%; height: 320px"><? echo common::get_back_value("content"); ?></textarea>
                            </div>
                        <div class="form-group">
                        
						  <input type="file" name="featureimage" class="btn btn-default" />
                          <input type="hidden" value="<? echo $logoimage; ?>" name="logoimg" />
                          <img src="<? echo ($logoimage) ? "userfiles/contents/small/".$logoimage : "themes/admin/images/ic_launcher.png"; ?>" />
					       </div>
                            <div class="form-group">
                        Banner Image :
						  <input type="file" name="bannerimage" class="btn btn-default" />
                          <input type="hidden" value="<? echo $bannerimage; ?>" name="bannerimg" />
                          <img src="<? echo ($bannerimage) ? "userfiles/contents/small/".$bannerimage : "themes/admin/images/ic_launcher.png"; ?>" />
					       </div>
                           <input class="btn btn-primary btn-lg col-md-12 " type="submit" name="add" value="Add" />
                        </div>
                        


</div>    

    </div>
    
        
        
    </div>
</div>
</form>
            
            
			</div>
                  </div>
    <!-- /#wrapper -->

    <!-- Core Scripts - Include with every page -->
    <script src="<?=ADMIN_THEME ?>lib/wysihtml5/lib/js/wysihtml5-0.3.0.js"></script>
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
<script src="<?=ADMIN_THEME ?>lib/wysihtml5/src/bootstrap-wysihtml5.js"></script>

<script>
$(document).ready(function(){
    $('.textarea').wysihtml5();
});
	
</script>
</body>

</html>
