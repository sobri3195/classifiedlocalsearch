<?
class sqlfun
{
		public static function checklogin()
		{
			if(isset($_SESSION["AccessToken"]) && $_SESSION["AccessToken"]!="")
			{
				
			}else
			{
				header('location:index.php',true);
			}
		}
		public static function set_message($type,$message)
		{
			
			switch($type)
			{
				case "error":
					$_SESSION["message"]="<div class='error'>".$message."</div>";
					break;
				case "success";
					$_SESSION["message"]="<div class='success'>".$message."</div>";
					break;
				case "worning";	
					$_SESSION["message"]="<div class='worning'>".$message."</div>";
					break;	
				case "alert";
					$_SESSION["message"]="<div class='alert'>".$message."</div>";
					break;
				
			}
		}
		public static function get_message()
		{
			$a=$_SESSION["message"];
			unset($_SESSION["message"]);
			return $a ;
			
		}
		public static function ge_fetch_array($sql)
		{
			$res=mysql_query($sql) or die("query is wrong");
			$table = array();
			if(mysql_num_rows($res)>0)
			{
				
						$i = 0;
        				while($table[$i] = mysql_fetch_array($res)) 
            				$i++;
        				unset($table[$i]);                                                                                  
					
			}
				
			
				mysql_free_result($res);
				return $table;
			
		}
		public static function ge_fetch_assoc($sql)
		{
			$res=mysql_query($sql) or die("query is wrong");
			$table = array();
			if(mysql_num_rows($res)>0)
			{
				
						$i = 0;
        				while($table[$i] = mysql_fetch_assoc($res)) 
            				$i++;
        				unset($table[$i]);                                                                                  
					
			}
				
			
				mysql_free_result($res);
				return $table;
			
		}
		public static function ge_fetch_row($sql)
		{
			$res=mysql_query($sql) or die("query is wrong");
			$table = array();
			if(mysql_num_rows($res)>0)
			{
        				$table = mysql_fetch_array($res);
			}
				mysql_free_result($res);
				return $table;
			
		}
		
		public static function ge_insert($table, $inserts) 
		{
			$values = array_map('mysql_real_escape_string', array_values($inserts));
			$keys = array_keys($inserts);
			//echo 'INSERT INTO `'.$table.'` (`'.implode('`,`', $keys).'`) VALUES (\''.implode('\',\'', $values).'\')';   
			return self::ge_query('INSERT INTO `'.$table.'` (`'.implode('`,`', $keys).'`) VALUES (\''.implode('\',\'', $values).'\')');
		}
		public static function ge_update($table,$array,$Pkey,$PKval)
		{
			foreach($array as $key => $value) {
    			$update.="`".trim($key)."`='".trim($value)."',";    
			}
			$update=substr($update,0,strlen($update)-1);
			return self::ge_query("UPDATE `".$table."` SET ".$update." WHERE `".$Pkey."`='".$PKval."'");
		}
		public static function ge_update_cond($table,$array,$cond)
		{
			foreach($array as $key => $value) {
    			$update.="`".trim($key)."`='".trim($value)."',";    
			}
			$update=substr($update,0,strlen($update)-1);
			return self::ge_query("UPDATE `".$table."` SET ".$update." WHERE ".$cond);
		}
		public static function ge_delete($table,$cond)
		{
			foreach($array as $key => $value) {
    			$update.="`".trim($key)."`='".trim($value)."',";    
			}
			$update=substr($update,0,strlen($update)-1);
			return self::ge_query("DELETE FROM `".$table." WHERE ".$cond);
		}
		public static function ge_table($table)
		{
			$sql = "SHOW COLUMNS FROM $table";
			$ts = mysql_query($sql);
			$cts = mysql_num_rows($ts);
			while($ats = mysql_fetch_array($ts))
			{
				if($ats['Key'] == "PRI")
				{
					$Primkey=$ats['Field'];
				}
			}
			
			echo "<table width='100%'>";
			$res=mysql_query("Select * from `$table`");
			if(mysql_num_rows($res)>0)
			{
				echo "<tr>";
				
					for($i=0;$i<mysql_num_fields($res);$i++)
						echo "<th>". mysql_field_name($res,$i)."</th>";
				
					echo "<th><a href='?key=$Primkey&action=edit' >EDIT</a></th><th><a href='?key=$Primkey&action=delete'>Delete</a></th>";
				echo "</tr>";

				
				echo "<tr>";
				while($array=mysql_fetch_array($res))
				{
					for($i=0;$i<mysql_num_fields($res);$i++)
						echo "<td>".$array[$i]."</td>";
				}
				echo "</tr>";
			}
			echo "<table>";	
		}
		
		public static function secureGET($key)
    	{
        	$_GET[$key] = htmlspecialchars(stripslashes($_GET[$key]));
        	$_GET[$key] = str_ireplace("script", "blocked", $_GET[$key]);
       		$_GET[$key] = mysql_escape_string($_GET[$key]);
			$_GET[$key] = mysql_real_escape_string($_GET[$key]);
			$_GET[$key] = preg_replace("/[^a-zA-Z0-9 s]/", "", $_GET[$key]);
			
        	return $_GET[$key];
    	}
   
