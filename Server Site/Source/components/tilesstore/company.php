<?
$q->select()
->from("categories")
->where_equal_to(array("id"=>common::get_control_value("ref")))
->limit(1)
->run();
$category = $q->get_selected();


$page=1;
if(isset($_GET['go']))
        $page=common::get_control_value('go');

$q = new Query();
if($_REQUEST["top"]=="true")
{   
    
           
            $q->select(" * from `company` where `id` in (select `company` from `relation` where `category`=".stripslashes(common::get_control_value("ref")).") and top=1 order by `order`")
            ->limit(DEFAULT_PAGE_SIZE)
            ->page($page)
            ->run();

}else if($_REQUEST["trust"]=="true")
{   
    
           
            $q->select(" * from `company` where `id` in (select `company` from `relation` where `category`=".stripslashes(common::get_control_value("ref")).") and special=1 order by `order`")
            ->limit(DEFAULT_PAGE_SIZE)
            ->page($page)
            ->run();

}elseif($_REQUEST["order"]!="")
{   
    
           
            $q->select(" * from `company` where `id` in (select `company` from `relation` where `category`=".stripslashes(common::get_control_value("ref")).") and `company` REGEXP '^[".common::get_control_value("order")."].*$'")
            ->limit(DEFAULT_PAGE_SIZE)
            ->page($page)
            ->run();

}else if($_REQUEST["txtsearch"]!="")
{
    $q->select()
->from("company")
->where_in(array("id"=>"select `company` from `relation` where `category`=".stripslashes(common::get_control_value("ref")).""))
->where_like_both(array("company"=>common::get_control_value("txtsearch")))
->order_by("`top`,`special` DESC")
->limit(DEFAULT_PAGE_SIZE)
->page($page)
->run();

}else
{

$q->select()
->from("company")
->where_in(array("id"=>"select `company` from `relation` where `category`=".stripslashes(common::get_control_value("ref")).""))
->order_by("`special` DESC")
->limit(DEFAULT_PAGE_SIZE)
->page($page)
->run();
    
}


$cpage=$q->get_page();
$gpages=$q->get_pages();
$data = $q->get_selected();

 
?>