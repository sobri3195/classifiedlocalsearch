<?  common::user_access_only("admin");
    $id=common::get_control_value('id');
    if($id!="")
    {
        $q->delete("company")
        ->where_equal_to(array("id"=>$id))
        ->run();
        $ids = $q->get_deleted();
        if($ids)
        {
            $q->delete("relation")
            ->where_equal_to(array("company"=>$id))
            ->run();
        }
        common::redirect_to(common::get_component_link(array("company","list")));
    }
    
?>