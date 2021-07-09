<?  header('Content-type: text/json');
    $q->select(" * from `company` where `id` in ( select `company` from `relation` where `category`='".common::get_control_value("cat")."' )")
    ->run();
    
    $data = $q->get_selected();
    $data= array("companies"=>$data);
    echo json_encode($data);
?>