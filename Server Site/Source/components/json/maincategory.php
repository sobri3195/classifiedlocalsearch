<?   header('Content-type: text/json');
    $q->select()
    ->from("maincategory")
    ->run();
    
    $data = $q->get_selected();
    $data= array("categories"=>$data);
    echo json_encode($data);
?>