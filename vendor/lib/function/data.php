<?php

################################################# upload files
		 //update pic profil
				
		function UploadImage($file,$folderUpload,$type=null,$size=null,$TypeCrypt=null){
			//  $_FILES['file']['name'] 
			$result = array(); 
			$ErrorUpload 	= "";
			$MsgUpload 		= "";
			$size 			= (empty($size)) ? "5" : $size ; /// 5Mbit : 1Mbit = 1048576bit
			$type 			= (empty($type)) ? "all" : $type ;
			$TypeCrypt 		= (empty($type)) ? "default" : $TypeCrypt ;
			$maxsize		= $size * 1048576;
			if ($type == "all") { $file_permition = "/.(gif|jpg|jpeg|png)$/i"; }
			if ($type == "jpg") { $file_permition = "/.(jpg|jpeg)$/i"; }
			//die($folderUpload);
				if(strpos($_FILES[$file]['type'], 'image') !== false){
					$kaboom = array();
					$img_data_param = array();

					$img_data_param['name'] 		= $_FILES[$file]["name"]; // The file name
					$img_data_param['name_f'] 		= preg_replace('#[^a-z.0-9]#i', '', $img_data_param['name']); // filter the $filename
					$img_data_param['type'] 		= $_FILES[$file]["type"]; // The type of file it is
					$img_data_param['size'] 		= $_FILES[$file]["size"]; // File size in bytes
					$img_data_param['errorMsg'] 	= $_FILES[$file]["error"]; // 0 for false... and 1 for true
					$kaboom 						= explode(".", $img_data_param['name_f']); // Split file name into an array using the dot
					$img_data_param['name_e'] 		= $kaboom[0];
					$img_data_param['namecrypt']	= NumedFile($img_data_param['name_e'],$TypeCrypt);
					$img_data_param['extension'] 	= end($kaboom); // Now target the last array element to get the file extension
					$img_info 						= getimagesize($_FILES[$file]["tmp_name"]);
					$img_data_param['width'] 		= $img_info[0];// px
					$img_data_param['height'] 		= $img_info[1];// px
					$img_data_param['newname']		= $img_data_param['namecrypt'].".".$img_data_param['extension'];

					if (preg_match($file_permition, $img_data_param['name_f']) ) {
						if($img_data_param['size'] < $maxsize) { // if file size is larger < 5 Megabytes 
							if (!file_exists($folderUpload)) {mkdir($folderUpload,0777); }
							move_uploaded_file($_FILES[$file]['tmp_name'], $folderUpload.DS.$img_data_param['newname']);
							$MsgUpload = "L'image a bien été uploadé ";
							//debug($img_data_param);
							//die();
							//debug($_FILES);
						}else { $ErrorUpload = "ERROR: Your file was larger than ".$size." Megabytes in size.";}
					} else { $ErrorUpload = "ERROR: Your Picture Format was not Accepted";}// This condition is only if you wish to allow uploading of specific file types  
			}else{ $ErrorUpload = "ERROR: This File was not Picture";} 

			$result['error'] 	= $ErrorUpload;
			$result['msg'] 		= $MsgUpload;
			$result['data'] 	= $img_data_param;
			return $result;
		}


		 //update list pic
				
		function listUploadImage($file,$folderUpload,$type=null,$size=null,$TypeCrypt=null){
			//  $_FILES['file']['name'] 
			$result = array(); 
			$ErrorUpload 	= array();
			$MsgUpload 		= "";
			$size 			= (empty($size)) ? "5" : $size ; /// 5Mbit : 1Mbit = 1048576bit
			$type 			= (empty($type)) ? "all" : $type ;
			$TypeCrypt 		= (empty($type)) ? "default" : $TypeCrypt ;
			$maxsize		= $size * 1048576;
			if ($type == "all") { $file_permition = "/.(gif|jpg|jpeg|png)$/i"; }
			if ($type == "jpg") { $file_permition = "/.(jpg|jpeg)$/i"; }
			//die($folderUpload);
				
		    foreach($_FILES[$file]["tmp_name"] as $key=>$tmp_name){

				if(strpos($_FILES[$file]['type'][$key], 'image') !== false){
					$kaboom = array();
					$img_data_param = array();

					$img_data_param['name'] 		= $_FILES[$file]["name"][$key]; // The file name
					$img_data_param['name_f'] 		= preg_replace('#[^a-z.0-9]#i', '', $img_data_param['name']); // filter the $filename
					$img_data_param['type'] 		= $_FILES[$file]["type"][$key]; // The type of file it is
					$img_data_param['size'] 		= $_FILES[$file]["size"][$key]; // File size in bytes
					$img_data_param['errorMsg'] 	= $_FILES[$file]["error"][$key]; // 0 for false... and 1 for true
					$kaboom 						= explode(".", $img_data_param['name_f']); // Split file name into an array using the dot
					$img_data_param['name_e'] 		= $kaboom[0];
					$img_data_param['namecrypt']	= NumedFile($img_data_param['name_e'],$TypeCrypt);
					$img_data_param['extension'] 	= end($kaboom); // Now target the last array element to get the file extension
					$img_info 						= getimagesize($_FILES[$file]["tmp_name"][$key]);
					$img_data_param['width'] 		= $img_info[0];// px
					$img_data_param['height'] 		= $img_info[1];// px
					$img_data_param['newname']		= $img_data_param['namecrypt'].".".$img_data_param['extension'];

		                $file_name=$img_data_param['name'];
		                $file_tmp=$_FILES[$file]["tmp_name"][$key];
		                $ext=pathinfo($file_name,PATHINFO_EXTENSION);
		                
					if (preg_match($file_permition, $img_data_param['name_f']) ) {
						if($img_data_param['size'] < $maxsize) { // if file size is larger < 5 Megabytes 
							if (!file_exists($folderUpload)) {mkdir($folderUpload,0777); }
				                    if(!file_exists($folderUpload."/".$img_data_param['newname'])){
				                        move_uploaded_file($file_tmp=$_FILES[$file]["tmp_name"][$key],$folderUpload.DS.$img_data_param['newname']);
				                    }else{
				                        $filename=basename($file_name,$ext);
				                        $newFileName=$img_data_param['newname'].time().".".$ext;
				                        move_uploaded_file($file_tmp=$_FILES[$file]["tmp_name"][$key],$folderUpload.DS.$newFileName);
				                    }
								}else { $ErrorUpload = "ERROR: Your file was larger than ".$size." Megabytes in size.";}
							} else { $ErrorUpload = "ERROR: Your Picture Format was not Accepted";}// This condition is only if you wish to allow uploading of specific file types  
						}else{ $ErrorUpload = "ERROR: This File was not Picture";} 

			$result['error'][] 	= $ErrorUpload;
			$result['msg'][] 	= $MsgUpload; 
			$result['data'][] 	= $img_data_param;
		            } 
			return $result;
		}

###########################################################################################

		function NumedFile($name,$TypeCrypt=null){
			$TypeCrypt = (empty($TypeCrypt)) ? "default" : $TypeCrypt ;

			if ($TypeCrypt == "default") {
				$name   = md5($name).date("Ysij");
				$result = $name;
			}
			return $result;
		}
 		
 		function mkfile($dir,$type=null){
 			$result = false;
 			$type = (empty($type)) ? "date" : $type ;
 			if ($type == "date") {
 				$listFile = array(date("Y"),date("Y/m"),date("Y/m/j"));
					for ($i=0; $i < 3; $i++) { 
						if (!file_exists($dir.DS.$listFile[$i])) {mkdir($dir.DS.$listFile[$i],0777); }
					}
				$result = true;
 			}else{
 				if (!file_exists($dir)) {mkdir($dir,0777); }
 			}
 			return $result;
 		}



 		function linkofsql($array=array()){ 
 			if (!empty($array->idcateg)) {
 				$link = "blog";
 			}
 			if (!empty($array->idplaylist)) {
 				$link = "tuto";
 			}
 			if (!empty($array->idfolder)) {
 				$link = "file";
 			}
 			return $link;
 		}

 


 		function findlistcateg($array,$db){//array
 			$table = array();
			$control = new Controller; 
			$control->loadModel($db);
			$listcateg = toarray($array); 

			for ($i=0; $i < count($listcateg); $i++) { 
				$table[$i] = $control->$db->findFirst(array(
						'conditions' => array('online'=> 1, 'id' => $listcateg[$i])
					));
			}
			//die(var_dump($table));
			return $table;
				
 		}


 		function Postfromcat($idcat,$db,$limit=null){
 			
 			if ($db == "Tuto") {
 				$categname = "idplaylist"; //tuto
 			}elseif ($db == "Download") {
 				$categname = "idfolder"; //download
 			}else{
 				$categname = "idcateg"; //post
 			}
			$control = new Controller; 
			$control->loadModel($db);
			$verifdata = array();
			$result = array();
			$i = 0; 

				$data = $control->$db->find(array(
						'conditions' => array('online'=> 1),
						'order' => 'date',
						'ordersens' => 'DESC'
					)); 
				foreach ($data as $key => $value) {
					$listcateg = toarray($value->$categname); 
						if (in_array($idcat, $listcateg)) {
							$verifdata[$i] = $value;
							$i++;
						} 
				}

			if (!empty($limit)) {
					if (is_array($limit)) {

						if (($limit["from"] > count($verifdata)) OR ($limit["from"] < 0)) {
							$from 	= 0;
						}else{
							$from 	= $limit["from"];
						}
						$to = ($limit["to"] > count($verifdata)) ? count($verifdata) : $limit["to"] ;
						$k = 0;
							for ($j=$from; $j < $to; $j++) { 
								$result[$k] = $verifdata[$j];
								$k++;
							}

						//die(var_dump($verifdata)."<br>ok is array()".var_dump($limit)."<hr>".var_dump($result));
					}else{

						$limit = ($limit > count($verifdata)) ? count($verifdata) : $limit ;

							for ($j=0; $j < $limit; $j++) { 
								$result[$j] = $verifdata[$j];
							}
					}
				}else{
					$result = $verifdata;
				}
			   
			return $result;
 		}

 		function get_p_categ($db){

			$control = new Controller; 
			$control->loadModel($db);
			if ($db == "Listuto") {
				$data = $control->$db->find(array(
						'conditions' => array('online'=> 1 )

					)); 
			}else{
				$data = $control->$db->find(array(
						'conditions' => array('online'=> 1 ,'idparent'=> 0)

					)); 
			}
			   
			return $data;

			
 		}

 		function getsoucateg($id,$db){

			$control = new Controller; 
			$control->loadModel($db);

			$data = $control->$db->find(array(
					'conditions' => array('online'=> 1 ,'idparent' => $id)

				)); 
			   
			return $data;

 		} 

 		function findparent_thiscateg($id,$db){
			$control = new Controller; 
			$control->loadModel($db); 

				$data = $control->$db->findFirst(array(
						'conditions' => array('online'=> 1 ,'id' => $id)
					));  
			return $data;
 		}

 		function findparentcateg($id,$db){
 			$table = array();
			$i = 0;
			while ($id != 0) {
				$data = findparent_thiscateg($id,$db);
				$table[$i] = $data; 
				$i++;
				$id = $data->idparent;
			}
			$table2 = $table;
			$table = datainverse($table);
			//die(var_dump($table)."<br>".var_dump($table2));
			return $table;
			//return datainverse($table);
 		}





