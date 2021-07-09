<?  common::user_access_only("admin");
    $q=new Query();
    $q->select()
    ->from("user")
    ->run()
    ;

    $data=$q->get_selected();
?>