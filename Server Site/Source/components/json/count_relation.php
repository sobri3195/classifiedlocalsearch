<?  header('Content-type: text/json');
    $q->select()
    ->from("relation")
    ->run();
    
    $data = $q->get_selected();
    $data= array("relations"=>count($data));
    echo json_encode($data);
?>