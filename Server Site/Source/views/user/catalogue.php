<!DOCTYPE html>
<html lang="en">
  <head>
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
    <link rel="stylesheet" href="<?=DEFAULT_THEME; ?>css/style.css">
    <!--[if lt IE 9]>
      <script src="<?=ADMIN_THEME; ?>lib/html5shiv/html5shiv.js"></script>
	      <script src="<?=ADMIN_THEME; ?>lib/respond/respond.min.js"></script>
	    <![endif]-->
  </head>
<body>
<header>
    <div class="container">
    <div class="row">
        <div class="col-lg-3">
        <img src="<?=ADMIN_THEME ?>img/logo.png" />
        </div>
        <div class="col-lg-9">
        <div class="cart-box">
            <i class="glyphicon glyphicon-shopping-cart"></i>&nbsp;ITEMS IN CART : 
            
            
      Items : <span id="CartItems">  <?=count($_SESSION["designno"]); ?></span>
    <div class="btn-group btn-group">
      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
      <i class="glyphicon glyphicon-user"></i>
    </button>
    <div class="dropdown-menu" id="DW-Cart-Item" style="margin-left: -120px; padding: 10px;">
        <div><i class="glyphicon glyphicon-align-justify"></i>&nbsp;<a href="javascript:;" id="ViewCart">View Cart</a></div>
            <div><i class="glyphicon glyphicon-remove-circle"></i>&nbsp;<a href="javascript:;" id="ClearCart">Clear Cart</a></div>
            <div><i class="glyphicon glyphicon-log-out"></i>&nbsp;<a href="<?=common::get_component_link(array("home","logout")); ?>" >Logout</a></div>
        </ul>
      <?
        //for($i=0;$i< count($_SESSION['designno']);$i++)
        //{
            //echo "<div class='row'><div class='col-lg-9'><a href='javascript:;' title='$i' data-designno='".$_SESSION["designno"][$i]."' data-qty='".$_SESSION["qty"][$i]."' class='cart-item'  data-toggle='modal' data-target='#CartAction' >".$_SESSION['designno'][$i]."</a></div><div class='col-lg-3'>".$_SESSION['qty'][$i]."</div></div>";
        //}
      ?>
  
    </div>       
            </div>
            <div class="modal fade" id="CartAction" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                  </div>
                  <div class="modal-body">
                    <input type="text" id="cart-item-qty" />
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancle</button>
                    <button type="button" class="btn btn-primary cart-update-btn" data-id=""  >Update Value</button>
                    <button type="button" class="btn btn-danger cart-delete-btn" data-id="" >Delete</button>
                  </div>
                </div>
              </div>
            </div>
        </div>
        </div>
    </div>
    </div>
</header>
<section>
<div class="container">
<div class="row">
    <div class="col-lg-3">
        <div class="box">
        <form action=""  method="post">
            <label><i class="glyphicon glyphicon-retweet"></i>&nbsp; Select Size : </label>
            <select class="form-control" name="size" id="SelSize">
            <option value="">--Select--</option>
            <?
            foreach($sizes as $size)
            {
                ?>
                <option value="<?=$size["id"] ?>"><?=$size["alias"]; ?></option>
                <?
            }
            ?>
            </select>
            <label><i class="glyphicon glyphicon-th-list"></i> &nbsp; Select Category : </label>
            <select name="category" class="form-control"  id="SelCat">
            <option>--Select--</option>
            
            </select>
            <button type="button" class="btn btn-primary col-lg-12" id="Filter">Filter</button>
         </form>  <div class="clearfix"><br /><br /></div>
         <form action="" method="post">
             <label><i class="glyphicon glyphicon-search"></i>&nbsp; Search by Design No : </label>
             <input type="text" name="s" class="form-control" placeholder="Design No" id="searchTxt" /><br />
             <button type="button" class="btn btn-primary col-lg-12" id="SearchBtn">Search</button>
         </form> 
         <div class="clearfix"></div>
        </div>
    </div>
    <div class="col-lg-9">
        <div id="DisplayProducts">
        	<? if ( common::do_show_message() ) {
		          echo common::show_message();	
            } ?>

        </div>
    </div>

