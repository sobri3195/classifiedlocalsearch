<!DOCTYPE HTML>
<head>
	<meta http-equiv="content-type" content="text/html" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="aronotic" />
        <meta name="description" content="Tiles Store provide information abour <?=$data["company"] ?>, which is manufacture of ceramic product in Morbi, Gujarat India"/>
		<meta name="keywords" content="morbi <?=$data["company"] ?>, ceramic <?=$data["company"] ?>, industry <?=$data["company"] ?>, directory <?=$data["company"] ?>, gujarat <?=$data["company"] ?>, indian <?=$data["company"] ?>, manufacturers <?=$data["company"] ?>,<?=$data["company"] ?> morbi tiles, vitrified , floor, wall tiles, sanitaryware, porcelain, asian tiles, simpolo, quartz stone"/>
		<meta name="generator" content="www.tilesstore.in"/>
		<meta name="Resource-Type" content="document"/>
		<meta name="Distribution" content="global"/>
		<meta name="Robots" content="index, follow"/>
		<meta name="Revisit-After" content="21 days"/>
		<meta name="Rating" content="general"/>
        
        <meta property="og:title" content="<?=$data["company"] ?> :: Tiles Store"/>
		<meta property="og:description" content="Tiles Store provide information abour <?=$data["company"] ?>, which is manufacture of ceramic product in Morbi, Gujarat India"/>
        <meta property="og:keywords" content="morbi <?=$data["company"] ?>, ceramic <?=$data["company"] ?>, industry <?=$data["company"] ?>, directory <?=$data["company"] ?>, gujarat <?=$data["company"] ?>, indian <?=$data["company"] ?>, manufacturers <?=$data["company"] ?>,<?=$data["company"] ?> morbi tiles, vitrified , floor, wall tiles, sanitaryware, porcelain, asian tiles, simpolo, quartz stone"/>
		<meta property="og:type" content="website"/>
		<meta property="og:url" content="http://www.tilesstore.com/"/>
		<meta property="og:image" content="http://www.tilesstore.com/themes/admin/images/logo.png"/>
		<meta property="og:site_name" content="Tiles Store"/>

	<title><?=$data["company"] ?> :: Tiles Store</title>
    <link href="<?=ADMIN_THEME ?>css/bootstrap.css" rel="stylesheet" />
    <link href="<?=ADMIN_THEME ?>css/bootstrap-theme.css" rel="stylesheet"  />
  		
    <link href="<?=ADMIN_THEME ?>css/style.css" rel="stylesheet" />
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script> 
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript" src="<?=ADMIN_THEME ?>lib/gmap/gmaps.js"></script>
     <script src="<?=ADMIN_THEME ?>/js/bootstrap.min.js"></script>
     <script>
        $(document).ready(function(){
            $("#showEnquiryBtn").click(function(){
               $("#showEnquiryForm").slideToggle("slow"); 
            });
            
            
             $("#sendEnquiry").click(function(){
            var name = $("#txtName").val();
            var company = $("#txtCompany").val();
            var email = $("#txtEmail").val();
            var phone = $("#txtPhone").val();
            var city = $("#txtCity").val();
            var state = $("#txtState").val();
            var address = $("#txtAddress").val();
            var subject = $("#txtSubject").val();
            var message = $("#txtMessage").val();
         
            if(name=="" || company=="" || email=="" || phone=="" || city=="" || subject=="" || message=="")
            {
                $(".errorMessage").html("<div class='alert alert-danger'>Please Fill All Required Fields</div>");
            }else
            {
           
           $.ajax({
            type: "POST",
            url: "index.php?component=tilesstore&action=sendenquiry",
            data: { name:name, company:company, email:email, phone:phone, state:state, message:message, city:city, subject:subject, message:message, refid:<?=$data["id"]; ?> }
            })
            .done(function( msg ) {
                $(".errorMessage").html(msg);
                $("#enquiryForm input").val("");
           });
           } 
        });
            
        });
       
     </script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body style="background-image: url(themes/admin/images/7.jpg); background-size: cover;">
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
                            <i class="fa fa-thumbs-up fa-fw"></i> 
                                </div>
                                   <ul class="nav navbar-nav navbar-right">
                                   
                                  </ul>
                             </div>   
                        </nav>        
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                        <section >
                        <div class="row">
				           <div class="col-md-12 col-lg-2 col-xs-12 ">
                                <a href="#" class="thumbnail" title="<?=$data["company"] ?> ">
                                <? if($data["image"]==""){
                                    ?>
                                    <img  src="<?=ADMIN_THEME ?>images/no_logo.jpg" alt="<?=$data["company"] ?> has no image"  />
                                    <?
                                }else{
                                    
                                 ?>
                                    <img  src="admin/userfiles/contents/small/<?=$data["image"];  ?>" alt="<?=$data["company"] ?> has no image"  />
                                <? } ?>
                                </a>
                                <a href="javascript:;" class="btn btn-success" id="showEnquiryBtn" ><i class="glyphicon glyphicon-send"></i>&nbsp; Contact Us</a>
                                <div class="modal fade " id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog  modal-lg">
    <div class="modal-content">
      
      <div class="modal-body">
        <div class="row">
            <div class="col-md-6">
       <form method="post" action=""  >
            <div class="form-group">
                <div class="">
                    <label>Full Name</label>
                    <input type="text" class="form-control" placeholder="" />
                </div>
            </div>
        </form>
            </div>
            </div>
      </div>
      <div class="modal-footer">
        
        
      </div>
    </div>
  </div>
