<?  common::user_access_only("admin");
    $page=1;
    if(isset($_GET['go']))
        $page=common::get_control_value('go');
    $q=new Query();
    $q->select()
    ->from("categories")
    
    ->where_like(array("title"=>common::get_control_value("s")))
    ->limit(DEFAULT_PAGE_SIZE)
    ->page($page)
    ->run()
    ;
    $cpage=$q->get_page();
    $gpages=$q->get_pages();
    $data=$q->get_selected();
?>