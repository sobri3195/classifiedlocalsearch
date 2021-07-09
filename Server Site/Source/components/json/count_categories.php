<?  header('Content-type: text/json');
    $q->select()
    ->from("categories")
    ->where_equal_to(array("parent"=>$_REQUEST["id"]))
    ->run();
    
    $data = $q->get_selected();
    $data= array("categories"=>count($data));
    echo json_encode($data);
?>