///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

 		function addnotif($type,$data){ 
			$control = new Controller; 
			$control->loadModel("Notif");
			$msg = "";
			$ActeurOfAction = ""; 
			//type = 1:add new post,
			if ($type == "post") {
				$control->loadModel("Post"); 
				$type = "1";
				if (!empty($data["idpost"])) {
				$data = $control->Post->findFirst(array(
						'conditions' => array("id" =>$data["idpost"])));
					$msg = "<a href='admin/analyse/user/".$_SESSION['User']->id."'>".userdata($_SESSION['User']->id,"infullname")."</a> edit  : <a href='".URL."/admin/blog/edit/".$data->id."'>".$data->title."</a>";
				}else{
				$data = $control->Post->findFirst(array(
						'conditions' => array("slug" => $data)));
					$msg = "<a href='admin/analyse/user/".$_SESSION['User']->id."'>".userdata($_SESSION['User']->id,"infullname")."</a> add new post : <a href='".URL."/admin/blog/edit/".$data->id."'>".$data->title."</a>";
				}
			}elseif ($type == "inscription") {
			//type = 2:hack,
				$type = "1";
				if (!empty($data)) {
					$control->loadModel("User"); 
					$user = $control->User->findFirst(array(
						'conditions' => array("email" =>$data)));
					if (!empty($user)) {
						$ActeurOfAction = $user->id;
						$msg = "Il'ya un nouveau inscription <a href=''>".userdata($user->id,'infullname')."</a> a partire <a href=''>".get_ip()."</a> ";
					}
				} 
			}elseif ($type == "hack") {
			//type = 2:hack,
				$type = "2";
				if ($data["detect"] == "user") {
					$msg = "<a href='admin/analyse/user/".$data['id']."'>".userdata($data['id'],"infullname")."</a> entre à ".$data['page']." pour ".$data['action'];
				}else{ 
					$msg = "le visiteur utiliser l'IP : <a href='admin/analyse/visiteur/ip='>".$data['ip']."</a> entre à ".$data['page']." pour ".$data['action'];
				} 
			}elseif($type == "delete"){
					$msg = "<a href='admin/analyse/visiteur/".$data['iduser']."'>".userdata($data['iduser'])->fullname."</a> Envoyer un demande pour supprimer <a href='".$data['url']."'>".$data["title"]."</a>";
			}elseif ($type == "tuto") {
				$control->loadModel("Tuto"); 
			//type = 3:tuto,
				$type = "3";
				if (!empty($data["idtuto"])) {
				$data = $control->Tuto->findFirst(array(
						'conditions' => array("id" =>$data["idtuto"])));
					$msg = "<a href='admin/analyse/user/".$_SESSION['User']->id."'>".userdata($_SESSION['User']->id,"infullname")."</a> edit  : <a href='".URL."/admin/tuto/edit/".$data->id."'>".$data->title."</a>";
				}else{
				$data = $control->Tuto->findFirst(array(
						'conditions' => array("slug" => $data)));
					$msg = "<a href='admin/analyse/user/".$_SESSION['User']->id."'>".userdata($_SESSION['User']->id,"infullname")."</a> add new Tuto : <a href='".URL."/admin/tuto/edit/".$data->id."'>".$data->title."</a>";
				}
			}elseif ($type == "download") {
				$control->loadModel("Download"); 
			//type =4:download,
				$type = "4";
				if (!empty($data["idfile"])) {
				$data = $control->Download->findFirst(array(
						'conditions' => array("id" =>$data["idfile"])));
					$msg = "<a href='admin/analyse/user/".$_SESSION['User']->id."'>".userdata($_SESSION['User']->id,"infullname")."</a> edit  : <a href='".URL."/admin/download/edit/".$data->id."'>".$data->title."</a>";
				}else{
				$data = $control->Download->findFirst(array(
						'conditions' => array("slug" => $data)));
					$msg = "<a href='admin/analyse/user/".$_SESSION['User']->id."'>".userdata($_SESSION['User']->id,"infullname")."</a> add new Tuto : <a href='".URL."/admin/download/edit/".$data->id."'>".$data->title."</a>";
				}
			}
				
				if (!empty($_SESSION['User'])) {
					$id = $_SESSION['User']->id;
				}else{
					$id = $ActeurOfAction;
				}
				$control->Notif->add(array(
					'acteur' => $id,  
					'type'   => $type,   
					'content'=> $msg,  
					'action' => "0",  
					'date' 	 => date("Y-m-j h:i:s")
				)); 
 		}

/*------------------------------------------------------------------------------------------------------------------*/
		function getVisiteurdata(){
			//ip,location,sysXp
			$visiteur = new stdClass();
			$visiteur->ip = get_ip();
			return $visiteur;
		}


/************************************************************************************************************************************************************************************************/

 		function ForumData($id,$key=null){
			$control = new Controller;
			$control->loadModel("Forum");
			$data = $control->Forum->findFirst(array('conditions' => array('id' => $id )));  
			
			$Lreponse = array();
			$LrepTrue = "0";
			$allRep = $control->Forum->find(array(
								'conditions'=> array( "online" => 1 , "type" => 1),
								'order'		=> 'date',
								'ordersens'	=> 'DESC'
							));
			foreach ($allRep as $k => $rep) {
				$arrayData = datarray($rep->data,"deconvert");
				if ($arrayData['parent'] == $id) {
					$Lreponse[$k] = $rep;
					if ($arrayData['note'] == 2) {
						$LrepTrue++;
					}
				}
			} 
			if (!empty($data)) {
				$content = datarray($data->data,"deconvert");
				if ($data->type == '0') {//0:Question,1:reponce
					$data->title = $content['title'];
					$data->Alltags = $data->tags;
					$data->tags = (!empty($data->tags)) ? toarray($data->tags,'indir') : "" ; 
					$data->noteTrue = $LrepTrue;
				}else{
					$data->parent = $content['parent'];
					$data->note = $content['note'];
				}
				$data->CountRep = count($Lreponse);
				$data->ListRep 	= $Lreponse;
				$data->content 	= $content['content'];
				$data->TextOnline = ($data->online == "1") ? "online" : "offline" ;
				
			} 
			if (empty($key)) {
				$return = $data;
			}else{
				$return = $data->$key;  
			}
			//var_dump($return); 
				return $return; 
			
			
		}


####################################################################################################################
######################################### Data ############################################################
############################################################################################################

####################### Data User

		/// find UserData 
 
#########################################################################################################
############################## userdata

	function userdata($get=null){ 
					$control = new Controller;
					$control->loadModel("User");
		if (!empty($get)) {
				if (!empty($get->id)) { 
				$data = $get;  
			}else{ 
				$id = $get;
				if (!empty($_SESSION['User'])&&($_SESSION['User']->id == $id)) { 
					$data = $_SESSION['User'];
				}else{ 
					$data = $control->User->findFirst(array('conditions' => array('id' => $id )));  
				}
			}

			if (!empty($data)) {
				$data->fullname = $data->prenom.' '.$data->nom; 
				$data->infullname = $data->nom.' '.$data->prenom; 
				$data->img = (!empty($data->img)) ? $data->img : URL."/assets/upload/img/demoUpload.jpg";
				if ($data->role == "2") { $data->TextRole = "webmaster"; }elseif ($data->role == "1") { $data->TextRole = "admin"; }else{ $data->TextRole = "user"; } 
				if ($data->active == "2") { $data->TextActive = "verif"; }elseif ($data->active == "1") { $data->TextActive = "active"; }else{ $data->TextActive = "bloque"; } 
				$data->TextConnect = ($data->connect == "1") ? "online" : "offline" ;

			}
		}else{
			$data = $control->User->find(); 
		}

		if (empty($data)) { 
			$data = array();
		} 
		//debug($data);
		return $data;
	}

######################################################
	################# Last User Login

	function LastUserLogin(){
		$alluser = findAllUser();
		$list = array();
		foreach ($alluser as $key => $user) {
			if ($user->connect == "1") {
				$list[] = $user;
			}
		}
		return $list;
	}

##################### Analyse Users


	function AnaUserData(){ 
		$control = new Controller;
		$control->loadModel("User");  
		$data = new stdClass();
		$data->numUser = $control->User->findCount(array("ref" => 1));
		$data->numUserVerif = $control->User->findCount(array( "active" => 2 , "ref" => 1));
		$data->numUserActive = $control->User->findCount(array( "active" => 1 , "ref" => 1));
		$data->numUserBloque = $data->numUser - ($data->numUserVerif + $data->numUserActive);
		$data->numUserConnect = $control->User->findCount(array( "connect" => 1));
		$data->numUserOffline = $data->numUser - $data->numUserConnect;
		$data->moyUserVerif = (!empty($data->numUserVerif)) ? math_moy($data->numUserVerif,$data->numUser) : 0 ;
		$data->moyUserActive = (!empty($data->numUserActive)) ? math_moy($data->numUserActive,$data->numUser) : 0 ;
		$data->moyUserBloque = (!empty($data->numUserBloque)) ? math_moy($data->numUserBloque,$data->numUser) : 0 ;
		$data->moyUserConnect = (!empty($data->numUserConnect)) ? math_moy($data->numUserConnect,$data->numUser) : 0 ;
		$data->moyUserOffline = (!empty($data->numUserOffline)) ? math_moy($data->numUserOffline,$data->numUser) : 0 ;
		
		 return $data; 
	}



####################### Data Post
 