    	public static function securePOST($key)
    	{
        	$_POST[$key] = htmlspecialchars(stripslashes($_POST[$key]));
       	 	$_POST[$key] = str_ireplace("script", "blocked", $_POST[$key]);
        	$_POST[$key] = mysql_escape_string($_POST[$key]);
			$_POST[$key] = preg_replace("/[^a-zA-Z0-9 s]/", "", $_POST[$key]);
        	return $_POST[$key];
    	}
		
		public static function secureREQUEST($key)
    	{
        	$_REQUEST[$key] = htmlspecialchars(stripslashes($_REQUEST[$key]));
       	 	$_REQUEST[$key] = str_ireplace("script", "blocked", $_REQUEST[$key]);
        	$_REQUEST[$key] = mysql_escape_string($_REQUEST[$key]);
			$_REQUEST[$key] = preg_replace("/[^a-zA-Z0-9 s]/", "", $_REQUEST[$key]);
        	return $_REQUEST[$key];
    	}
		
		public static function removeSpecChar($val)
		{
			$val = preg_replace("/[^a-zA-Z0-9 ._s]/", "", $val);
			return $val;
		}
		public static function ge_query($string)
		{
			
			$result = mysql_query($string);
		
			if ($result == false)
			{
				error_log("SQL error: ".mysql_error()."\n\nOriginal query: $string\n");
				// Remove following line from production servers 
				die("SQL error: ".mysql_error()."\b<br>\n<br>Original query: $string \n<br>\n<br>");
			}
			return $result;
		}

		public static function ge_fetch_list($sql)
		{
			// this public static function require presence of good_query() public static function
			$result = self::ge_query($sql);
			
			if($lst = mysql_fetch_row($result))
			{
				mysql_free_result($result);
				return $lst;
			}
			mysql_free_result($result);
			return false;
		}

		public static function ge_value($sql)
		{
			// this public static function require presence of good_query_list() public static function
			$lst = self::ge_fetch_list($sql);
			return is_array($lst)?$lst[0]:false;
		}
		public static function ge_values($sql)
		{
			// this public static function require presence of good_query_list() public static function
			$lst = self::ge_fetch_list($sql);
			return is_array($lst)?$lst:false;
		}
		
		public static function ge_generate_id($prefix,$length = 5)
		{
		
		  $password = str_replace(' ', '', $prefix);
		  $possible = '0123456789bcdfghjkmnpqrstvwxyz'; 
			
		  $i = 0; 
		  while ($i < $length)
			{ 
			$password .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			$i++;
			}
		
		  return $password;
		
		}
		
		public static function ge_checkfild($table,$fild,$value)
		{
			global $sqlfun;
            
            $res=$sqlfun->ge_value("select COUNT(*) from `".$table."` where `".$fild."`='".$value."'");
			if($res)
				return false;
			else
				return true;
		}
		
		public static function ge_mkdir($path)
		{
			if(is_file($path) || file_exists($path))
			{
				return false;
			}else
			{
				mkdir($path);
				return true;
			}
		}
		
		public static function display_children_menu($parent, $level) 
		{
	
    		$result = mysql_query("SELECT a.`id`, a.`name`, a.`alias`,a.`order`, Deriv1.Count FROM `product_category` a  LEFT OUTER JOIN (SELECT `parent`, COUNT(*) AS Count FROM `product_category` GROUP BY `parent`) Deriv1 ON a.`id` = Deriv1.`parent` WHERE a.`parent`=" . $parent);
    
			while ($row = mysql_fetch_assoc($result)) {
				$co=0;
					$node="";
					while($co<=$row["order"])
					{
						$co++;
						$node.="_";
					}
				if ($row['Count'] > 0) {
					
					echo "<option value='$row[id]_$co'>".$node.$row["alias"]."</option>";
					self::display_children_menu($row['id'], $level + 1);
					
				} elseif ($row['Count']==0) {
					echo "<option value='$row[id]_$co'>".$node.$row['alias']."</option>";
				} else;
			}
    
		}
		
		public static function display_children($parent, $level) 
		{
	
    		$result = mysql_query("SELECT a.id, a.name, a.alias, Deriv1.Count FROM `product_category` a  LEFT OUTER JOIN (SELECT parent, COUNT(*) AS Count FROM `product_category` GROUP BY parent) Deriv1 ON a.id = Deriv1.parent WHERE a.parent=" . $parent);
		echo "<ul>";
		while ($row = mysql_fetch_assoc($result)) {
			if ($row['Count'] > 0) {
				echo "<li><a href='" . $row['name'] . "'>" . $row['alias'] . "</a>";
				self::display_children($row['id'], $level + 1);
				echo "</li>";
			} elseif ($row['Count']==0) {
				echo "<li><a href='" . $row['name'] . "'>" . $row['alias'] . "</a></li>";
			} else;
		}
		echo "</ul>";
	}
	
		public static function getTimeSpan($val)
    {
            $days = floor($val / (60 * 60 * 24));
			$remainder = $val % (60 * 60 * 24);
			$hours = floor($remainder / (60 * 60));
			$remainder = $remainder % (60 * 60);
			$minutes = floor($remainder / 60);
			$seconds = $remainder % 60;
			
			if($days > 0)
			return date('F d Y', $val);
			elseif($days == 0 && $hours == 0 && $minutes == 0)
			return "few seconds ago";		
			elseif($days == 0 && $hours == 0)
			return $minutes.' minutes ago';
			else
			return "few seconds ago";
    }

	
		
		
}
?>
