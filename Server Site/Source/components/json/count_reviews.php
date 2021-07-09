<?  header('Content-type: text/json');
    $q->select()
    ->from("reviews")
    ->where_equal_to(array("company"=>common::get_control_value("id"),"approved"=>"1"))
    ->run();
    
    $data = $q->get_selected();
    $data= array("reviews"=>count($data));
    echo json_encode($data);
?>