#########################################################################################################
############################## postdata

	function postdata($get){  
		if (!empty($get->id)) { 
			$array = $get;
			if (!empty($array->user)) { 
				$result = $array;
			}else{ 
				$data = $array;
			} 
		}else{ 
				$id = $get;  
				$control = new Controller;
				$control->loadModel("Post");
				$data = $control->Post->findFirst(array('conditions' => array('id' => $id )));   
		}

		if (!empty($data)) {

				$data->alltitle = (!empty($data->title)) ? datarray($data->title,"deconvert") : array() ;
				$data->alldescription = (!empty($data->description)) ? datarray($data->description,"deconvert") : array() ;
				$data->allcontent = (!empty($data->content)) ? datarray($data->content,"deconvert") : array() ;

				################################# Titlelang
				foreach (Rdir(VENDOR.'/lib/lang') as $key => $lang) {
					$data->alltitle[$lang] = (!empty($data->alltitle[$lang])) ? $data->alltitle[$lang] : "" ;
					$data->alldescription[$lang] = (!empty($data->alldescription[$lang])) ? $data->alldescription[$lang] : "" ;
					$data->allcontent[$lang] = (!empty($data->allcontent[$lang])) ? $data->allcontent[$lang] : "" ;
				}
				################################# lang
				foreach ($data->alltitle as $lang => $title) {
					if (!empty($title)) {
						$langPost[] = $lang;
					}
				}
 				$langPost = (!empty($langPost)) ? $langPost : array("0"=>"") ; 
 				$data->lang = (!empty($langPost)) ? $langPost : array() ; 
 				$data->vue = (!empty($data->vue)) ? $data->vue : 0 ; 
				###################################################### 

 				$defaultTitle  = (!empty($data->alltitle[$langPost[0]])) ? $data->alltitle[$langPost[0]] : "" ;
				$defaultDesc = (!empty($data->alldescription[$langPost[0]])) ? $data->alldescription[$langPost[0]] : "" ;

				$data->title = (!empty($data->alltitle[$_SESSION['Lang']])) ? $data->alltitle[$_SESSION['Lang']] : $defaultTitle ;
				$data->description = (!empty($data->alldescription[$_SESSION['Lang']])) ? $data->alldescription[$_SESSION['Lang']] : $defaultDesc ;
				$data->content = (!empty($data->allcontent[$_SESSION['Lang']])) ? $data->allcontent[$_SESSION['Lang']] : "" ;
	
			$data->img = (!empty($data->img)) ? $data->img : URL."/assets/upload/img/demoUpload.jpg";
			if ($data->online == "2") { $data->TextOnline = "just admin"; }elseif ($data->online == "1") { $data->TextOnline = "on"; }else{ $data->TextOnline = "off"; }  
			$data->tag = (!empty($data->tags)) ? $data->tags : "" ;
			$data->tags = (!empty($data->tags)) ? datarray($data->tags,"deconvert",",") : array() ;
			$data->categs = (!empty($data->idcateg)) ? datarray($data->idcateg,"deconvert",",") : array() ;
			$listcat = array();
			foreach ($data->categs as $key => $categ) {
				if (!empty(categdata($categ)->title)) {
					$listcat[] = $categ;
				}
			}
			$data->categs = $listcat;
			################################# Normal
			$data->user = $data->iduser;
			$data->dure = dure($data->date);
			$data->notif = datarray($data->notif,"deconvert",",");			
			$result = $data;

		}

		if (empty($result)) { 
			$result = array();
		}
		//die(debug($result));
		return $result;
	}

##########################################################################
	######### most posts/tuto/file
		function mostpost($db,$limit=null){
			$control = new Controller;
			$control->loadModel($db);
			$posts = array();
			$data = $control->$db->find(array('conditions' => array('online'=> 1 )));  
			if (!empty($data)) {
	 			if (!empty($limit)&&($limit < count($data))) {
	 				$data = array_slice($data, $limit);
	 			}
	 			foreach ($data as $key => $post) {
		 			if (!empty(postdata($post)->lang)&&(in_array($_SESSION['Lang'],postdata($post)->lang))) {
				 		
				 		if (!empty($posts[$post->vue])) {
				 			$i = $post->vue;
				 			while (!empty($posts[$i])) {
				 				$i++;
				 			}
				 			$posts[$i] = $post;
				 		}else{
				 			$posts[$post->vue] = $post;
				 		}
				 	}
	 			}
	 			//die(debug(array_reverse($posts, true)));
	 			ksort($posts);
			 	$data = array_reverse($posts, true); 
			}else{
				$data =array();
			}
 			return $data;
		}

	######### last posts

		function lastPost($db,$limit=null){

			$control = new Controller; 
			$control->loadModel($db);
			if (!empty($limit)) {
				$data = $control->$db->find(array(
						'conditions' => array('online'=> 1 ),
						'order' => 'date',
						'ordersens' => 'DESC',
						'limit' => $limit

					)); 
			}else{
				$data = $control->$db->find(array(
						'conditions' => array('online'=> 1 ),
						'order' => 'date',
						'ordersens' => 'DESC'

					)); 
			}
			if (!empty($data)) {
				foreach ($data as $key => $post) {
					if (!empty(postdata($post)->lang)&&(in_array($_SESSION['Lang'],postdata($post)->lang))) {
				 		$posts[] = $post;
				 	}
				}
				$data = $posts;
			}else{
				$data = array();
			}
			   
			return $data;
 		}

##################### Analyse post


	function AnaPostData(){ 
		$control = new Controller;
		$control->loadModel("Post");  
		$data = new stdClass();
		$data->numPost = $control->Post->findCount(array("ref" => 1));
		$data->numPostPub = $control->Post->findCount(array("online" => 1 , "ref" => 1)); 
		$data->numPostOffline = $data->numPost - $data->numPostPub; 
		$data->moyPostPub = (!empty($data->numPostPub)) ? math_moy($data->numPostPub,$data->numPost) : 0 ;
		$data->moyPostOffline = (!empty($data->numPostOffline)) ? math_moy($data->numPostOffline,$data->numPost) : 0 ;
		return $data; 
	}


	######### best admin

		function bestadmin($limit=null){
			$users = array();
			foreach (findAllUser() as $key => $user) {
				$countData = count(userposts($user->id));
				$users[$countData] = $user;
			}
			$data = $users;
			if (!empty($data)) {
	 			if (!empty($limit)&&($limit < count($data))) {
	 				$data = array_slice($data, $limit);
	 			}
	 			ksort($data);
			 	$data = array_reverse($data, true); 
			}else{
				$data =array();
			}
 			return $data;
 		}

########################################################################
#~##################### Categ DATA

 		function categdata($get){  
		if (!empty($get->id)) { 
			$array = $get;
			if (!empty($array->user)) { 
				$result = $array;
			}else{ 
				$data = $array;
			} 
		}else{ 
				$id = $get;  
				$control = new Controller;
				$control->loadModel("Categpost");
				$data = $control->Categpost->findFirst(array('conditions' => array('id' => $id )));   
		}

		if (!empty($data)) {

				$data->alltitle = (!empty($data->title)) ? datarray($data->title,"deconvert") : array() ;
				
				################################# lang
				foreach ($data->alltitle as $lang => $title) {
					$langCateg[] = $lang;
				}

				$langCateg = (!empty($langCateg)) ? $langCateg : array("0"=>"") ; 
 				$data->lang = (!empty($langCateg)) ? $langCateg : array() ; 
				###################################################### 

 				$defaultTitle  = (!empty($data->alltitle[$langCateg[0]])) ? $data->alltitle[$langCateg[0]] : "" ;
			
				###################################################### 
				$data->title = (!empty($data->alltitle[$_SESSION['Lang']])) ? $data->alltitle[$_SESSION['Lang']] : $defaultTitle ;
				
			$data->logo = (!empty($data->logo)) ? $data->logo : URL."/assets/upload/img/demoUpload.jpg";
			$data->cover = (!empty($data->img)) ? $data->img : URL."/assets/upload/img/demoUpload.jpg";
			$data->online = (!empty($data->online)) ? 1 : 0 ; 
			$data->onlineTxt = (!empty($data->online)) ? "On" : "Off" ; 
			$data->icon = (!empty($data->icon)) ? $data->icon : "play" ; 
			$data->color = (!empty($data->color)) ? $data->color : "#eaeaea" ;
			$data->menu = (!empty($data->menu)) ? 1 : 0 ; 
					
			$result = $data;

		}

		if (empty($result)) { 
			$result = array();
		}
		//die(debug($result));
		return $result;
	}




	function categ_articledata($id,$key=null){
		$control = new Controller;
		$control->loadModel("Categpost");
		$data = $control->Categpost->findFirst(array('conditions' => array('id' => $id )));  
		if (empty($key)) {
				return $data;
		}else{
				return $data->$key;
		}
			
	}

	function categ_articleparent(){
		$control = new Controller;
		$control->loadModel("Categpost");
		$data = $control->Categpost->findjoinD(array(
														'fields'=> "idparent"
													));  
		return $data;
			
	}

	function categ_articlewithparent($idparent){
		$control = new Controller;
		$control->loadModel("Categpost");
		$data = $control->Categpost->find(array('conditions' => array('idparent' => $idparent )));    
		return $data;
			
	}

	##################### get data post with categ

	function getdatawithcateg($idcateg,$limit=null){
		$control = new Controller; 
		$control->loadModel("Post");
		$data = $control->Post->find(array(
					'conditions' => array('online'=> 1 ),
					'order' => 'date',
					'ordersens' => 'DESC'
				));  
		if (!empty($data)) { 
			$posts = array();
			foreach ($data as $key => $post) {
				if (!empty(postdata($post)->lang)&&(in_array($_SESSION['Lang'],postdata($post)->lang))&&(in_array($idcateg, postdata($post)->categs))) {
				 	$posts[] = $post;
				}
			} 
			$data = $posts;
 			if (!empty($limit)&&($limit < count($data))) {
 				$data = array_slice($data, $limit);
 			}
		}else{
			$data = array();
		}

		return $data;

		
	}



######################################################################

	function manyPost($limit=null,$type=null){
			$control = new Controller;  
			$control->loadModel('Post');
			$control->loadModel('Tuto');
			$control->loadModel('Download');  
			$posts = array();
			$data = array();
			$post = array();
			$file = array();
			$tuto = array();
			
			//article
			$articles = $control->Post->find(array('conditions' => array('online' => "1" ))); 
			foreach ($articles as $key => $postdata) {
			 	if (!empty(postdata($postdata)->lang)&&(in_array($_SESSION['Lang'],postdata($postdata)->lang))) {
			 		$posts[] = $postdata;
			 	}
			} 
			//tuto
			$tutos = $control->Tuto->find(array('conditions' => array('online' => "1" )));
			
			//file
			$files = $control->Download->find(array('conditions' => array('online' => "1" )));
			
 
			$data = array_merge($posts, $tutos, $files);

			usort($data, "sortFunction");

			foreach ($data as $key => $value) {
				if (!empty($value->idfolder)) {
					$value->form = "file";
					$file[$key] = $value; 
				}elseif (!empty($value->idcateg)) {
					$value->form = "post";
					$post[$key] = $value; 
				}elseif (!empty($value->idplaylist)) {
					$value->form = "tuto";
					$tuto[$key] = $value; 
				}
			}
			//die(debug($data));
 			$data = array_reverse($data, true);
 			if (!empty($limit)&&($limit < count($data))) {
 				$data = array_slice($data, $limit);
 			}
 			if (!empty($type)) {
 				$data = $$type;
 				//die(debug($data));
 			}
			return $data;
	}


	function DataVerifLang($data){
		$posts = array();
		if (!empty($data)) { 
			foreach ($data as $key => $postdata) {
				$lang = postdata($postdata)->lang;
				if (!empty($lang)&&(in_array($_SESSION['Lang'],$lang))) {
					$posts[] = $postdata;
				}
			}
			$data = $posts;
		}else{
			$data = array();
		}
		return $data;
	}




