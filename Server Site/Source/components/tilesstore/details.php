<?
$q->select()
->from("company")
->where_equal_to(array("id"=>common::get_control_value("ref")))
->limit(1)
->run();

$data = $q->get_selected();
?>