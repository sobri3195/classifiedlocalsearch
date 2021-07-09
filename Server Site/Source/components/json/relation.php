<?   header('Content-type: text/json');
    $q->select()
    ->from("relation")
    ->run();
    
    $data = $q->get_selected();
    $data= array("relations"=>$data);
    echo json_encode($data);
?>