##############################################################
######################################## tutodata

	function tutodata($get){  
		if (!empty($get->id)) { 
			$array = $get;
			if (!empty($array->user)) { 
				$result = $array;
			}else{ 
				$data = $array;
			} 
		}else{ 
				$id = $get;  
				$control = new Controller;
				$control->loadModel("Tuto");
				$data = $control->Tuto->findFirst(array('conditions' => array('id' => $id )));   
		}

		if (!empty($data)) {

				$data->alltitle = (!empty($data->title)) ? datarray($data->title,"deconvert") : array() ;
				$data->alldescription = (!empty($data->description)) ? datarray($data->description,"deconvert") : array() ;
		
				################################# Titlelang
				foreach (Rdir(VENDOR.'/lib/lang') as $key => $lang) {
					$data->alltitle[$lang] = (!empty($data->alltitle[$lang])) ? $data->alltitle[$lang] : "" ;
					$data->alldescription[$lang] = (!empty($data->alldescription[$lang])) ? $data->alldescription[$lang] : "" ;
				}
				################################# lang
				foreach ($data->alltitle as $lang => $title) {
					if (!empty($title)) {
						$langPost[] = $lang;
					}
				}
 				$langPost = (!empty($langPost)) ? $langPost : array("0"=>"") ; 
 				$data->lang = (!empty($langPost)) ? $langPost : array() ; 
 				$data->vue = (!empty($data->vue)) ? $data->vue : 0 ; 
				###################################################### 

 				$defaultTitle  = (!empty($data->alltitle[$langPost[0]])) ? $data->alltitle[$langPost[0]] : "" ;
				$defaultDesc = (!empty($data->alldescription[$langPost[0]])) ? $data->alldescription[$langPost[0]] : "" ;

				$data->title = (!empty($data->alltitle[$_SESSION['Lang']])) ? $data->alltitle[$_SESSION['Lang']] : $defaultTitle ;
				$data->description = (!empty($data->alldescription[$_SESSION['Lang']])) ? $data->alldescription[$_SESSION['Lang']] : $defaultDesc ;
				
			
			$data->img = (!empty($data->img)) ? $data->img : URL."/assets/upload/img/demoUpload.jpg";
			if ($data->online == "2") { $data->TextOnline = "just admin"; }elseif ($data->online == "1") { $data->TextOnline = "on"; }else{ $data->TextOnline = "off"; }  
			$data->tag = (!empty($data->tags)) ? $data->tags : "" ;
			$data->tags = (!empty($data->tags)) ? datarray($data->tags,"deconvert",",") : array() ;
			$data->categs = (!empty($data->idcateg)) ? datarray($data->idcateg,"deconvert",",") : array() ;
			$listcat = array();
			foreach ($data->categs as $key => $categ) {
				if (!empty(playlistdata($categ)->title)) {
					$listcat[] = $categ;
				}
			}
			$data->playlist = $listcat;
			################################# Normal
			$data->user = $data->iduser;
			$data->dure = dure($data->date);
			$data->notif = datarray($data->notif,"deconvert",",");		

			$data->code = (!empty($data->url)) ? datarray($data->url,"deconvert") : array() ;	
			$result = $data;

		}

		if (empty($result)) { 
			$result = array();
		}
		//die(debug($result));
		return $result;
	}



##################### Analyse tuto


	function AnaTutoData(){ 
		$control = new Controller;
		$control->loadModel("Tuto");  
		$data = new stdClass();
		$data->numTuto = $control->Tuto->findCount(array("ref" => 1));
		$data->numTutoPub = $control->Tuto->findCount(array("online" => 1 , "ref" => 1)); 
		$data->numTutoOffline = $data->numTuto - $data->numTutoPub; 
		$data->moyTutoPub = (!empty($data->numTutoPub)) ? math_moy($data->numTutoPub,$data->numTuto) : 0 ;
		$data->moyTutoOffline = (!empty($data->numTutoOffline)) ? math_moy($data->numTutoOffline,$data->numTuto) : 0 ;
		return $data; 
	}


##########################################################################
#~##################### tuto playlist DATA

 		function playlistdata($get){  
		if (!empty($get->id)) { 
			$array = $get;
			if (!empty($array->user)) { 
				$result = $array;
			}else{ 
				$data = $array;
			} 
		}else{ 
				$id = $get;  
				$control = new Controller;
				$control->loadModel("Listuto");
				$data = $control->Listuto->findFirst(array('conditions' => array('id' => $id )));   
		}

		if (!empty($data)) {

				$data->alltitle = (!empty($data->title)) ? datarray($data->title,"deconvert") : array() ;
				$data->alldescription = (!empty($data->description)) ? datarray($data->description,"deconvert") : array() ;
				
				foreach (Rdir(VENDOR.'/lib/lang') as $key => $lang) {
					$data->alltitle[$lang] = (!empty($data->alltitle[$lang])) ? $data->alltitle[$lang] : "" ;
					$data->alldescription[$lang] = (!empty($data->alldescription[$lang])) ? $data->alldescription[$lang] : "" ;
				}
				
				################################# lang
				foreach ($data->alltitle as $lang => $title) {
					$langCateg[] = $lang;
				}
				$langCateg = (!empty($langCateg)) ? $langCateg : array() ; 
 				$data->lang = (!empty($langCateg)) ? $langCateg : array() ; 
				###################################################### 

 				$defaultTitle  = (!empty($data->alltitle[$langCateg[0]])) ? $data->alltitle[$langCateg[0]] : "" ;
 				$defaultDesc  = (!empty($data->alldescription[$langCateg[0]])) ? $data->alldescription[$langCateg[0]] : "" ;
			
				###################################################### 
				$data->title = (!empty($data->alltitle[$_SESSION['Lang']])) ? $data->alltitle[$_SESSION['Lang']] : $defaultTitle ;
				$data->description = (!empty($data->alldescription[$_SESSION['Lang']])) ? $data->alldescription[$_SESSION['Lang']] : $defaultDesc ;
				
			$data->logo = (!empty($data->logo)) ? $data->logo : URL."/assets/upload/img/demoUpload.jpg";
			$data->cover = (!empty($data->img)) ? $data->img : URL."/assets/upload/img/demoUpload.jpg";
			$data->online = (!empty($data->online)) ? 1 : 0 ; 
			$data->onlineTxt = (!empty($data->online)) ? "On" : "Off" ; 
			$data->icon = (!empty($data->icon)) ? $data->icon : "play" ; 
			$data->color = (!empty($data->color)) ? $data->color : "#eaeaea" ;
				
				//die(debug($data));	
			$result = $data;

		}

		if (empty($result)) { 
			$result = array();
		}
		//die(debug($result));
		return $result;
	}




##############################################################
######################################## file downlaod data

	function filedata($get){  
		if (!empty($get->id)) { 
			$array = $get;
			if (!empty($array->user)) { 
				$result = $array;
			}else{ 
				$data = $array;
			} 
		}else{ 
				$id = $get;  
				$control = new Controller;
				$control->loadModel("Download");
				$data = $control->Download->findFirst(array('conditions' => array('id' => $id )));   
		}

		if (!empty($data)) {

				$data->allcontent = (!empty($data->content)) ? datarray($data->content,"deconvert") : array() ;
				$data->alldescription = (!empty($data->description)) ? datarray($data->description,"deconvert") : array() ;
		
				################################# Titlelang
				foreach (Rdir(VENDOR.'/lib/lang') as $key => $lang) { 
					$data->alldescription[$lang] = (!empty($data->alldescription[$lang])) ? $data->alldescription[$lang] : "" ;
					$data->allcontent[$lang] = (!empty($data->allcontent[$lang])) ? $data->allcontent[$lang] : "" ;
				}
				################################# lang
				foreach ($data->alldescription as $lang => $discription) {
					if (!empty($discription)) {
						$langPost[] = $lang;
					}
				}
 				$langPost = (!empty($langPost)) ? $langPost : array("0"=>"") ; 
 				$data->lang = (!empty($langPost)) ? $langPost : array() ; 
 				$data->vue = (!empty($data->vue)) ? $data->vue : 0 ; 
				###################################################### 

 				$defaultCont   = (!empty($data->allcontent[$langPost[0]])) ? $data->allcontent[$langPost[0]] : "" ;
				$defaultDesc = (!empty($data->alldescription[$langPost[0]])) ? $data->alldescription[$langPost[0]] : "" ;

				$data->description = (!empty($data->alldescription[$_SESSION['Lang']])) ? $data->alldescription[$_SESSION['Lang']] : $defaultDesc ;
				$data->content = (!empty($data->allcontent[$_SESSION['Lang']])) ? $data->allcontent[$_SESSION['Lang']] : $defaultCont ;
				
			
			$data->img = (!empty($data->img)) ? $data->img : URL."/assets/upload/img/demoUpload.jpg";
			$data->forma = (!empty($data->forma)) ? $data->forma : "none";
			$data->bit = (!empty($data->bit)) ? $data->bit : "none";
			$data->type = (!empty($data->type)) ? $data->type : "none";
			$data->version = (!empty($data->version)) ? $data->version : "0.1";
			$data->size = datarray($data->size,"deconvert");
			$data->size_value = (!empty($data->size['value'])) ? $data->size['value'] : "0" ;
			$data->size_unit = (!empty($data->size['unit'])) ? $data->size['unit'] : "none" ; 

			if ($data->online == "2") { $data->TextOnline = "just admin"; }elseif ($data->online == "1") { $data->TextOnline = "on"; }else{ $data->TextOnline = "off"; }  
			
			$data->tag = (!empty($data->tags)) ? $data->tags : "" ;
			$data->tags = (!empty($data->tags)) ? datarray($data->tags,"deconvert",",") : array() ;
			$data->lang = (!empty($data->lang)) ? $data->lang : "" ;
			//$data->alllang = (!empty($data->lang)) ? datarray($data->lang,"deconvert",",") : array() ;
			$data->os = (!empty($data->os)) ? $data->os : "" ;
			$data->allos = (!empty($data->os)) ? datarray($data->os,"deconvert",",") : array() ;
			$data->lisOs = array();
			foreach ($data->allos as $key => $os) {
				if(!empty($os)){
					$data->lisOs[] = $os;
				}
			} 
			$data->listurl = (!empty($data->url)) ? datarray($data->url,"deconvert") : array() ;	
			$data->listscreen= (!empty($data->screen)) ? datarray($data->screen,"deconvert") : array() ;	
			$data->categs = (!empty($data->idfolder)) ? datarray($data->idfolder,"deconvert",",") : array() ;
			$listcat = array();
			foreach ($data->categs as $key => $categ) {
				if (!empty(folderdata($categ)->title)) {
					$listcat[] = $categ;
				}
			} 
			$data->list = $listcat;
			$data->title = $data->title;
			################################# Normal
			$data->user = $data->iduser;
			$data->download = $data->numdown;
			$data->dure = dure($data->date);
			$data->notif = datarray($data->notif,"deconvert",",");		
 
			$result = $data;

		}

		if (empty($result)) { 
			$result = array();
		}
		//die(debug($result));
		return $result;
	}


