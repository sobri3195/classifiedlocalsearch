<?
common::user_access_only("admin");
if( common::get_control_value("id")!="" )
{
    $q = new Query();
    $q->delete("user")
    ->where_equal_to(array("id"=>common::get_control_value("id")))
    ->run();
    
    common::redirect_to(common::get_component_link(array("user","add")));
}
?>