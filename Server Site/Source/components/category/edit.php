<?  common::user_access_only("admin");
        
    $q=new Query();
    $q->select()
    ->from('categories')
    ->where_equal_to(array('id'=>common::get_control_value('id')))
    ->limit(1)
    ->run();
    $data=$q->get_selected();
    
$q = new Query();
$q->select()
->from("maincategory")
->run();
$parents_cat =  $q->get_selected();
     if(isset($_POST['add']))
    {
        validate();
        if(form_validation::validate_fields())
        {
          
            $title=common::get_control_value("title");

            $descri=common::get_control_value("description");
            $icon=common::get_control_value("icon");
            $parent =common::get_control_value("parent");
           
           
            
            $q=new Query();
            $q->update("categories",array("title"=>$title,"description"=>$descri,"icon"=>$icon,"parent"=>$parent))
            ->where_equal_to(array("id"=>common::get_control_value("id")))
            ->run();
            common::set_message(3);
            common::redirect_to(common::get_component_link(array("category","add")));
        }
    }
?>