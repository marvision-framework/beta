<?php
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////  Version 1 - 2015 //////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	//les role d'acteur
		function RoleActeur($role){ 
		$user 	= "";
		$acteur = ""; 
			if (!empty($_SESSION["User"])) {
				$userRole 	= $_SESSION["User"]->role;
				$userVerif 	= $_SESSION["User"]->active;
				if ($userRole == 2) {//wm
					$user = "WM";
				}
				if ($userRole == 1) {//admin
					$user = "Admin";
				}
				if ($userRole == 0) {//user
					$user = "User";
				}

					if ($userVerif == 2) {//verif
						$acteur = $user."Verif";
					}
					if ($userVerif == 1) {//actif
						$acteur = $user."Actif"; 
					}
					if ($userVerif == 0) {//bloque
						$acteur = $user."Bloque";
					}
			}else{
				$user = "Visteur";
			}

			if (($role == $user)OR($role == $acteur)) {
				return true;
			}else{
				return false;
			}
			
		}

	//sécuriser les données envoyee à la base de donnee
		function protect($donne_envoye){  
			
			$data = htmlspecialchars($donne_envoye); 

			return $data;
		}

	//crypte les password  
		function crypte($data){
			return (md5($data)); 
		} 
	// verif if this val exist in this model
		function usedb($type,$val,$model){ 
				$control = new Controller;
				$control->loadModel($model);
				$dispo = $control->$model->findFirst(array('conditions' => array($type => $val ))); 
				 
				return $result = (!empty($dispo)) ? true : false ;

			} 
	// verif email
		function verifemail($email){ 
			$Syntaxe_email='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
			return $result = (preg_match($Syntaxe_email,$email)) ? true : false ; 
		}
	// verif url
		function VerifUrl($url,$site){ 
			//$Syntaxe_url='#^[\w.-]+@[\w.-]+\.[a-zA-Z]{2,6}$#';
			//$Syntaxe_url = '';
			//return $result = (preg_match($Syntaxe_url,$url)) ? true : false ; 
			/*if(($site == "website")&&($url != "http://4plusup.com/")){
				return false;
			}elseif(($site == "youtube")&&($url != "http://youtube.com/")){
				return false;
			}elseif(($site == "facebook")&&($url != "http://facebook.com/")){
				return false;
			}else{
				return true;
			}*/
			return true;
		}
	// verif name
		function verifnom($nom){
			$nom = no_space($nom);
			$inter = array("1","2","3","4","5","6","7","8","9","0",".",",","+","-","*","/","","\/","_","&","@","²","#","'","،",";",":",'"',"^","]","[","(",")","{","}","=","<",">","?","!","$");
			$new = str_replace($inter,"e",$nom);
			//die($nom."<br>".$new);
			return $result = ($nom == $new) ? true : false ;
		}

	// verif tags
		function verifTags($txt){
			$txt = no_space($txt);
			$carct = array("1","2","3","4","5","6","7","8","9","0",".",",","+","-","*","/","","\/","_","&","@","²","#","'","،",";",":",'"',"^","]","[","(",")","{","}","=","<",">","?","!","$","é","è","ç","à","µ");
			$arab = array("ء","غ","ظ","ض","ذ","خ","ث","ت","ش","ر","ق","ص","ف","ع","س","ن","م","ل","ك","ي","ط","ح","ز","و","ه","د","ج","ب","أ","ا");
			$newtxt = str_replace($carct,"c",$txt);
			$newtxt = str_replace($arab,"a",$txt); 
			if ($txt == $newtxt) {
				$result = true;
			}else{
				$result = false;
			}
			return $result;
		}

		function veriflogin($login){
			$login = no_space($login);
			$inter = array(".",",","+","-","*","/","","\/","_","&","@","²","#","'",";",":",'"',"^","]","[","(",")","{","}","=","<",">","?","!","$");
			$new = str_replace($inter,"e",$login);
			//die($nom."<br>".$new);
			return $result = ($login == $new) ? true : false ;
		}

 


		function pseudo($nom,$prenom){ 
			$nom = 	no_space($nom);
			$prenom = 	no_space($prenom);  
			$ar = array("محمد","مروان","حسام","أحمد","ماهر","بسام","أسامة","وديع","نور","وليد","هشام","ال","رو","كي","لا","وي","ء","بو","حي","غ","ظ","ض","ذ","خ","ث","ت","ش","ر","ق","ص","ف","ع","س","ن","م","ل","ك","ي","ط","ح","ز","و","ه","د","ج","ب","أ","ا");
			$fr = array("mohamed","marwen","houssam","ahmed","maher","bassem","oussama","wadia","nour","walid","hichem","","rou","ki","la","oui","","bou","hi","gha","tha","tha","th","ka","tha","ta","ch","r","ka","s","f","a","sa","n","ma","l","k","y","t","h","z","wa","h","d","j","b","a","a");
			 
			$Syntaxe='#^[a-zA-Z]{2,10}$#';
			if(preg_match($Syntaxe,$prenom) and preg_match($Syntaxe,$nom)){ 
				$prenom = lcfirst($prenom);
				$nom = lcfirst($nom);

				$pseudo = $prenom.'.'.$nom;
					$i = 1;

				if(usedb("username",$pseudo,"User") == true){
					
					while(usedb("username",$pseudo,"User") == true){		
						$pseudo = $prenom.'.'.$nom.'.'.$i;
							$i++;
						}
				}
			}elseif ((is_arabic($nom)==true)&&(is_arabic($prenom)==true)) { 

				$prenom = str_replace($ar,$fr,$prenom);
				$nom = str_replace($ar,$fr,$nom);
				$prenom = lcfirst($prenom);
				$nom = lcfirst($nom);
				$pseudo = $prenom.'.'.$nom;
				$i = 1;
				if(usedb("username",$pseudo,"User") == true){
					while(usedb("username",$pseudo,"User") == true){		
						$pseudo = $prenom.'.'.$nom.'.'.$i;
						$i++;
							
					}			
								
				} 
								
			}else{
				$pseudo = "none";
				var_dump($nom." ".$prenom);
			}

				return $pseudo;
				//die($pseudo);
		}

		 
		function verifbirthday($j,$m,$y){

			$result = true;
			if ($j > 31) {$result = false;}
			if ($j < 1) {$result = false;}
			if ($m < 1) {$result = false;}
			if ($m > 12) {$result = false;}
			if ($y < 1900) {$result = false;}
			if ($y > date('Y')-1) {$result = false;}

			$Syntaxe_1='#^[0-9]{1,2}$#';
			$Syntaxe_2='#^[0-9]{4}$#';
			if (preg_match($Syntaxe_1,$j)&&preg_match($Syntaxe_1,$m)&&preg_match($Syntaxe_2,$y)) {
				$result = true;
			}else{
				$result = false;
			}
			//die($result);
			return $result;
		}

		function SecuritySystem($deg,$detail){

				$control = new Controller;
				$control->loadModel("User"); 
				$control->loadModel("Visiteur"); 
				$visiteur = $control->Visiteur->findFirst(array(
						'conditions' => array("ip" => get_ip()))); 
				if(empty($_SESSION['User']->id)){
					if (!empty($visiteur->iduser)) {  
						for ($i=0 ; $i < count(toarray($visiteur->iduser)) ; $i++) { 
							$user[$i] = $control->User->findFirst(array(
										'conditions' => array("id" => toarray($visiteur->iduser)[$i]))); 
							$isuser = "list";
						} 
					}else{$user = "false";}
				}else{
					$user = $_SESSION['User'];
					$isuser = "true";
				}
					$action = $detail["action"];
					$page = $detail["page"];  

				if ($isuser == "false") {
					if (($visiteur->tmp == "0")&&($deg == 1)) {
						addnotif("hack",array("ip"=> get_ip(),"page"=>$page,"action" => $action,"detect"=>"visiteur"));
						$control->Visiteur->update($visiteur->id,array('tmp' => "1")); 
					}else{
						addnotif("hack",array("ip"=> get_ip(),"page"=>$page,"action" => $action,"detect"=>"visiteur"));
						$control->Visiteur->update($visiteur->id,array('tmp' => "2")); 
					}
				}elseif ($isuser == "list") {
					foreach ($user as $key => $datauser) {
						if ($user->role != "2") {
							if ($deg == 1) {
									
								if ($user->role == 1) {
									if ($user->active == 2) { 
										addnotif("hack",array("id"=>$user->id,"page"=>$page,"action" => $action,"detect"=>"user"));
										$control->User->update($user->id,array('active' => "1")); 
									}elseif ($user->active == 1) {
										addnotif("hack",array("id"=>$user->id,"page"=>$page,"action" => $action,"detect"=>"user"));
										$control->User->update($user->id,array('active' => "0")); 
									}else{
										addnotif("hack",array("id"=>$user->id,"page"=>$page,"action" => $action,"detect"=>"user"));
										$control->User->update($user->id,array('active' => "0")); 
										$control->Visiteur->update($visiteur->id,array('tmp' => "1")); 
									}
								}else{
									if ($user->active == 2) {
										addnotif("hack",array("id"=>$user->id,"page"=>$page,"action" => $action,"detect"=>"user"));
										$control->User->update($user->id,array('active' => "1")); 
									}elseif ($user->active == 1) {
										addnotif("hack",array("id"=>$user->id,"page"=>$page,"action" => $action,"detect"=>"user"));
										$control->User->update($user->id,array('active' => "0")); 
										$control->Visiteur->update($visiteur->id,array('tmp' => "1")); 
									}else{
										addnotif("hack",array("id"=>$user->id,"page"=>$page,"action" => $action,"detect"=>"user"));
										$control->Visiteur->update($visiteur->id,array('tmp' => "2")); 
									}
								}
							}else{
								if ($visiteur->tmp == "0") {
										addnotif("hack",array("id"=>$user->id,"page"=>$page,"action" => $action,"detect"=>"user"));
										$control->User->update($user->id,array('active' => "0")); 
										$control->Visiteur->update($visiteur->id,array('tmp' => "1")); 
								}else{
										addnotif("hack",array("id"=>$user->id,"page"=>$page,"action" => $action,"detect"=>"user"));
										$control->Visiteur->update($visiteur->id,array('tmp' => "2")); 
								}
							}
						}else{
							addnotif("hack",array("id"=>$user->id,"page"=>$page,"action" => $action,"detect"=>"user"));
						}
					}
				}else{

						if ($user->role != "2") {
							if ($deg == 1) {
									// comp - 1
								if ($user->role == 1) {
									if ($user->active == 2) {
										addnotif("hack",array("id"=>$user->id,"page"=>$page,"action" => $action,"detect"=>"user"));
										$control->User->update($user->id,array('active' => "1")); 
									}elseif ($user->active == 1) {
										addnotif("hack",array("id"=>$user->id,"page"=>$page,"action" => $action,"detect"=>"user"));
										$control->User->update($user->id,array('active' => "0")); 
									}else{
										addnotif("hack",array("id"=>$user->id,"page"=>$page,"action" => $action,"detect"=>"user"));
										$control->User->update($user->id,array('active' => "0")); 
										$control->Visiteur->update($visiteur->id,array('tmp' => "2")); 
									}
								}else{
									if ($user->active == 2) {
										addnotif("hack",array("id"=>$user->id,"page"=>$page,"action" => $action,"detect"=>"user"));
										$control->User->update($user->id,array('active' => "1")); 
									}elseif ($user->active == 1) {
										addnotif("hack",array("id"=>$user->id,"page"=>$page,"action" => $action,"detect"=>"user"));
										$control->User->update($user->id,array('role'=>1,'active' => "2")); 
									}else{
										addnotif("hack",array("id"=>$user->id,"page"=>$page,"action" => $action,"detect"=>"user"));
										$control->User->update($user->id,array('active' => "0")); 
										$control->Visiteur->update($visiteur->id,array('tmp' => "2")); 
									}
								}
							}else{
								if ($visiteur->tmp != "0") {
										addnotif("hack",array("id"=>$user->id,"page"=>$page,"action" => $action,"detect"=>"user"));
										$control->User->update($user->id,array('active' => "0")); 
								}else{
										addnotif("hack",array("id"=>$user->id,"page"=>$page,"action" => $action,"detect"=>"user"));
										$control->User->update($user->id,array('active' => "0")); 
										$control->Visiteur->update($visiteur->id,array('tmp' => "2")); 
								}
							}
						}else{
							addnotif("hack",array("id"=>$user->id,"page"=>$page,"action" => $action,"detect"=>"user"));
							
						}
				}
	}


 		function filterSouArray($value,$type){
 			if ($type == "in") {
 				$val = str_replace(" : ", " _/:²_ ", $value);
 			}elseif ($type == "out") { 
 				$val = str_replace(" _/:²_ ", " : ", $value); 
 			}
 			return $val;
 		}

	function is_image($path) {
	$a = getimagesize($path);
	$image_type = $a[2];
		     
	if(in_array($image_type , array(IMAGETYPE_JPEG))){
		        return true;
		}
		return false;
	}

?>