##################### Analyse file/download


	function AnafileData(){ 
		$control = new Controller;
		$control->loadModel("Download");  
		$data = new stdClass();
		$data->numFile = $control->Download->findCount(array("ref" => 1));
		$data->numFilePub = $control->Download->findCount(array("online" => 1 , "ref" => 1)); 
		$data->numFileOffline = $data->numFile - $data->numFilePub; 
		$data->moyFilePub = (!empty($data->numFilePub)) ? math_moy($data->numFilePub,$data->numFile) : 0 ;
		$data->moyFileOffline = (!empty($data->numFileOffline)) ? math_moy($data->numFileOffline,$data->numFile) : 0 ;
		return $data; 
	}


##########################################################################
#~##################### tuto folder download data

 		function folderdata($get){  
		if (!empty($get->id)) { 
			$array = $get;
			if (!empty($array->user)) { 
				$result = $array;
			}else{ 
				$data = $array;
			} 
		}else{ 
				$id = $get;  
				$control = new Controller;
				$control->loadModel("Categdownload");
				$data = $control->Categdownload->findFirst(array('conditions' => array('id' => $id )));   
		}

		if (!empty($data)) {

				$data->alltitle = (!empty($data->title)) ? datarray($data->title,"deconvert") : array() ;
				$data->alldescription = (!empty($data->description)) ? datarray($data->description,"deconvert") : array() ;
				
				foreach (Rdir(VENDOR.'/lib/lang') as $key => $lang) {
					$data->alltitle[$lang] = (!empty($data->alltitle[$lang])) ? $data->alltitle[$lang] : "" ;
					$data->alldescription[$lang] = (!empty($data->alldescription[$lang])) ? $data->alldescription[$lang] : "" ;
				}
				
				################################# lang
				foreach ($data->alltitle as $lang => $title) {
					$langCateg[] = $lang;
				}
				$langCateg = (!empty($langCateg)) ? $langCateg : array() ; 
 				$data->lang = (!empty($langCateg)) ? $langCateg : array() ; 
				###################################################### 

 				$defaultTitle  = (!empty($data->alltitle[$langCateg[0]])) ? $data->alltitle[$langCateg[0]] : "" ;
 				$defaultDesc  = (!empty($data->alldescription[$langCateg[0]])) ? $data->alldescription[$langCateg[0]] : "" ;
			
				###################################################### 
				$data->title = (!empty($data->alltitle[$_SESSION['Lang']])) ? $data->alltitle[$_SESSION['Lang']] : $defaultTitle ;
				$data->description = (!empty($data->alldescription[$_SESSION['Lang']])) ? $data->alldescription[$_SESSION['Lang']] : $defaultDesc ;
				
			$data->logo = (!empty($data->logo)) ? $data->logo : URL."/assets/upload/img/demoUpload.jpg";
			$data->cover = (!empty($data->cover)) ? $data->cover : URL."/assets/upload/img/demoUpload.jpg";
			$data->online = (!empty($data->online)) ? 1 : 0 ; 
			$data->onlineTxt = (!empty($data->online)) ? "On" : "Off" ; 
			$data->icon = (!empty($data->icon)) ? $data->icon : "play" ; 
			$data->color = (!empty($data->color)) ? $data->color : "#eaeaea" ;
				
				//die(debug($data));	
			$result = $data;

		}

		if (empty($result)) { 
			$result = array();
		}
		//die(debug($result));
		return $result;
	}




######################################################################################
	################ categ downlaod / folder downlaod sous function


	function categ_data($id,$key=null){
		$control = new Controller;
		$control->loadModel("Categdownload");
		$data = $control->Categdownload->findFirst(array('conditions' => array('id' => $id )));  
		if (empty($key)) {
				return $data;
		}else{
				return $data->$key;
		}
			
	}

	function categ_parent(){
		$control = new Controller;
		$control->loadModel("Categdownload");
		$data = $control->Categdownload->findjoinD(array(
														'fields'=> "idparent"
													));  
		return $data;
			
	}

	function categ_datawithparent($idparent){
		$control = new Controller;
		$control->loadModel("Categdownload");
		$data = $control->Categdownload->find(array('conditions' => array('idparent' => $idparent )));    
		return $data;
			
	}



########################################################################################
		/// All NEW uSER/pOST/tUTO/fILE
 
 		function NewData($model){
			$control = new Controller;
			$control->loadModel($model);
			$data = $control->$model->find(array('conditions' => array('ref' => 0 )));  
			
				return $data;  
		} 
		
		function getlinkUrl($db){
			
			if ($db == "Post") {
				$result = "blog";
			}elseif ($db == "Tuto") {
				$result = "tuto";
			}elseif ($db == "Download") {
				$result = "file";
			}

			return $result;
		}
///////////////////////////////////////////////////////////////////////////////////////

 		function userposts($id,$key=null){
			$control = new Controller;
			$control->loadModel("User");
			$control->loadModel('Statut');
			$control->loadModel('Post');
			$control->loadModel('Tuto');
			$control->loadModel('Download');  
			$data = array();
			//statut
			$statuts = $control->Statut->find(array('conditions' => array('user' => $id , 'type' => "statut" )));  
			//article
			$articles = $control->Post->find(array('conditions' => array('iduser' => $id , 'online' => "1" )));  
			//tuto
			$tutos = $control->Tuto->find(array('conditions' => array('iduser' => $id , 'online' => "1" ))); 
			//file
			$files = $control->Download->find(array('conditions' => array('iduser' => $id , 'online' => "1" )));
 
			//$sum = count($statuts)+count($articles)+count($tutos)+count($files); 
			$data = array_merge($statuts, $articles, $tutos, $files);

			usort($data, "sortFunction");

			foreach ($data as $key => $value) {
				if (!empty($value->idfolder)) {
					$value->form = "file";
				}elseif (!empty($value->idcateg)) {
					$value->form = "post";
				}elseif (!empty($value->idplaylist)) {
					$value->form = "tuto";
				}elseif ($value->type == "statut") { 
					$value->form = "statut"; 
				}
			}

			//die(var_dump($data));
 			$data = array_reverse($data, true);
			return $data;
			 
			
		}

function sortFunction($a,$b,$type=null) {
	if (!empty($type)) {
    	return strtotime($a['date']) - strtotime($b['date']);
	}else{
		return strtotime($a->date) - strtotime($b->date);
	}
}

/************************************************************************************************************/

	## user data(post/tuto/file)
	
	function findUserData($iduser){
			$control = new Controller;
			$control->loadModel("User");
			$data = new stdClass();
			$data = $control->User->findFirst(array('conditions' => array('id' => $iduser)));
			if (!empty($data)) {
				$data->fullname = $data->nom.' '.$data->prenom;
			}


			return $data;

	}
	

	## user data categ(post/tuto/file)
	
	function findUserDataCateg($iduser,$type=null){
		$data = findUserData($iduser);
		if (!empty($data)) {
			$PostCateg = array();
			$TutoCateg = array();
			$FileCateg = array();
			$AllCateg = array();
			$formaCateg = "none";
			$i=0;$j=0;$k=0;
			foreach ($data as $key => $post) {
				if (!empty($post->idcateg)) {
					$categ = findlistcateg($post->idcateg,'Categpost');
					if (!in_array($categ, $PostCateg)) {
						$PostCateg[$i] = $categ;
						$formCateg = "Post";
						$linkCateg = "blog/categ";
						$i++;
					}
				}elseif (!empty($post->idfolder)) {
					$categ = findlistcateg($post->idfolder,'Categdownload');
					if (!in_array($categ, $FileCateg)) {
						$FileCateg[$j] = $categ;
						$formCateg = "Download";
						$linkCateg = "folder";
						$j++; 
					}
				}elseif (!empty($post->idplaylist)) { 
					$categ = findlistcateg($post->idplaylist,'Listuto');
					if (!in_array($categ, $TutoCateg)) {
						$TutoCateg[$k] = $categ;
						$formCateg = "Tuto";
						$linkCateg = "playlist";
						$k++; 
					}
				}
					if (!in_array($categ, $AllCateg)) {
						$categ["formaCateg"] = $formCateg;
						$categ["linkCateg"] = $linkCateg;
						$AllCateg[$key] = $categ; 
					}
			}

			if (empty($type)) {
				return $AllCateg;
			}else{
				if ($type == "PostCateg") {
					return $PostCateg;
				}
				if ($type == "FileCateg") {
					return $FileCateg;
				}
				if ($type == "TutoCateg") {
					return $TutoCateg;
				}
			}
		}else{
			return array();
		}
 

	}
	

/***************************************************************************************************************/


 		function findMsgof($id,$type=null){
			$control = new Controller;
			$control->loadModel("Msg");
			$data = $control->Msg->find(array('conditions' => array('type' => $type )));  
			 
			if (empty($key)) {
				return $data;
			}else{
				return $data->$key;
			}
			
		}


		function findallUserwithIP($ip){

			$control = new Controller;
			$control->loadModel("User");
			$all = $control->User->find();
			$data = array();
			$i = 0; 
			foreach ($all as $key => $user) {
				if (userdata($user->id)->ip == $ip) {
					$data[$i] = $user->id;
					$i++;
				}
			}
			return $data;
		}

		function DataByDate($date,$type,$data){
			$result = array();
			if ($type == "anne") { 
				$control = new Controller;
				$control->loadModel($data);
				$all = $control->$data->find();
				foreach ($all as $key => $value) {
					if (array_date($value->date)["y"] == $date) {
						$result[$key] = $value;
					}
				}
			}
			
			return $result;
		}
/*----------------------------------------------------------------------------------------------*/

		function PubShow($post){
			$control = new Controller;
			$control->loadModel("Pub");
			$pub = "";
			$data = $control->Pub->findFirst(array(
				'conditions' => array(
					'post' 		=> $post, 
					'online' 	=> 1, 
					'post' 		=> $post
				))); 

			if (!empty($data)) {
				if ((DateNow() >= $data->date_start)&&(PubData($data->id,"Textdure") != "Error")&&($data->date_end >= DateNow())) {
					$pub = $data->content;
				}
			}
			return $pub;
		} 

		function PubData($id,$key=null){

			$control = new Controller;
			$control->loadModel("Pub");
			$data = $control->Pub->findFirst(array('conditions' => array('id' => $id )));  
			$data->Textlimit = $data->date_start." - ".$data->date_end;
			$data->Textdure = dureTime($data->date_start,$data->date_end); 
			$data->TextOnline= ($data->online == "1") ? "online" : "offline" ;
			
			if (!empty($data->data)) {
				$data->cache = datarray($data->data,"deconvert"); 
			}

			if (empty($key)) {
				return $data;
			}else{
				return $data->$key;
			}
		}

