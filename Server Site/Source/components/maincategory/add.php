<?  common::user_access_only("admin");
$q->select()
->from("maincategory")
->run();
$data =  $q->get_selected();

    if(isset($_POST['add']))
    {
        validate();
        if(form_validation::validate_fields())
        {
          
            $title=common::get_control_value("title");

            $descri=common::get_control_value("description");
            $featureimage=common::get_control_value("icon");
           
           if($_FILES['featureimage']['size']>0)
            {
                $featureimage=$imgfun->upload_image_and_thumbnail('featureimage',120,80,'userfiles','contents',false);
            }
            
            $q=new Query();
            $q->insert_into("maincategory",array("title"=>$title,"description"=>$descri,"icon"=>$featureimage))
            ->run();
            common::set_message(3);
            common::redirect_to(common::get_component_link(array("maincategory","add")));
        }
    }
     ?>