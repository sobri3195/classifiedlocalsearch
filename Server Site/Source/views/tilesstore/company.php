<!DOCTYPE HTML>
<head>
	<meta http-equiv="content-type" content="text/html" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="aronotic" />
        <meta name="description" content="<?=$category["description"]; ?>"/>
		<meta name="keywords" content="morbi <?=$category["title"] ?>, ceramic <?=$category["title"] ?>, industry <?=$category["title"] ?>, directory <?=$category["title"] ?>, gujarat <?=$category["title"] ?>, indian <?=$category["title"] ?>, manufacturers <?=$category["title"] ?>,<?=$category["title"] ?> morbi tiles, vitrified , floor, wall tiles, sanitaryware, porcelain, asian tiles, simpolo, quartz stone"/>
		<meta name="generator" content="www.tilesstore.in"/>
		<meta name="Resource-Type" content="document"/>
		<meta name="Distribution" content="global"/>
		<meta name="Robots" content="index, follow"/>
		<meta name="Revisit-After" content="21 days"/>
		<meta name="Rating" content="general"/>
        
        <meta property="og:title" content="<?=$category["title"]; ?> Manufacture and Exporters <?=$_REQUEST["txtsearch"]; ?> :: Tiles Store"/>
		<meta property="og:description" content="<?=$category["description"]; ?>"/>
        <meta property="og:keywords" content="morbi <?=$category["title"] ?>, ceramic <?=$category["title"] ?>, industry <?=$category["title"] ?>, directory <?=$category["title"] ?>, gujarat <?=$category["title"] ?>, indian <?=$category["title"] ?>, manufacturers <?=$category["title"] ?>,<?=$category["title"] ?> morbi tiles, vitrified , floor, wall tiles, sanitaryware, porcelain, asian tiles, simpolo, quartz stone"/>
		<meta property="og:type" content="website"/>
		<meta property="og:url" content="http://www.tilesstore.com/"/>
		<meta property="og:image" content="http://www.tilesstore.com/themes/admin/images/logo.png"/>
		<meta property="og:site_name" content="Tiles Store"/>

	<title><?=$category["title"]; ?> Manufacture and Exporters <?=$_REQUEST["txtsearch"]; ?> :: Tiles Store</title>
    <link href="<?=ADMIN_THEME ?>css/bootstrap.css" rel="stylesheet" />
    <link href="<?=ADMIN_THEME ?>css/bootstrap-theme.css" rel="stylesheet"  />
  		
    <link href="<?=ADMIN_THEME ?>css/style.css" rel="stylesheet" />
<? if(!common::get_session("first_time_$category[id]")){ ?>    
    <script>
        function loadAds(){
            $('#myModal').modal({
  show: true
});

        }
    </script>
<? } ?>
<? common::set_session("first_time_$category[id]",true); ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body onload="loadAds()"  style="background: #0080C0;">
<div class="modal fade " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
      
      <div class="modal-body">
        <img src="<?=ADMIN_THEME ?>images/ads1.jpg" width="100%" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        
      </div>
    </div>
  </div>