/*------------------------------------------------------------------------------------------------*/

		function widgetFind($k,$value){

			$control = new Controller;
			$control->loadModel("Param"); 
			$data = $control->Param->find(array(
						'conditions' => array($k => $value ),//part : 1=right,2=footer right,3=footer center,4=footer lrft
						'order' => 'order_param',
						'ordersens' => 'ASC' ));
			if (empty($key)) {
				return $data;
			}else{
				return $data->$key;
			}
		}
/*----------------------------------------------------------------------------------------------*/

	

	function ThisUrl2LOAD(){
		$id = $_SESSION['PgVue']['id'];
		$model = $_SESSION['PgVue']['model']; 
		if (!empty($_SESSION['PgVue']['username'])) {
			$username = $_SESSION['PgVue']['username'];
		}
		$control = new Controller;
		$control->loadModel($model);  
		$data = $control->$model->findFirst(array('conditions' => array('id' => $id ))); 
		if ($model == "Post") {
			$url = "blog/".$data->slug;
		}
		if ($model == "Tuto") {
			$url = "tuto/".$data->slug;
		}
		if ($model == "Download") {
			$url = "file/".$data->slug;
		}
		if (($model == "Statut")&&(!empty($username))) {
			$url = $username."/statut/".$id;
		}
		if (!empty($url)) {
		 	return $url;
		}else{
			return URL;
		}
	}

	function IncluedCommentSystem(){ 
		include WEB.'/view/layout/comment/core.php';
	}
	
	function GetVuesSession($model,$id,$username=null){
		$controlVue = new Controller; 
		$controlVue->loadModel($model);  
		$tm = date("h");
		$old = array();
		if (!empty($_SESSION['PgVue'])) {
			$old = $_SESSION['PgVue'];
		}
		$data = $controlVue->$model->findFirst(array('conditions' => array('id' => $id ))); 
		if (!empty($data)) {
			if (!empty($data->user)) {
				$auteur = $data->user;
			}else{
				$auteur = $data->iduser;
			}
			if (!empty($username)) {
				$PgVue = array('tm' => $tm,'model' => $model,'id' => $id ,'username' => $username ,'auteur' => $auteur );
			}else{
				 $PgVue = array('tm' => $tm,'model' => $model,'id' => $id ,'auteur' => $auteur );
			}
			if (empty($_SESSION['PgVue'])) {
				$controlVue->Session->write('PgVue',$PgVue);
			}else{
				$_SESSION['PgVue'] = $PgVue;
			}
			//addvue
			if ((empty($old))OR(($old['model'] != $model)OR($old['id'] != $id))OR($old['tm'] != $tm)) {
				$controlVue->$model->update($id,array('vue' => $data->vue + 1)); 
			}
		}

	}

	function CountPostCmm($model,$id){
		$control = new Controller;
		$control->loadModel("Comment"); 
		$data = $control->Comment->find(array(
						'conditions' => array('idpost'=> $id , 'typepost'=> $model , 'parent'=> 0 )
				)); 
		$n = count($data);
		if (!empty($n)) {
			return $n;
		}else{
			return 0;
		}

	}
