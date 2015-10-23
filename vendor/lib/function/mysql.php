<?php
  
	 #
	 # include all model(get all file in model folder)  
	 # if not exist tabel in data so addet in my database */
		ChekDATA();
		ChekTABDATA();

	 	function ChekDATA(){
			$dir = WEB.'/model';
			if ($handle = opendir($dir)) {
				while (false !== ($entry = readdir($handle))) {
					if ($entry != "." && $entry != "..") {
						$file = explode('.', $entry); 
						if ($file[1] == 'php') {
								$title = lcfirst($file[0]).'s';  
								include $dir.'/'.$entry;
								if (!empty($model)) {
									$cont = new Model; 
									$cont->CreatTab($title,$model); 
								}
						}
						        
					}
				} 
				closedir($handle); 
			}
	 	}
	 	function ChekTABDATA(){

			$control = new Controller; 
			$model = new Model;  
			$dbTab = (!empty($model->findTab()))? $model->findTab() : array();
			foreach ($dbTab as $key => $tab) {
				$db = $tab->TABLE_NAME;
				if (substr($db, -1) == "s") {
					$db = rtrim($db,"s");
					$thisdb = ucfirst($db);
					$arraycond = array();
					$rootsrc = "web/model/backup.sql/".$db.".yml";
					$defdata = loadYmlFile($rootsrc); 
					if (!empty($defdata)&&($defdata[0] != $rootsrc)) {
						foreach ($defdata as $key => $data) {
							foreach ($data as $k => $value) {
								if ($k != 'id') {
									$arraycond[$k] = $value;
								}
								
							} 
									$control->loadModel($thisdb); 
									$this_data = $control->$thisdb->findFirst(array('conditions' => $arraycond));
									if (empty($this_data->id)) {
										$control->$thisdb->add($arraycond); 
									}
						}
					}
				}
			}
	 	}
	 ##########################################################################################
	 ############## Get Model list and data

	 	function GetModelSite($type=null,$tb=null){
	 		$type = (!empty($type)) ? $type : "list" ;
			$dir = WEB.'/model';
			if ($handle = opendir($dir)) {
				while (false !== ($entry = readdir($handle))) {
					if ($entry != "." && $entry != "..") {
						$file = explode('.', $entry); 
						if ($file[1] == 'php') {
							$title = lcfirst($file[0]).'s';  
							if ($type == "list") {
							 	$tab[$title] = $file[0];
							 }else{
								include $dir.'/'.$entry;
								if (!empty($model)) {
								    $tab[$title]= $model;
									$cont = new Model; 
									$cont->CreatTab($title,GetModelSite("data",$tab)); 
								    if (!empty($tb)AND($file[0] == $tb)) {
								    	$onetab = $model;
								    }
								}
							}
						}
						        
					}
				} 
				closedir($handle); 
			}

	 		if (!empty($tab)) {
	 			if ((!empty($tb))AND(!empty($onetab))) {
	 				$tab = $onetab;
	 			}
	 				return $tab;
				//debug($tab); 
	 			//die("<br>this is mysql function to fixed data sql problem ...");
	 		}else{
	 			return array();
	 		}
	 	}


	 ##########################################################################################
	 ############## Get default database
/*
	 	function GetDefData(){
	 		$dir = WEB.'/model';
			if ($handle = opendir($dir)) {
				while (false !== ($entry = readdir($handle))) {
					if ($entry != "." && $entry != "..") {
						$file = explode('.', $entry);  
						//debug(ucfirst($file[0]));
						if ($file[1] == 'php') {
								$title = lcfirst($file[0]).'s'; 
							if (file_exists($dir.'/'.$title.".xml")) {
								$defdata = simplexml_load_file($dir.'/'.$title.".xml");
								$dataxml = $defdata->database->table->column;

								//debug($defdata->database->table->column);
							}
								
						}
						        
					}
				}  
				closedir($handle); 
			}
	 	}

*/
   /* $def = array();  
    $produitType = (simplexml_load_file("produitType.xml")) ? simplexml_load_file("produitType.xml") : $def ; 
    return $produitType->type;*/


 