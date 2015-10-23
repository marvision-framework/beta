<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////  Version 1 - 2015 //////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


		function no_space($val){
			$int = array(" ");
			$deb = array("");
			$val = str_replace($int,$deb,$val);
			return $val;
		}
		function Remp_SpCaract($txt){
			$int = array("é","è","ç","à","µ");
			$deb = array("e","e","c","a","u");
			$txt = str_replace($int,$deb,$txt); 
			return $txt;
		}

		function showAlert($txt,$type){
			$div = "<div id='divalert' class='alert alert-".$type." alert-dismissible fade in'><button onclick='closedivalert()' type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>";
			$result = $div."<p>".$txt."</p></div>";
			return $result;
		}
		function array_sort($array, $on, $order=SORT_ASC){//SORT_ASC OR SORT_DESC
		    $new_array = array();
		    $sortable_array = array();

		    if (count($array) > 0) {
		        foreach ($array as $k => $v) {
		            if (is_array($v)) {
		                foreach ($v as $k2 => $v2) {
		                    if ($k2 == $on) {
		                        $sortable_array[$k] = $v2;
		                    }
		                }
		            } else {
		                $sortable_array[$k] = $v;
		            }
		        }

		        switch ($order) {
		            case SORT_ASC:
		                asort($sortable_array);
		            break;
		            case SORT_DESC:
		                arsort($sortable_array);
		            break;
		        }

		        foreach ($sortable_array as $k => $v) {
		            $new_array[$k] = $array[$k];
		        }
		    }

		    return $new_array;
		}


		function uniord($u) {
		    // i just copied this function fron the php.net comments, but it should work fine!
		    $k = mb_convert_encoding($u, 'UCS-2LE', 'UTF-8');
		    $k1 = ord(substr($k, 0, 1));
		    $k2 = ord(substr($k, 1, 1));
		    return $k2 * 256 + $k1;
		}


		function is_arabic($str) {
		    if(mb_detect_encoding($str) !== 'UTF-8') {
		        $str = mb_convert_encoding($str,mb_detect_encoding($str),'UTF-8');
		    }
		 
		    preg_match_all('/.|\n/u', $str, $matches);
		    $chars = $matches[0];
		    $arabic_count = 0;
		    $latin_count = 0;
		    $total_count = 0;
		    foreach($chars as $char) {
		        //$pos = ord($char); we cant use that, its not binary safe 
		        $pos = uniord($char);
		        //echo $char ." --> ".$pos.PHP_EOL;

		        if($pos >= 1536 && $pos <= 1791) {
		            $arabic_count++;
		        } else if($pos > 123 && $pos < 123) {
		            $latin_count++;
		        }
		        $total_count++;
		    }
		    if(($arabic_count/$total_count) > 0.6) {
		        // 60% arabic chars, its probably arabic
		        return true;
		    }
		    return false;
		}

 		function datainverse($array){
 			$count = count($array);
 			$k = $count-1;
 			for ($i=0; $i < $count; $i++) { 
 				$data[$i] = $array[$k];
 				$k--; 
 			}
 			//die(var_dump($data));
 			return $data;
 		}

 		function toarray($val,$dir=null,$space=null){//toarray($val,'indir')
 			$space = (empty($space)) ? "," : $space ;
 			$dir = (empty($dir)) ? "dir" : $dir ;
 			$space = ((empty($space))AND(!empty($dir))AND(($dir != 'dir')OR($dir != 'indir'))) ? $dir : $space ;
 			if ($dir == "indir") { //code->sql
	 				for ($i=0; $i < count($val); $i++) {  
	 					if ($i == 0) {
	 						$filter = $val[$i];
	 					}else{
	 						$filter .= ",".$val[$i];
	 					}
	 				}

 				}else{//sql->code
 					$filter = explode($space, $val); 
 				}

 			//var_dump($filter);
 			//die();
 			return $filter; 
 		}