/**********************************************************************************************/
// msg #type:0=>2 user,1=>to wm,2=>in dash "only admins",3=>notif WM message

	function SendMsgWm($data){

		$control = new Controller;
		$control->loadModel("Msg"); 
			if (isset($_POST['sendmsgwm'])) { 
					$content = protect($_POST[$data["content"]]); 
					$object = protect($_POST[$data["object"]]);  
					  
						$dbmsg = $control->Msg->find(array(
								'conditions' => array( "auteur" => $_SESSION['User']->id,"type"=>1)
							));
						if (!empty($dbmsg)) {
							$lastmsg = end($dbmsg)->content;
						}else{
							$lastmsg = "";
						}
						if ($content&&($_SESSION['User']->role != "2")&&($lastmsg != $content)) { 
							$control->Msg->add(array(
								'type' 			=> 1,
								'vue' 			=> 0,  
								'destinateur' 	=> $object,  
								'auteur' 		=> $_SESSION['User']->id,  
								'date' 		    => date("Y-m-j h:i:s"),  
								'content' 		=> $content
							)); 

						$control->Session->setFlash(translater("sendmsg","success")); 
						//$control->redirect("admin/blog");
					}else{
						$control->Session->setFlash(translater("remp_false","danger"));
					}
			} 

	}


	function SendMsgPrive($dest,$msg){

		$control = new Controller;
		$control->loadModel("Msg"); 
		$control->loadModel("User"); 
			if (isset($_POST['sendmsgprive'])) { 
					$content = protect($_POST[$msg]);   
					$destinateur = $control->User->findFirst(array('conditions' => array('id' => $dest ))); 
						$dbmsg = $control->Msg->find(array(
								'conditions' => array( "auteur" => $_SESSION['User']->id,"type"=>0)
							));
						if (!empty($dbmsg)) {
							$lastmsg = end($dbmsg)->content;
						}else{
							$lastmsg = "";
						}
						if ($content&&(!empty($destinateur))&&($lastmsg != $content)) { 
							$control->Msg->add(array(
								'type' 			=> 0,
								'vue' 			=> 0,  
								'destinateur' 	=> $destinateur->id,  
								'auteur' 		=> $_SESSION['User']->id,  
								'date' 		    => date("Y-m-j h:i:s"),  
								'content' 		=> $content
							)); 
							//$control->Session->setFlash(translater("sendmsg","success")); 
						
					}else{
							$control->Session->setFlash(translater("remp_false","danger"));
					}
			} 

	}

	//Vue msg

	function VueMsgPrive($id){

		$control = new Controller;
		$control->loadModel("Msg");
		$ResMsg = $control->Msg->find(array(
						'conditions' => array('auteur'=> $id ,'destinateur'=> $_SESSION['User']->id , 'type'=> 0)
				)); 
			if (end($ResMsg)->vue == 0) {
			  	foreach ($ResMsg as $key => $msg) {
			  		$control->Msg->update($msg->id,array('vue' => 1)); 
			  	}
				$control->redirect('message?user='.$id);
			  }   
	}
	
	//new msg

	function NewMsgPrive($id=null,$type=null){
		$control = new Controller;
		$control->loadModel("Msg");
		$type = (!empty($type)) ? $type : "default" ;
		if ($type == "default") {
			if (!empty($id)) {
				$ResMsg = $control->Msg->find(array(
								'conditions' => array('auteur'=> $id ,'destinateur'=> $_SESSION['User']->id , 'type'=> 0 , 'vue' => 0)
						)); 
			}else{
				$ResMsg = $control->Msg->find(array(
								'conditions' => array('destinateur'=> $_SESSION['User']->id , 'type'=> 0 , 'vue' => 0)
						));  
			}
		}elseif ($type == "wm") {
			$ResMsg['send'] = $control->Msg->find(array(
								'conditions' => array('auteur'=> $id , 'type'=> 0 , 'vue' => 0)
						)); 
			$ResMsg['res'] = $control->Msg->find(array(
								'conditions' => array('destinateur'=> $id , 'type'=> 0 , 'vue' => 0)
						)); 
		}
		
		return $ResMsg;  
	}

	//message prive

	function ListUM($id){
		$control = new Controller;
		$control->loadModel("Msg"); 
		$SendMsg = $control->Msg->find(array(
						'conditions' => array('auteur'=> $id , 'type'=> 0)
				)); 
		$ResMsg = $control->Msg->find(array(
						'conditions' => array('destinateur'=> $id , 'type'=> 0)
				)); 
		$LUser = array();
		foreach ($SendMsg as $key => $msg) {
			if (!in_array($msg->destinateur, $LUser)) {
				$LUser[] = $msg->destinateur;
			}
		}
		foreach ($ResMsg as $key => $msg) {
			if (!in_array($msg->auteur, $LUser)) {
				$LUser[] = $msg->auteur;
			}
		}
		return $LUser;

	}
	
	#descetion entre 2 user 

	function MsgDecU($id,$start=null){
		$control = new Controller;
		$control->loadModel("Msg"); 
		$SendMsg = $control->Msg->find(array(
						'conditions' => array('auteur'=> $_SESSION['User']->id ,'destinateur'=> $id , 'type'=> 0)
				)); 
		$ResMsg = $control->Msg->find(array(
						'conditions' => array('auteur'=> $id ,'destinateur'=> $_SESSION['User']->id , 'type'=> 0)
				)); 
		$LMsg = array();
		$ChatMsg = array();
		foreach ($SendMsg as $key => $msg) { 
		 	$msg->action = "0";//send msg
			$LMsg[] = $msg; 
		}
		foreach ($ResMsg as $key => $msg) { 
			$msg->action = "1";//Resuve msg
			$LMsg[] = $msg;  
		}
		$Allmsg = array_sort($LMsg, 'id', SORT_DESC);
		if (!empty($start)) {
			if ($start > count($Allmsg)) {
				$n = count($Allmsg);
			}else{
				$n = $start;
			}
		}else{
			$n = 10;
		}
		$i = 0;
		foreach ($Allmsg as $key => $msg) {
			if ($i < $n) {
				$ChatMsg[] = $msg;
				$i++;
			}
		} 
		$data['chat'] = $ChatMsg;
		$data['allMsg'] = $Allmsg;
		return $data; 

	}


	/// system de user notification

	function SeeThisNotif($idpost,$tabpost,$iduser=null){
		if (!empty($_SESSION['User'])) {
			$iduser = (!empty($iduser)) ? $iduser : $_SESSION['User']->id ;
			$control = new Controller;
			if ($tabpost == "Like") {
				$control->loadModel('Comment'); 
				$data = $control->Comment->findFirst(array('conditions' => array('id' => $idpost ))); 
				
				if (!empty($data)) {
					if ($data->LikeNotif == 1) {
							$return = "vue";
					}else{
							$return = "notvue"; 
					}
				}else{
							$return = "eror"; 
				}

			}else{
				$control->loadModel($tabpost); 
				$data = $control->$tabpost->findFirst(array('conditions' => array('id' => $idpost ))); 
				if (!empty($data)) {
					if (!empty($data->notif)) {
						if (in_array($iduser,toarray($data->notif))) {
							$return = "vue";
						}else{ 
							$return = "notvue";
						}
					}else{
							$return = "notvue"; 
					}
				}else{
							$return = "eror"; 
				}
			}
			return $return;	
		}

	}



	//see the notif 

	function SeeThisUserNotif($idpost,$tabpost,$iduser){
			$control = new Controller;
			if ($tabpost != "Like") {
				$control->loadModel($tabpost);
				$data = $control->$tabpost->findFirst(array('conditions' => array('id' => $idpost )));  
				$notif = toarray($data->notif);
				if (!in_array($iduser, $notif)) {
					$notif[] = $iduser;
					$control->$tabpost->update($idpost,array('notif' => toarray($notif,'indir'))); 
				}
			}else{ 
				$control->loadModel("Comment");
				$data = $control->Comment->findFirst(array('conditions' => array('id' => $idpost ))); 
				if ($data->LikeNotif == 0) { 
					$control->Comment->update($idpost,array('LikeNotif' => 1)); 
				}
			}
	}

	// 	user Notification
	function AllUserNotif($id=null){
		$control = new Controller;
		$control->loadModel('Post');
		$control->loadModel('Tuto');
		$control->loadModel('Download');
		$control->loadModel('Forum');
		$control->loadModel('Comment');
		$control->loadModel('Msg');
		$Notif = array(); 
		$iduser = (!empty($id)) ? $id : $_SESSION['User']->id ; 
		$i = 0;
		$countNewNotif = 0;
		$AllPost = $control->Post->find(array( 'conditions' => array('online'=> 1 )));
		$AllComm = $control->Comment->find(array( 'conditions' => array('online'=> 1 )));
		$AllTuto = $control->Tuto->find(array( 'conditions' => array('online'=> 1 )));
		$AllFile = $control->Download->find(array( 'conditions' => array('online'=> 1 )));
		$AllmsgNotif = $control->Msg->find(array( 'conditions' => array('type'=> 3 , 'destinateur'=> $iduser)));
		
		$AllQustion = $control->Forum->find(array( 'conditions' => array('type'=> 0 ,'online'=> 1 )));
		$RepYForumQ = $control->Forum->find(array( 'conditions' => array('type'=> 1 ,'online'=> 1 )));
		$YRepForumQ = $control->Forum->find(array( 'conditions' => array('type'=> 1 ,'online'=> 1 , 'user'=> $iduser)));
		
		foreach ($AllPost as $key => $post) {
			if ($post->iduser != $iduser) {
				if (SeeThisNotif($post->id,"Post") == "notvue") {
					$countNewNotif++;
					$Notif[$i]['id'] = $post->id; 
					$Notif[$i]['type'] = "Post";
					$Notif[$i]['date'] = $post->date;
					$Notif[$i]['vueNotif'] = 0;
					$i++;
				}elseif ((array_date($post->date)['y'] == date('Y'))AND(array_date($post->date)['m'] == date('m'))AND(array_date($post->date)['j'] > date('j')-7)) {
					$Notif[$i]['id'] = $post->id; 
					$Notif[$i]['type'] = "Post";
					$Notif[$i]['date'] = $post->date;
					$Notif[$i]['vueNotif'] = 1;
					$i++;
				}  
			}
		}

		foreach ($AllComm as $key => $comment) {
			if ($comment->user != $iduser) {
				if (SeeThisNotif($comment->id,"Comment") == "notvue") {
					$countNewNotif++;
					$Notif[$i]['id'] = $comment->id; 
					$Notif[$i]['type'] = "Comment";
					$Notif[$i]['user'] = $comment->user;
					$Notif[$i]['idpost'] = $comment->idpost;
					$Notif[$i]['typepost'] = $comment->typepost;
					$Notif[$i]['date'] = $comment->date;
					$tab = array('Post'=>'blog','Tuto'=>'tuto','Download'=>'file','Statut'=>'statut');
					$Notif[$i]['url'] = $tab[$comment->typepost];
					$Notif[$i]['vueNotif'] = 0;
					$i++;
				}elseif ((array_date($comment->date)['y'] == date('Y'))AND(array_date($comment->date)['m'] == date('m'))AND(array_date($comment->date)['j'] > date('j')-7)) {
					$Notif[$i]['id'] = $comment->id; 
					$Notif[$i]['type'] = "Comment";
					$Notif[$i]['user'] = $comment->user;
					$Notif[$i]['idpost'] = $comment->idpost;
					$Notif[$i]['typepost'] = $comment->typepost;
					$Notif[$i]['date'] = $comment->date;
					$tab = array('Post'=>'blog','Tuto'=>'tuto','Download'=>'file','Statut'=>'statut');
					$Notif[$i]['url'] = $tab[$comment->typepost];
					$Notif[$i]['vueNotif'] = 1;
					$i++;
				} 
			}
		}
		$list = array();
		foreach ($AllComm as $key => $comment) {
			if (!empty($comment->likes)) {
					$likes = datarray($comment->likes,"deconvert"); 
					foreach ($likes as $date => $user) {
						if (($iduser != $user)AND($iduser == $comment->user)) { 
							if (!empty($list[$comment->id])) {
								$list[$comment->id]['user'][count($list[$comment->id]['user'])] = $user;
							}else{
								$list[$comment->id]['user'][0] = $user;
							}
								$list[$comment->id]['date'] = $date;
								$list[$comment->id]['idpost'] = $comment->idpost;
								$list[$comment->id]['typepost'] = $comment->typepost;
								$list[$comment->id]['usercomm'] = $comment->user;
								$list[$comment->id]['idcomm'] = $comment->id;
								$list[$comment->id]['vue'] = $comment->LikeNotif;
						}
					}
			}
		}
		foreach ($list as $key => $like) {
				if ($like['vue'] == 0) {
					$countNewNotif++;
					$Notif[$i]['user'] = $like['user'];
					$Notif[$i]['date'] = $like['date'];
					$Notif[$i]['type'] = "Like";
					$Notif[$i]['idpost'] = $like['idpost'];
					$Notif[$i]['typepost'] = $like['typepost'];
					$Notif[$i]['usercomm'] = $like['usercomm'];
					$Notif[$i]['idcomm'] = $like['idcomm'];
					$tab = array('Post'=>'blog','Tuto'=>'tuto','Download'=>'file','Statut'=>'statut');
					$Notif[$i]['url'] = $tab[$like['typepost']];
					$Notif[$i]['vueNotif'] = 0;
					$i++;
				}elseif ((array_date($like['date'])['y'] == date('Y'))AND(array_date($like['date'])['m'] == date('m'))AND(array_date($like['date'])['j'] > date('j')-7)) {
					$Notif[$i]['user'] = $like['user'];
					$Notif[$i]['date'] = $like['date'];
					$Notif[$i]['type'] = "Like";
					$Notif[$i]['idpost'] = $like['idpost'];
					$Notif[$i]['typepost'] = $like['typepost'];
					$Notif[$i]['usercomm'] = $like['usercomm'];
					$Notif[$i]['idcomm'] = $like['idcomm'];
					$tab = array('Post'=>'blog','Tuto'=>'tuto','Download'=>'file','Statut'=>'statut');
					$Notif[$i]['url'] = $tab[$like['typepost']];
					$Notif[$i]['vueNotif'] = 1;
					$i++;
				} 
		}
			

		foreach ($AllTuto as $key => $tuto) {
			if ($tuto->iduser != $iduser) {
				if (SeeThisNotif($tuto->id,"Tuto") == "notvue") {
					$countNewNotif++;
					$Notif[$i]['id'] = $tuto->id; 
					$Notif[$i]['type'] = "Tuto";
					$Notif[$i]['date'] = $tuto->date;
					$Notif[$i]['vueNotif'] = 0;
					$i++;
				}elseif ((array_date($tuto->date)['y'] == date('Y'))AND(array_date($tuto->date)['m'] == date('m'))AND(array_date($tuto->date)['j'] > date('j')-7)) {
					$Notif[$i]['id'] = $tuto->id; 
					$Notif[$i]['type'] = "Tuto";
					$Notif[$i]['date'] = $tuto->date;
					$Notif[$i]['vueNotif'] = 1;
					$i++;
				} 
			}
		}
		foreach ($AllFile as $key => $file) {
			if ($file->iduser != $iduser) {
				if (SeeThisNotif($file->id,"Download") == "notvue") {
					$countNewNotif++;
					$Notif[$i]['id'] = $file->id; 
					$Notif[$i]['type'] = "Download"; 
					$Notif[$i]['date'] = $file->date;
					$Notif[$i]['vueNotif'] = 0;
					$i++;
				}elseif ((array_date($file->date)['y'] == date('Y'))AND(array_date($file->date)['m'] == date('m'))AND(array_date($file->date)['j'] > date('j')-7)) {
					$Notif[$i]['id'] = $file->id; 
					$Notif[$i]['type'] = "Download"; 
					$Notif[$i]['date'] = $file->date;
					$Notif[$i]['vueNotif'] = 1;
					$i++;
				} 
			}
		}
		foreach ($AllmsgNotif as $key => $msgnotif) {

			$countNewNotif++;
			$Notif[$i]['id'] = $msgnotif->id; 
			$Notif[$i]['type'] = "Msg"; 
			$Notif[$i]['date'] = $msgnotif->date;
			$Notif[$i]['vueNotif'] = $msgnotif->vue;
			$Notif[$i]['obj'] = $msgnotif->auteur;
			$Notif[$i]['content'] = $msgnotif->content;
			$i++;  
		}
		foreach ($AllQustion as $key => $Question) {
			if ($Question->user != $iduser) {
				if (SeeThisNotif($Question->id,"Forum") == "notvue") {
					$countNewNotif++;
					$Notif[$i]['id'] = $Question->id; 
					$Notif[$i]['type'] = "Forum"; 
					$Notif[$i]['date'] = $Question->date;
					$Notif[$i]['vueNotif'] = 0;
					$i++;
				}elseif ((array_date($Question->date)['y'] == date('Y'))AND(array_date($Question->date)['m'] == date('m'))AND(array_date($Question->date)['j'] > date('j')-7)) {
					$Notif[$i]['id'] = $Question->id; 
					$Notif[$i]['type'] = "Forum"; 
					$Notif[$i]['date'] = $Question->date;
					$Notif[$i]['vueNotif'] = 1;
					$i++;
				} 
			}
		}
		foreach ($RepYForumQ as $key => $Rep) {
			if ((ForumData(ForumData($Rep->id)->parent)->user == $iduser)AND($Rep->user != $iduser)) {
				if (SeeThisNotif($Rep->id,"Forum") == "notvue") {
					$countNewNotif++;
					$Notif[$i]['id'] = $Rep->id; 
					$Notif[$i]['parent'] = ForumData($Rep->id)->parent; 
					$Notif[$i]['type'] = "RForum"; 
					$Notif[$i]['date'] = $Rep->date;
					$Notif[$i]['vueNotif'] = 0;
					$i++;
				}elseif ((array_date($Rep->date)['y'] == date('Y'))AND(array_date($Rep->date)['m'] == date('m'))AND(array_date($Rep->date)['j'] > date('j')-7)) {
					$Notif[$i]['id'] = $Rep->id; 
					$Notif[$i]['parent'] = ForumData($Rep->id)->parent; 
					$Notif[$i]['type'] = "RForum"; 
					$Notif[$i]['date'] = $Rep->date;
					$Notif[$i]['vueNotif'] = 1;
					$i++;
				} 
			}
		}
		foreach ($YRepForumQ as $key => $Rep) {
			if ((ForumData($Rep->id)->note == 2)AND($Rep->user == $iduser)AND(ForumData(ForumData($Rep->id)->parent)->user != $iduser)) {
				if (SeeThisNotif($Rep->id,"Forum") == "notvue") {
					$countNewNotif++;
					$Notif[$i]['id'] = $Rep->id; 
					$Notif[$i]['parent'] = ForumData($Rep->id)->parent; 
					$Notif[$i]['type'] = "ARForum"; 
					$Notif[$i]['date'] = $Rep->date;
					$Notif[$i]['vueNotif'] = 0;
					$i++;
				}elseif ((array_date($Rep->date)['y'] == date('Y'))AND(array_date($Rep->date)['m'] == date('m'))AND(array_date($Rep->date)['j'] > date('j')-7)) {
					$Notif[$i]['id'] = $Rep->id; 
					$Notif[$i]['parent'] = ForumData($Rep->id)->parent; 
					$Notif[$i]['type'] = "ARForum"; 
					$Notif[$i]['date'] = $Rep->date;
					$Notif[$i]['vueNotif'] = 1;
					$i++;
				} 
			}elseif ((ForumData($Rep->id)->note == 3)AND($Rep->user == $iduser)AND(ForumData(ForumData($Rep->id)->parent)->user != $iduser)) {
				if (SeeThisNotif($Rep->id,"Forum") == "notvue") {
					$countNewNotif++;
					$Notif[$i]['id'] = $Rep->id; 
					$Notif[$i]['parent'] = ForumData($Rep->id)->parent; 
					$Notif[$i]['type'] = "RRForum"; 
					$Notif[$i]['date'] = $Rep->date;
					$Notif[$i]['vueNotif'] = 0;
					$i++;
				}elseif ((array_date($Rep->date)['y'] == date('Y'))AND(array_date($Rep->date)['m'] == date('m'))AND(array_date($Rep->date)['j'] > date('j')-7)) {
					$Notif[$i]['id'] = $Rep->id; 
					$Notif[$i]['parent'] = ForumData($Rep->id)->parent; 
					$Notif[$i]['type'] = "RRForum"; 
					$Notif[$i]['date'] = $Rep->date;
					$Notif[$i]['vueNotif'] = 1;
					$i++;
				} 
			}
		}
		$Notif =  array_sort($Notif, 'date', SORT_DESC);
		$Notif['count'] = $countNewNotif;
		return $Notif;
	}
	
