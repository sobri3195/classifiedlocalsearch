<?  common::user_access_only("admin");
        

    $q=new Query();
    $q->select()
    ->from('maincategory')
    ->where_equal_to(array('id'=>common::get_control_value('id')))
    ->limit(1)
    ->run();
    $data=$q->get_selected();
    if(isset($_POST['add']))
    {
        validate();
        if(form_validation::validate_fields())
        {
            $imgfun=new imagecomponent();
            $title=common::get_control_value("title");
            $descri=common::get_control_value("description");
            $featureimage=$data['icon'];
            if($_FILES['featureimage']['size']>0)
            {
                $featureimage=$imgfun->upload_image_and_thumbnail('featureimage',120,80,'userfiles','contents',false);
            }
           
            
            $q=new Query();
            $q->update("maincategory",array("title"=>$title,"description"=>$descri,"icon"=>$featureimage))
            ->where_equal_to(array('id'=>common::get_control_value('id')))
            ->run();
            common::set_message(3);
            common::redirect_to(common::get_component_link(array("maincategory","add")));
        }
    }
?>