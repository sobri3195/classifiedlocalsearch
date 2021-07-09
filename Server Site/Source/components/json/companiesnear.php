<?  header('Content-type: text/json');
    $q->select(" * from `company` where id in (select `company` from `relation` where `category`='".common::get_control_value("cat")."') AND latitude > ".common::get_control_value("colx1")." AND latitude < ".common::get_control_value("colx2")." AND longitude < ".common::get_control_value("coly1")." AND longitude > ".common::get_control_value("coly2")."  AND latitude!='' and longitude!='' ORDER BY `order`")
    ->run();
    
    $data = $q->get_selected();
    $data= array("companies"=>$data);
    echo json_encode($data);
?>