</div>
<div id="wrapper">
    <header>
        <div class="container">
        <? common::elements("nav_bar"); ?>
        </div>
    </header>
    
    <div class="container ">
        <div class="row">
            <div >
            <div class="col-md-3 col-lg-3 col-xs-12">
            <? common::elements("side_bar_cats"); ?>
                
            </div>
            <div class="col-md-9 col-lg-9 col-xs-12 ">
                <div class="inner-panel">
                <div class="panel panel-default">
                        <div class="panel-heading">
                        <nav class="navbar " role="navigation">
                            <div class="container-fluid">
                                <div class="navbar-header">
                            <i class="fa fa-thumbs-up fa-fw"></i> Top Industries
                                </div>
                                   <ul class="nav navbar-nav navbar-right">
                                    <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">A-Z <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="<?=common::get_component_link(array("tilesstore","company"))."&ref=".common::get_control_value("ref")."&products=".common::get_control_value("products"); ?>">A--Z</a></li>
            <li><div class="divider"></div></li>
            <li><a href="<?=common::get_component_link(array("tilesstore","company"))."&ref=".common::get_control_value("ref")."&products=".common::get_control_value("products")."&order=a-f"; ?>">A-F</a></li>
            <li><a href="<?=common::get_component_link(array("tilesstore","company"))."&ref=".common::get_control_value("ref")."&products=".common::get_control_value("products")."&order=g-l"; ?>">G-L</a></li>
            <li><a href="<?=common::get_component_link(array("tilesstore","company"))."&ref=".common::get_control_value("ref")."&products=".common::get_control_value("products")."&order=m-r"; ?>">M-R</a></li>
            <li><a href="<?=common::get_component_link(array("tilesstore","company"))."&ref=".common::get_control_value("ref")."&products=".common::get_control_value("products")."&order=s-z"; ?>">S-Z</a></li>
          </ul>
        </li>
        <li>
            <a href="<?=common::get_component_link(array("tilesstore","company"))."&ref=".common::get_control_value("ref")."&products=".common::get_control_value("products")."&top=true"; ?>"><i class="glyphicon glyphicon-thumbs-up"></i> Top Companies </a>
        </li>
        <li>
            <a href="<?=common::get_component_link(array("tilesstore","company"))."&ref=".common::get_control_value("ref")."&products=".common::get_control_value("products")."&trust=true"; ?>"><i class="glyphicon glyphicon-certificate"></i> Qualified </a>
        </li>
                                  </ul>
                                   <form class="navbar-form navbar-left" role="search" action="" method="post">
        <div class="form-group">
          <input type="text" name="txtsearch" class="form-control" placeholder="Search">
        </div>
        <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
      </form>
                             </div>   
                        </nav>        
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <section >
				            <ul class="list-group">
                        <? foreach($data as $val)
                        {
                        ?>
                        <li class="list-group-item company-list">
                        <div class="row">
                            <div class="col-md-2 col-lg-2  col-xs-12 ">
                                <a href="<?=common::get_component_link(array("tilesstore","details"))."&ref=".$val["id"]."&name=".common::seoUrl($val['company']); ?>" class="thumbnail" title="<?=$val["company"] ?> ">
                                <? if($val["logo"]==""){
                                    ?>
                                    <img  src="<?=ADMIN_THEME ?>images/no_logo.jpg" alt="<?=$val["company"] ?> has no image"  />
                                    <?
                                }else{
                                    
                                 ?>
                                    <img  src="userfiles/contents/small/<?=$val["logo"];  ?>" alt="<?=$val["company"] ?> has no image"  />
                                <? } ?>
                                </a>
                        
                            </div>
                            <div class="col-md-7 col-lg-8 col-xs-8">
                                    <h4 class="list-group-item-heading"> <a href="<?=common::get_component_link(array("tilesstore","details"))."&ref=".$val["id"]."&name=".common::seoUrl($val['company']); ?>" title="<?=$val["company"]; ?>"><?=$val["company"]; ?></a></h4>
                                    <p class="list-group-item-text">
                                    <i class="glyphicon glyphicon-envelope"></i> <?=$val["address"]; ?><br />
                                    city : <?=$val["city"]; ?>   
                                    </p>
                                    <p class="list-group-item-text">
                                    <i class="glyphicon glyphicon-phone-alt"></i> <?=$val["phone1"]; ?>   
                                    </p>
                                    <p class="list-group-item-text">
                                    <i class="glyphicon glyphicon-phone"></i> <?=$val["key_person1"]; ?>   
                                    </p>
                            </div>    
                            <div class="col-md-3 col-lg-2  col-xs-4 ">
                                <div class="action text-center">
                                    
                                    <div class="col-md-6">
                                        <a href="<?=common::get_component_link(array("tilesstore","details"))."&ref=".$val["id"]."&name=".common::seoUrl($val['company']); ?>" title="Details of <?=$val["company"]; ?>"><i class="glyphicon glyphicon-list-alt"></i>
                                        <p>Details</p>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        </li>
                        <?
                        }
                        ?>
                        </ul>
                        <? common::get_page_list2($gpages,$cpage); ?>
                        </section>
                        </div>
                </div>
                </div>
                            
            </div>
            <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?=ADMIN_THEME ?>/js/bootstrap.min.js"></script>
   
</body>
</html>