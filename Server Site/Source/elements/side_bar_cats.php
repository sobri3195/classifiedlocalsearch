<div class="inner-panel">
            <ul class="list-group">
            <li href="#" class="list-group-item active">
   Products
  </li>
  <? 
      $q = new Query();
    $q->select()
    ->from("categories")
    ->order_by("title")
    ->run();
    
    $categories = $q->get_selected();
  
  foreach($categories as $cats){
  ?>
  <li class="list-group-item"><a href="<?=common::get_component_link(array("tilesstore","company"))."&ref=".$cats["id"]."&products=".common::seoUrl($cats["title"]); ?>" title="<?=$cats["title"]; ?>"><?=$cats["title"]; ?></a></li>
  <?  
  } ?>
  

</ul>
</div>

<div class="inner-panel">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <iframe src="plugins/tweets/index.html" width="100%" height="260px" frameBorder="0" scrolling="no" ></iframe>
                        </div>
                    </div>
                </div>
<div class="inner-panel">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <iframe src="plugins/mailchimp-api-master/subscribe.php" width="100%" height="160px" frameBorder="0" scrolling="no"  ></iframe>
                        </div>
                    </div>
                </div>