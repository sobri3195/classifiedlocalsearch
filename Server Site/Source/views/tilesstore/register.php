<!DOCTYPE HTML>
<head>
		<meta http-equiv="content-type" content="text/html" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="author" content="aronotic" />
        <meta name="description" content="Register your Business with tiles Store. We will broadcast your details through all over the world. Simple and easy way to increase Business area"/>
		<meta name="keywords" content="Ceramic Directory, Ceramic Portal, Dictonary of ceramic, Ceramic Listing, Tiles Directory, Tiles Listing, Manufacture Of Tiles"/>
		<meta name="generator" content="www.tilesstore.in"/>
		<meta name="Resource-Type" content="document"/>
		<meta name="Distribution" content="global"/>
		<meta name="Robots" content="index, follow"/>
		<meta name="Revisit-After" content="21 days"/>
		<meta name="Rating" content="general"/>
        
        <meta property="og:title" content="Register to Tiles Store"/>
		<meta property="og:description" content="Register your Business with tiles Store. We will broadcast your details through all over the world. Simple and easy way to increase Business area"/>
        <meta property="og:keywords" content="Ceramic Directory, Ceramic Portal, Dictonary of ceramic, Ceramic Listing, Tiles Directory, Tiles Listing, Manufacture Of Tiles"/>
		<meta property="og:type" content="website"/>
		<meta property="og:url" content="http://www.tilesstore.com/"/>
		<meta property="og:image" content="http://www.tilesstore.com/themes/admin/images/logo.png"/>
		<meta property="og:site_name" content="Tiles Store"/>

	<title>Register to Tiles Store</title>
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
                        
						<input class="text-input form-control" name="name" type="text"  placeholder="Company Name" /> 
					
                    </div>
                    <div class="form-group">
                        
						<textarea class="text-input small-input form-control" name="address" placeholder="Address Of Company"></textarea>
					</div>
                    <div class="col-md-6">
                      <div class="form-group   "> 
                       
						<input class="form-control" name="city" type="text" placeholder="City"  />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group  "> 
                       
						<input class="form-control" name="state" type="text" placeholder="State"  />
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group   "> 
                       
						<input class="form-control" name="zip" type="text" placeholder="Zip Code"  />
                      </div>
                    </div>
                    
                    
                    <div class="col-md-6">
                     <div class="form-group  input-group ">
                        
                        <span class="input-group-addon">0</span>
						<input class="form-control" name="phone1" type="tel" placeholder="2822 244086 (Phone 1)"  />
                        
                    </div>
                    </div>
                    
                   
                    <div class="col-md-6">
                    <div class="form-group  input-group ">
                        
                        <span class="input-group-addon"><i class="glyphicon glyphicon-envelope"></i></span>
						<input class="form-control" name="email1" type="email" placeholder="Email Address 1"  />
                        
                    </div>
                    </div>
                    
                    
                     
                    
                    <div class="col-md-6 ">
                      <div class="form-group  input-group "> 
                       <span class="input-group-addon"><strong>W</strong></span>
						<input class="form-control" name="website" type="text" placeholder="http://www.yoursite.com"  />
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
                      
                       <? foreach($cats as $cat){
                        ?>
                        <div class="checkbox"><label><input type="checkbox" name="category[]" value="<?=$cat["id"] ?>" /><?=$cat["title"]; ?> </label></div>
                        <?
                       } ?>
					   	
                      </div>
                </div>
   </div>
   <input class="btn btn-primary btn-lg col-md-12 " type="submit" name="add" value="Add" />
   </div>
    
   
</div>
</form>
            



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