<?  common::user_access_only("admin");
    $id=common::get_control_value('id');
    if($id!="")
    {
        $q->delete("categories")
        ->where_equal_to(array("id"=>$id))
        ->run();
        common::redirect_to(common::get_component_link(array("category","add")));
    }
?>