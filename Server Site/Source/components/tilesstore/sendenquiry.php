<?
     if(isset($_POST['refid']))
    {
        validate();
        if(form_validation::validate_fields())
        {
          $q = new Query();
          $q->select()
          ->from("company")
          ->where_equal_to(array("id"=>common::get_control_value("refid")))
          ->limit(1)
          ->run();
          $data = $q->get_selected();
          
            $name=common::get_control_value("name");

            $email=common::get_control_value("email");
            $phone=common::get_control_value("phone");
           $company=common::get_control_value("company");
           $address=common::get_control_value("address");
           $city=common::get_control_value("city");
           $state=common::get_control_value("state");
           $subject=common::get_control_value("subject");
           $message=common::get_control_value("message");
           $date = date("Y-m-d");
           
           $q->insert_into("enquries",array("company_id"=>$data["id"],"name"=>$name,"email"=>$email,"phone"=>$phone,"address"=>$address,"city"=>$city,"state"=>$state,"company"=>$company,"subject"=>$subject,"message"=>$message,"date"=>$date))
           ->run();
           $orderNo = $q->get_inserted_id();
           
                       $message = "<html>
            <head>
            </head>
            <body>
<strogn>Products Order </strong><br />                 
--------------------------------------------------<br />
Dear ".$data["company"].",<br /><br />

You get an order through Online Web Application,<br />

Your order information:<br />

<strong>Tiles Store Ref No. : #".$orderNo."</strong>
<br /><br />
Order detail:<br /><br />

Full Name : $name <br />
Email ID : $email <br />
Mobile No.: $phone <br />
Order No.: #".$orderNo." <br />
City : $city <br />
State : $state <br />
Subject : $subject <br />
Message : $message <br />
<br />
<br /><br />
If you have any comments or suggestions for us, please reply to ".COMPANY_EMAIL." . We value your feed back.<br />

Kindest Regards,<br />
--------------------------------------------------<br />
I.T. Department<br />
--------------------------------------------------<br />
<span style='font-size:9px'>This products is powered by www.tilesstore.in</span>
            </body>
            </html>";


$repmessage = "<html>
            <head>
            </head>
            <body>
<strogn>Products Order </strong><br />                 
--------------------------------------------------<br />
Dear ".$name.",<br /><br />

Your order is received by ".$data["company"].",<br />

Our marketing team will contact you soon.<br />
Your order information:<br />

<strong>Order No.:".$res."</strong>
<br /><br />
<br /><br />
If you have any comments or suggestions for us, please reply to ".COMPANY_EMAIL.". We value your feed back.<br />

Kindest Regards,<br />
--------------------------------------------------<br />
I.T. Department<br />
".COMPANY_NAME."<br />
--------------------------------------------------<br />
<span style='font-size:9px'>This products is powered by www.tilesstore.in</span>
            </body>
            </html>";

           
$reaply =           common::send_mail($data["email"],"TILES STORE ENQUIRY MAIL",$message);
if($reply)
{
    common::set_message(204,"Order Send Successfully");
    common::send_mail($email,"TILES STORE ENQUIRY MAIL",$repmessage);
       
   
}else
{
    common::set_message(205,"Error in send order. Please try again");
}         
            
            if ( common::do_show_message() ) {
		          echo common::show_message();	
            }
        }
    }
?>