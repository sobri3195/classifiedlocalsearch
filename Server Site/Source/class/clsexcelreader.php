<?
class commonExcel
{
    function checkExtension($filepath)
    {
        $f=pathinfo($filepath);
        $ext=$f['extension'];
        if($ext!="" || $ext=="csv" || $ext=="xls" || $ext=="xlsx")
        {
            return true;
        }else
        {
            return false;
        }
        
    }
    function tablearray()
    {
        return $table=array("madhelper");
    }
    
    function fieldarray($table)
    {
        
        switch($table)
        {
            case "medhelper":
               return array('type','Scheduled Time','Actual Time','Actual Dosage','Scheduled Dosage','Medication','Prescription');
               break;
        }
        
    }
    function fieldvalification($fieldarray,$fiexarray)
    {
        $flag=array();
        foreach($fieldarray as $field)
        { 
            foreach($fiexarray as $ff)
            {
                if( strtolower($ff)==strtolower($field))
                {
                  $flag[]=$field;  
                }
            }
        }
        if(count($flag)==count($fieldarray))
        {
            return true;
        }else
        {
            return false;
        }
    }
    function selectByField($fieldlist,$table)
    {
        if(is_array($fieldlist))
        {
            $tbl=$this->fieldarray($table);
            return $this->fieldvalification($fieldlist,$tbl);
        }else
        {
            return false;
        }
    }
}
?>