/****************************************************************************************************/
/***********************  msg data  **************************************/	
	
	function msgAllContactUser($iduser){

		$control = new Controller;
		$control->loadModel('Msg');
		$listUser = array();
		$send = $control->Msg->find(array('conditions' => array('type'=> 0 , 'auteur' => $iduser)));
		$receive = $control->Msg->find(array('conditions' => array('type'=> 0 , 'destinateur' => $iduser)));
		foreach ($send as $key => $data) {
			if (!in_array($data->destinateur, $listUser)) {
				$listUser[] = $data->destinateur;
			}
		}
		foreach ($receive as $key => $data) {
			if (!in_array($data->auteur, $listUser)) {
				$listUser[] = $data->auteur;
			}
		}
		
		return $listUser;
	}

	function msgAllContact($me,$iduser){
		$control = new Controller;
		$control->loadModel('Msg');
		$listMsg = array();
		$send = $control->Msg->find(array('conditions' => array('type'=> 0 , 'auteur' => $me , 'destinateur' => $iduser)));
		$receive = $control->Msg->find(array('conditions' => array('type'=> 0 , 'auteur' => $iduser , 'destinateur' => $me)));
		foreach ($send as $key => $data) {
				$listMsg[] = $data;
		}
		foreach ($receive as $key => $data) {
				$listMsg[] = $data;
		}
		
		$listMsg =  array_sort($listMsg, 'date', SORT_DESC);
		return $listMsg;
	}

/****************************************************************************************************/


####################################################################################################
######################## DATA PARAM ###############################################################
### => file download param {forma}:
	function fileParamDataforma($param=null){
		$control = new Controller;
		$control->loadModel('Param');
		$control->loadModel('Download');
		$ParamData = array();
		$finddata = $control->Param->find(array('conditions' => array('type'=> "20")));

		if (!empty($finddata)) {
			foreach ($finddata as $key => $ppval) {
				$ParamData[$ppval->value]['id'] = $ppval->id;
				$ParamData[$ppval->value]['title'] = $ppval->title;
				$ParamData[$ppval->value]['slug'] = $ppval->value;
				$ParamData[$ppval->value]['logo'] = $ppval->data;

				$files = $control->Download->find(array('conditions' => array('forma'=> $ppval->value)));
				$ParamData[$ppval->value]['numfile'] = count($files);
				$ParamData[$ppval->value]['used'] = (count($files)> 0) ? true : false ;

			}
		}  
		if ((empty($param))OR($param == "all")) {
			$data = $ParamData;
		}else{
			if (!empty($ParamData[$param])) {
				$data = $ParamData[$param];
			}else{
				$data = array("title"=>"","slug"=>"","logo"=>"");
			}
			
		}
		return $data;
	}

### => file download param {os}:
	function fileParamDataos($param=null){
		$control = new Controller;
		$control->loadModel('Param');
		$control->loadModel('Download');
		$ParamData = array();
		$finddata = $control->Param->find(array('conditions' => array('type'=> "21")));

		if (!empty($finddata)) {
			foreach ($finddata as $key => $ppval) {
				$ParamData[$ppval->value]['id'] = $ppval->id;
				$ParamData[$ppval->value]['title'] = $ppval->title;
				$ParamData[$ppval->value]['slug'] = $ppval->value;
				$ParamData[$ppval->value]['logo'] = $ppval->data;
				$veriffile = 0;
				$files = $control->Download->find();
				foreach ($files as $key => $file) {
					$arrosfile = (!empty(datarray($file->os,"deconvert",","))) ? datarray($file->os,"deconvert",",") : array() ;
					if (in_array($ppval->value, $arrosfile)) {
						$veriffile++;
					}
				}
				$ParamData[$ppval->value]['numfile'] = $veriffile;
				$ParamData[$ppval->value]['used'] = ($veriffile > 0) ? true : false ;

			}
		}  
		if ((empty($param))OR($param == "all")) {
			$data = $ParamData;
		}else{
			if (!empty($ParamData[$param])) {
				$data = $ParamData[$param];
			}else{
				$data = array("title"=>"","slug"=>"","logo"=>"");
			}
			
		}
		return $data;
	}

### => file download param {type}:
	function fileParamDatatype($param=null){
		$control = new Controller;
		$control->loadModel('Param');
		$control->loadModel('Download');
		$ParamData = array();
		$finddata = $control->Param->find(array('conditions' => array('type'=> "22")));

		if (!empty($finddata)) {
			foreach ($finddata as $key => $ppval) {
				$ParamData[$ppval->value]['id'] = $ppval->id;
				$ParamData[$ppval->value]['title'] = $ppval->title;
				$ParamData[$ppval->value]['slug'] = $ppval->value;
				$ParamData[$ppval->value]['logo'] = $ppval->data;

				$files = $control->Download->find(array('conditions' => array('type'=> $ppval->value)));
				$ParamData[$ppval->value]['numfile'] = count($files);
				$ParamData[$ppval->value]['used'] = (count($files)> 0) ? true : false ;

			}
		}  
		if ((empty($param))OR($param == "all")) {
			$data = $ParamData;
		}else{
			if (!empty($ParamData[$param])) {
				$data = $ParamData[$param];
			}else{
				$data = array("title"=>"","slug"=>"","logo"=>"");
			}
			
		}
		return $data;
	}

### => file download param {langue}:
	function fileParamDatalangue($param=null){
		$control = new Controller;
		$control->loadModel('Param');
		$control->loadModel('Download');
		$ParamData = array();
		$finddata = $control->Param->find(array('conditions' => array('type'=> "23")));

		if (!empty($finddata)) {
			foreach ($finddata as $key => $ppval) {
				$ParamData[$ppval->value]['id'] = $ppval->id;
				$ParamData[$ppval->value]['title'] = $ppval->title;
				$ParamData[$ppval->value]['slug'] = $ppval->value;
				$ParamData[$ppval->value]['logo'] = $ppval->data;
				$veriffile = 0;
				$files = $control->Download->find();
				foreach ($files as $key => $file) {
					$arrosfile = (!empty(datarray($file->os,"deconvert",","))) ? datarray($file->lang,"deconvert",",") : array() ;
					if (in_array($ppval->value, $arrosfile)) {
						$veriffile++;
					}
				}
				$ParamData[$ppval->value]['numfile'] = $veriffile;
				$ParamData[$ppval->value]['used'] = ($veriffile > 0) ? true : false ;

			}
		}  
		if ((empty($param))OR($param == "all")) {
			$data = $ParamData;
		}else{
			if (!empty($ParamData[$param])) {
				$data = $ParamData[$param];
			}else{
				$data = array("title"=>"","slug"=>"","logo"=>"");
			}
			
		}
		return $data;
	}

##############################################################################################
	 function SiteParam(){ 
		$control = new Controller;
		$control->loadModel('Param');
		$data = new stdClass();
		$params = $control->Param->find();

		############## logo & icon

		$data->logo = $control->Param->findFirst(array(
						'conditions' => array('type'=> 11, 'data' => "logo")
					));
		$data->icon = $control->Param->findFirst(array(
						'conditions' => array('type'=> 11, 'data' => "icon")
					));
		if (!empty($data->logo)) { 
			$data->logo->img =  $data->logo->value;
			$data->logo->up =  "notempty";
		}else{
			$data->logo = new stdClass();
			$data->logo->img =  URL."/assets/upload/img/demoUpload.jpg" ;
			$data->logo->title = SiteName ;

		}
		if (!empty($data->icon)) { 
			$data->icon->img =  $data->icon->value;
			$data->icon->up =  "notempty";
		}else{
			$data->icon = new stdClass();
			$data->icon->img =  URL."/assets/upload/img/demoUpload.jpg" ;
			$data->icon->title = SiteName ;

		} 

		############## sociel links 

		$data->soclinks = $control->Param->find(array(
									'conditions' => array( "type" => "12")
								));



		return $data;
	 }



?>