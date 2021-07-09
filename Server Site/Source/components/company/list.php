<?
$q =new Query();
$q->select()
->from("company")
->run();

$data = $q->get_selected();


?>