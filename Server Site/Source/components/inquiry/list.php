<?
$q = new Query();
$q->select()
->from("enquries")
->where_equal_to(array("company_id"=>common::get_control_value("id")))
->run();

$data = $q->get_selected();
?>