</div>
                            </div>
                            <div class="col-md-7  col-lg-7 col-xs-12 ">
                                <h1><?=$data["company"] ?></h1>
                                <p><i class="glyphicon glyphicon-envelope"></i> <?=$data["address"]; ?></p>
                                <p><i class="glyphicon glyphicon-phone-alt"></i> <?=$data["phone1"]." / ".$data["phone2"]; ?></p>
                                <p><i class="glyphicon glyphicon-file"></i> <?=$data["fax"]; ?></p>
                                <p><i class="glyphicon glyphicon-user"></i> <?=$data["key_person1"]." / ".$data["key_person2"]; ?></p>
                            </div>
                            <div class="col-md-5  col-lg-3 col-xs-12  ">
                                <?
                                if($data["iphone"]!="" || $data["android"]!=""  )
                                {
                                    ?>
                                    <h4>Download Application:</h4>
                                    <?
                                 if($data["iphone"]!=""){
                                    ?>
                                    <div class="col-md-12">
                                        <a href="<?=$data["iphone"]; ?>" title="<?=$data["company"]." iphone application"; ?>" ><img src="<?=ADMIN_THEME ?>images/iphone_app.jpg"  alt="<?=$data["company"]." iphone application"; ?>" /></a>
                                    </div>
                                    
                                    <?
                                } ?>
                                <? if($data["android"]!=""){
                                    ?>
                                    <div class="col-md-12">
                                        <a href="<?=$data["android"]; ?>" title="<?=$data["company"]." android application"; ?>"><img src="<?=ADMIN_THEME ?>images/andoird_app.jpg"  alt="<?=$data["company"]." android application"; ?>"  /></a>
                                    </div>
                                    
                                    <?
                                } }?>
                            </div>
                            <div class="clearfix"></div>
                            <div id="showEnquiryForm">
                            <div class="wrap-content">
                            <div class="text-center">
                                <h3><i class="glyphicon glyphicon-envelope"></i><br />Send Message</h3>
                            </div><br />
                                <div class="row">
                                    <form action="" method="post" id="enquiryForm">
                                    <div class="errorMessage"></div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="col-md-4">Full Name*</div>
                                                <div class="col-md-8"><input type="text" name="name" id="txtName" required="" /></div>
                                                <div class="col-md-4">Company*</div>
                                                <div class="col-md-8"><input type="text" name="company" id="txtCompany" required="" /></div>
                                                <div class="col-md-4">Email* :</div>
                                                <div class="col-md-8"><input type="email" name="email" id="txtEmail" required="" /></div>
                                                <div class="col-md-4">Phone*</div>
                                                <div class="col-md-8"><input type="tel" name="phone" id="txtPhone" required="" /></div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="col-md-4">Address :</div>
                                                <div class="col-md-8"><textarea name="address" id="txtAddress" ></textarea></div>
                                                <div class="col-md-4">City* :</div>
                                                <div class="col-md-8"><input type="text" id="txtCity" name="city" required="" /></div>
                                                <div class="col-md-4">State :</div>
                                                <div class="col-md-8"><input type="text" id="txtState" name="state" /></div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="col-md-2">Subject*:</div>
                                                <div class="col-md-10">
                                                    <input type="text" name="subject" required="" id="txtSubject"  />
                                                </div>
                                                
                                            </div>
                                            <div class="col-md-12">
                                                <div class="col-md-2">Message*:</div>
                                                <div class="col-md-10">
                                                    <textarea name="message" id="txtMessage" ></textarea>
                                                </div>
                                                
                                            </div>
                                          <div class="clearfix"> </div>  
                                        </div>
                                        <div class="row">
                                        <div class="text-right">
                                            <div class="col-md-12">
                                            <div class="col-md-12">
                                            <a href="javascript:;" id="sendEnquiry" class="btn btn-primary" >Submit Enquiry</a>
                                            </div>
                                            </div>
                                        </div>
                                        </div>
                                    </form> 
                                </div>
                            </div>
                            </div>
                            <?  
                            if($data["latitude"]!="" && $data["longitude"]!=""){
                              
                                ?>
                                <h4 class="text-center"><i class="glyphicon glyphicon-map-marker"></i><br />Location on map</h4>
                                <div id="map_canvas"></div>
                                		<script type="text/javascript">
           var map;
           var curPosLat;
           var curPosLog;
           var destinationLat = <?=$data["latitude"]; ?>;
           var destinationLog= <?=$data["longitude"]; ?>;
           $(document).ready(function(){
				
                 map = new GMaps({
        div: '#map_canvas',
        lat: destinationLat,
        lng: destinationLog
      });
         map.addMarker({
  lat: destinationLat,
  lng: destinationLog,
  title: '<?=$data["company"]; ?>',
  click: function(e) {
    alert('You clicked in this marker');
  }
});
      
				GMaps.geolocate({
  success: function(position) {
    //map.setCenter(position.coords.latitude, position.coords.longitude);
    curPosLat = position.coords.latitude;
    curPosLog = position.coords.longitude;
  },
  error: function(error) {
    alert('Geolocation failed: '+error.message);
  },
  not_supported: function() {
    alert("Your browser does not support geolocation");
  },
  always: function() {
   var a = confirm("take a route ?!");
   if(a){
    map.drawRoute({
  origin: [curPosLat, curPosLog],
  destination: [destinationLat, destinationLog],
  travelMode: 'driving',
  strokeColor: '#131540',
  strokeOpacity: 0.6,
  strokeWeight: 6
  
});
} 		

  }
});
	
    
			});
        </script>
                                <?
                            } ?>
                            <div class="clearfix"></div>
                            <? if($data["content"]!=""){
                                ?>
                                <div class="wrap-content">
                                <h3>About Us</h3>
                                <? echo $data["content"]; ?>
                                </div>
                                <?
                            } ?>
                        </div>
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
   
    <!-- Include all compiled plugins (below), or include individual files as needed -->
   

   
</body>
</html>