##################################################################################################
############## trie two array by date
##################################################################################################

	function Trie2Aarray($arr1,$arr2){ 
		$i=0;$j=0;
		if (!empty($arr1)) { 
			foreach ($arr1 as $key => $value) {
				$tb1[$i]['date'] = $key;
				$tb1[$i]['url'] = $value; 
				$i++;
			}
		}
		if (!empty($arr2)) { 
			foreach ($arr2 as $key => $value) {
				$tb2[$j]['date'] = $key;
				$tb2[$j]['url'] = $value;  
				$j++;
			}
		} 
		if (!empty($tb1)&&!empty($tb2)) {
			$data = array_merge($tb1,$tb2);
			$array = array_sort($data,'date', SORT_DESC);
		}else{ 
			if (!empty($tb1)) {$array = $tb1;}
			if(!empty($tb2)) {$array = $tb2;}
		}

		foreach ($array as $key => $value) {
			$result[$value['date']] = $value["url"];
		}
		//die(debug($result));
		return $result;
	}

 		function datarray($array,$type,$separ=null){ 
 			if (empty($separ)) {
	 				if ($type ==  "convert") { /// code --> mysql #datarray($array,"convert")
	 				$data = "";
					$x = 0; 
				    foreach($array as $name => $value) {
				    	$value = filterSouArray($value,'in');
				        $data .= "{ {$name} : {$value} }";
				        if($x < count($array)) {
				            $data .= ' , ';
				        }
				        $x++;
				    }
				    //die($data);
	 			}
	 			if ($type == "deconvert") { /// mysql --> code

	 				$table = array();
	 				$data = array();
	 				$filter = str_replace("{ ", "", $array);
	 				$filter = str_replace(" }", "", $filter);
	 				$filter = explode(" , ", $filter);
	 				for ($i=0; $i < count($filter); $i++) { 
	 					$table[$i] = explode(" : ", $filter[$i]);
	 					if (!empty($table[$i][1])) {
	 						$data[$table[$i][0]] = filterSouArray($table[$i][1],'out');
	 					}
	 					
	 				}

	 				
	 				//var_dump($data);
	 			} 
 			}else{

	 			if ($type == "deconvert") { /// mysql --> code //exmp: 1,2 ==> array("0"=>"1","1"=>"2")
 
	 				$data = explode(',', $array);

	 				
	 				//die(var_dump($data));
	 			}
	 			if ($type == "auto") { //if separ: -  //exmp: 1 - 2 ==> array("0"=>"1","1"=>"2")
 
	 				$data = explode($separ, $array);

	 				
	 				//die(var_dump($data));
	 			}
 			}

 			return $data;
 		}


 		function no_space_txt($val,$type=null){
 			$type = (empty($type)) ? "" : $type ;
 			if ($type != "br") {
				$val = str_replace(" ", "", $val);
 			}
				$val = str_replace("
", "", $val);

 			return $val;
 		}
 
 		function manyarray($array=array(),$limit=null){ 
			$result = new stdClass();
			$data = array();
	 		$result = array();
 			$k = 0;
	 		for ($i=0; $i < count($array); $i++) { 
	 				for ($j=0; $j < count($array[$i]); $j++) { 
		 				$data[$k] = $array[$i][$j];
		 				$k++;
		 			}
	 		}

	 		if (!empty($limit)) { 
 			$limit = ($limit > count($data)) ? count($data) : $limit ;
	 			for ($i=0; $i < $limit; $i++) { 
	 				$result[$i] = $data[$i];
	 			}
	 		}else{
	 			$result = $data;
	 		}
 			//die("count = ".count($array)."<br>".debug($array)."<br>".debug($data));
 			return $result;
 		}


 		function math_moy($val,$total){ 
			$result = ($val / $total) * 100;
 			return $result;
 		}


##################################################################################################
############## find dir folder content(folder/file)
##################################################################################################
	function Rdir($dir){
		//$dir = VENDOR.'/lib/lang';
			$i=0;
			if ($handle = opendir($dir)) {
				while (false !== ($entry = readdir($handle))) {
					if ($entry != "." && $entry != "..") {
						$folder[] = $entry;
						$i++;        
					}
				} 
				closedir($handle); 
			}
		return $folder;
	}

?>