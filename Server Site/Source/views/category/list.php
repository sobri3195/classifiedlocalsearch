<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Table</title>

    <!--Mobile first-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!--IE Compatibility modes-->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="msapplication-TileColor" content="#5bc0de">
    <meta name="msapplication-TileImage" content="<?=ADMIN_THEME; ?>img/metis-tile.png">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="<?=ADMIN_THEME; ?>lib/bootstrap/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?=ADMIN_THEME; ?>lib/Font-Awesome/css/font-awesome.min.css">

    <!-- Metis core stylesheet -->
    <link rel="stylesheet" href="<?=ADMIN_THEME; ?>css/main.min.css">
    <link rel="stylesheet" href="<?=ADMIN_THEME; ?>css/theme.css">
    <link rel="stylesheet" href="<?=ADMIN_THEME; ?>lib/datatables/css/demo_page.css">
    <link rel="stylesheet" href="<?=ADMIN_THEME; ?>lib/datatables/css/DT_bootstrap.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->

    <!--[if lt IE 9]>
      <script src="<?=ADMIN_THEME; ?>lib/html5shiv/html5shiv.js"></script>
	      <script src="<?=ADMIN_THEME; ?>lib/respond/respond.min.js"></script>
	    <![endif]-->

    <!--Modernizr 3.0-->
    <script src="<?=ADMIN_THEME; ?>lib/modernizr-build.min.js"></script>
  </head>
<body>
<div class="" id="wrap">
        <? echo common::elements("header"); ?>
       	<? echo common::elements("sidebar");  ?>
        
        <div id="content">
            <div class="outer">
                <div class="inner">			
			<!-- Page Head -->
		    <div class="block">
                <div class="navbar navbar-inner block-header">
                <div class="muted pull-left">
                  Registration 
                </div>
                
               
                <a href="<?=common::get_component_link(array('category','add')); ?>" class="btn btn-primary f_right " style="float: right;" >Add New</a>
                </div>
                <div class="row">
                    <div class="col-lg-12">
			<? if ( common::do_show_message() ) {
		          echo common::show_message();	
            } ?>
			<form action="" method="post">
                                            <input type="text" name="s" class="f_left" /><input type="submit"  value="Search" name="search" class="btn f_left" />
                </form>			
                	<table id="dataTable" class="table table-bordered table-condensed table-hover table-striped">

							
							<thead>
								<tr>
								   
								   <th>Product</th>
								   <th>Size</th>
                                   <th>Title</th>
								   <th>Description</th>
								   <th>Image</th>
								   <th>Action</th>
								</tr>
								
							</thead>
						 
							<tfoot>
								<tr>
									<td colspan="6">
										<? // common::get_page_list2($gpages,$cpage); ?>
										 <!-- End .pagination -->
										<div class="clear"></div>
									</td>
								</tr>
							</tfoot>
						 
							<tbody>
                            <? foreach($data as $val){ ?>
								<tr>
									
									<td><?=$q->ge_value("Select `title` from `products` where `id`=".$val['product']);?></td>
									<td><?=$q->ge_value("Select `alias` from `size` where `id`=".$val['size']); ?></td>
                                    <td><?=$val['title'] ?></td>
									<td><?=$val['description'] ?></td>
									<td><img src="userfiles/contents/small/<?=$val['featureimage'] ?>" width="30" /></td>
									<td>
										<!-- Icons -->
										 <a href="<?=common::get_component_link(array('category','edit')).'&id='.$val['id']; ?>" title="Edit"><i class="glyphicon glyphicon-pencil"></i></a>
										 <a href="<?=common::get_component_link(array('category','delete')).'&id='.$val['id']; ?>" title="Delete"><i class="glyphicon glyphicon-remove"></i></a> 
										 
									</td>
								</tr>
							<? } ?>	
						  </tbody>
                    </table>
        
			</div>
                </div>
			
            </div>
			<div class="clear"></div> <!-- End .clear -->
			
			

			
		</div> <!-- End #main-content -->
		</div>
	</div>
 </div>
 			<div id="footer">
				<small> <!-- Remove this notice or replace it with whatever you want -->
						&#169; Copyright 2013 Tile Store | Powered by <a href="http://waywebsolution.com">way tech</a> | <a href="#">Top</a>
				</small>
			</div><!-- End #footer -->
<script src="<?=ADMIN_THEME; ?>lib/jquery.min.js"></script>
    <script src="<?=ADMIN_THEME; ?>lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <script src="<?=ADMIN_THEME; ?>lib/datatables/jquery.dataTables.js"></script>
    <script src="<?=ADMIN_THEME; ?>lib/datatables/DT_bootstrap.js"></script>
    <script src="<?=ADMIN_THEME; ?>lib/tablesorter/js/jquery.tablesorter.min.js"></script>
    <script src="<?=ADMIN_THEME; ?>lib/touch-punch/jquery.ui.touch-punch.min.js"></script>
    <script>
      $(function() {
        metisTable();
        metisSortable();
      });
    </script>
    <script src="<?=ADMIN_THEME; ?>lib/screenfull/screenfull.js"></script>
    <script src="<?=ADMIN_THEME; ?>js/main.min.js"></script>

    <!--For Demo Only. Not required -->
    
  </body>
</html>