<?
$q = new Query();
$q->select()
->from("reviews")
->where_equal_to(array("company"=>common::get_control_value("id")))
->run();

$data = $q->get_selected();
?>