</div>
</div>
</section>
    <script src="<?=ADMIN_THEME; ?>lib/jquery.min.js"></script>
    <script src="<?=ADMIN_THEME; ?>lib/bootstrap/js/bootstrap.min.js"></script>
 <script>
       $(document).ready(function(){
            $('#SelSize').change(function(){
                            var id=$(this).val();
                            $('#SelCat').html("<option value=''>Loading...</option>")
                            $.ajax({
                                  url: "index.php?component=catalogue&action=getcat&id="+id,
                                  cache: false,
                                  success: function(datares) {
                                    $('#SelCat').html(datares);
                                  }
                             }); 
            });
            $("#Filter").click(function(){
                var size = $('#SelSize').val();
                var cat = $('#SelCat').val();
                if(size=="")
                {
                    alert("please select size");
                }else if(cat=="")
                {
                    alert("please select category");
                }else
                {
                    $("#DisplayProducts").html("<img src='themes/admin/img/loading.gif' />")
                            $.ajax({
                                  url: "index.php?component=catalogue&action=products&cat="+cat+"&size="+size,
                                  cache: false,
                                  success: function(datares) {
                                    $('#DisplayProducts').html(datares);
                                  }
                             }); 
                }
            });
            
            $("#SearchBtn").click(function(){
                var search = $('#searchTxt').val();
                
                if(search=="")
                {
                    alert("please enter designno");
                }else if( $('#searchTxt').val().length < 2 )
                {
                    alert("please enter valid design no");
                }else
                {
                            $("#DisplayProducts").html("<img src='themes/admin/img/loading.gif' />")
                            $.ajax({
                                  url: "index.php?component=catalogue&action=products&s="+search,
                                  cache: false,
                                  success: function(datares) {
                                    $('#DisplayProducts').html(datares);
                                  }
                             }); 
                }
            });
            
            $("#ViewCart").click(function(){
               
                            $("#DisplayProducts").html("<img src='themes/admin/img/loading.gif' />")
                            $.ajax({
                                  url: "index.php?component=catalogue&action=viewcart",
                                  cache: false,
                                  success: function(datares) {
                                    $('#DisplayProducts').html(datares);
                                  }
                             }); 
               
            });
           $("#ClearCart").click(function(){
               
                            $("#CartItems").html("<img src='themes/admin/img/loading.gif' />")
                            $.ajax({
                                  url: "index.php?component=catalogue&action=cart&do=clear",
                                  cache: false,
                                  success: function(datares) {
                                    //$('#DisplayProducts').html(datares);
                                    $("#CartItems").html(datares.length);
                                  }
                             }); 
               
            });
           $('#CartAction').on('show.bs.modal', function (e) {
  
});

            
           $(".cart-item").click(function(){
                $("#CartAction #myModalLabel").html($(this).data("designno"));
                $("#CartAction #cart-item-qty").val($(this).data("qty"));
                $("#CartAction .cart-update-btn").val($(this).attr("title"));
                $("#CartAction .cart-delete-btn").val($(this).attr("title"));
                
           });
           $(".cart-update-btn").click(function(){
            var id = $(this).val();
            var val = $("#CartAction #cart-item-qty").val();
            
                $.ajax({
                                  url: "index.php?component=catalogue&action=cart&do=update&id="+id+"&qty="+val,
                                  dataType: "json",
                                  cache: false,
                                  success: function(datares) {
                                    //alert(datares);
                                    var htmlData;
                                    $.each(datares,function(key,val){
                                       var data = val;
                                         //$.each(data,function(key1,val1){
                                            htmlData+="<li>"+data["designno"]+"-"+data["qty"]+"</li>";
                                         //});
                                    });
                                    //$("#DW-Cart-Item").html(htmlData);
                                   // $("#CartItems").html(datares.length);
                                    alert("Item updated to cart");
                                  }
                             });
           });
        });
        </script>

</body>
</html>