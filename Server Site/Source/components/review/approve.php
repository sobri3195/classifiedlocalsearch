<?
if($_REQUEST["id"]!="" && $_REQUEST["act"]!="")
{
    $q = new Query();
    $q->update("reviews",array("approved"=>common::get_control_value("act")))
    ->where_equal_to(array("id"=>common::get_control_value("id")))
    ->run();
    
    
}
?>