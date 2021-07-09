<?php

$data = new Spreadsheet_Excel_Reader("ceramicindiadata.xls");
$sheet = 0;
?>

<?php 

$array = array();
		for($row=1;$row<=$data->rowcount($sheet);$row++) {
			
		
					
					
                    $array[] = array("company"=>$data->val($row,1,$sheet),"address"=>$data->val($row,2,$sheet),"city"=>$data->val($row,3,$sheet),
                    "phone1"=>$data->val($row,4,$sheet),"key_person1"=>$data->val($row,5,$sheet),"key_person2"=>$data->val($row,6,$sheet),"fax"=>$data->val($row,7,$sheet),
                    "website"=>$data->val($row,8,$sheet),"email1"=>$data->val($row,9,$sheet),"content"=>$data->val($row,10,$sheet),"category"=>$data->val($row,11,$sheet));
                    
					//if ($val=='') { $val="&nbsp;"; }
					//else { 
					//	$val = htmlentities($val); 
                    //}
						
				
			
		}
  foreach($array as $val)
  {
    $q = new Query();
        $q->insert_into("company",$val)
        ->show()
        ->run();
        
        $id = $q->get_inserted_id();
      $q = new Query();  
        $q->insert_into("relation",array("company"=>$id,"category"=>$val["category"]))
        ->show()
        ->run();
        
        
  }
 ?>

