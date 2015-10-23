<?php
#######################################################################################################
############ Admin Controller (CMS) ##################################################################
#######################################################################################################

	class CmsController extends Controller
	{
		
  	##################################################################################################
	####---// DASHBORD function

  		function dashbord(){ 
			$this->layout = 'cms';
			$d['title_for_layout'] = 'dashbord';   
			$d['rightmenu'] = array("categ"=>"dashboard","pg"=>"");

			$this->set($d);
  		}
  		
  	##################################################################################################
	####---// USERS function
 
	#########home users########################
			
  	function users(){
			$this->layout = 'cms';
			$d['title_for_layout'] = 'Users';  
			$d['rightmenu'] = array("categ"=>"users","pg"=>"list"); 
			$d['datatab'] = 4; 
			$this->loadModel('User');  
			$d['users'] = userdata();

			$this->set($d);
  	}

	#########Add new User########################
		function adduser(){

			$this->layout = 'cms';
			$d['title_for_layout'] = 'new User';
			$d['rightmenu'] = array("categ"=>"users","pg"=>"add");

			$this->loadModel('User');
				//addnewuser
					if(isset($_POST['adduser'])){
						$verifData = true;
						$verifForm = $this->loadForm(array(
										'NotEmpty' => array(
											'password' => $this->request->data->password,
										),
										'Text' => array(
											'nom' => $this->request->data->nom,
											'prenom' => $this->request->data->prenom,
										))
								);

						if($verifForm){
							$adduser = new stdClass();
							$adduser->nom = protect($this->request->data->nom);
							$adduser->prenom = protect($this->request->data->prenom);
							$adduser->email = protect($this->request->data->email);
							$adduser->password = md5(protect($this->request->data->password));
							$adduser->active = (!empty($this->request->data->active))? '1' : '0' ;
							$adduser->role = (!empty($this->request->data->role))? $this->request->data->role : '0' ;
							$adduser->username = (!empty($this->request->data->username))? protect($this->request->data->username): pseudo($adduser->nom,$adduser->prenom);

							if ((usedb("username",$adduser->username,"User") == true)OR((is_arabic($adduser->nom)==true)OR(is_arabic($adduser->prenom)==true))) {
								$adduser->username = pseudo($adduser->nom,$adduser->prenom);
							}
							if (usedb("email",$adduser->email,"User") == true) {
								$verifData = false;
								$this->Session->setFlash(translater("used_email","danger"));
							}
							########################## Uplaod Picture ################################
							if (!empty($_FILES['image']['name'])) {

								$dir = SRC.DS."upload/users/profil/".$adduser->username;
								if (!file_exists($dir)) {mkdir($dir,0777); }
								$up = UploadImage("image",$dir);
								if (!empty($up["data"])) {
									$adduser->img = URL."/assets/upload/users/profil/".$adduser->username."/".$up['data']['newname'];
								}

							}else{
								$adduser->img	= URL."/assets/upload/img/demoUpload.jpg";
							}
							#########################################################################

							if($verifData){
									$this->User->add($adduser);
									$this->Session->setFlash(translater("success","success"));
									$this->redirect("admin/user/");
								}else{
									$this->Session->setFlash(translater("remp_false","danger"));
									$this->redirect("admin/user/add");
								}


						}else{
							$this->Session->setFlash(translater("remp_false","danger"));
							$this->redirect("admin/user/add");
						}

					}

			$this->set($d);
		}
/*
  		function adduser(){
  			if ($_SESSION['User']->role == 2) { 
			$this->layout = 'cms';
			$d['thisongl'] =  array("cat"=>"users","pg"=>"add");  
			$this->loadModel('User');  
 
			if (isset($_POST['adduser'])) { 
				if ((!empty($_POST['nom']))&&(!empty($_POST['prenom']))&&(!empty($_POST['email']))&&(!empty($_POST['password']))&&(!empty($_POST['username']))) {
						$isok 		 = true; 
						$nom 		 = protect($this->request->data->nom);
						$prenom 	 = protect($this->request->data->prenom); 
						$email 		 = protect($this->request->data->email); 
						$password 	 = protect($this->request->data->password); 
						$role 		 = protect($this->request->data->role); 
						$active 	 = protect($this->request->data->active); 
						$description = $this->request->data->description;  
						$otherdata['cle']  = $password; 
						######################################################## Verif Pseudo (username) 
		 					 if (!empty($_POST["username"])) {
							 	$username 	 = protect($this->request->data->username); 
							 }else{
							 	$username = pseudo($nom,$prenom);
							 }
		 					if ((empty($username))OR(usedb("username",$username,"User") == true)OR((is_arabic($nom)==true)OR(is_arabic($prenom)==true))) {
		 						$username = pseudo($nom,$prenom);
		 					}
		 					if (usedb("email",$email,"User") == true) {
		 						$isok = false;
		 					}
						#################################################### End Verif Pseudo (username) 

						########################################################### Upload image 
							if (!empty($_FILES['file']['name'])) {

									$dir = SRC.DS."upload/users/profil/".$username;
									if (!file_exists($dir)) {mkdir($dir,0777); } 
									$up = UploadImage("file",$dir); 
									if (!empty($up["data"])) {
										$img = URL."/assets/upload/users/profil/".$username."/".$up['data']['newname'];
									}

							}else{
								$img	= URL."/assets/upload/img/demoUpload.jpg"; 
							}
						######################################################## End Upload image 

						if ($isok == true) {
							$this->User->add(array(
								'nom' 			=> $nom,  
								'prenom' 		=> $prenom, 
								'username' 		=> $username,
								'email' 		=> $email, 
								'password' 		=> md5($password), 
								'description'	=> $description, 
								'img' 			=> $img, 
								'role' 			=> $role, 
								'active' 		=> $active,
								'ref'	 		=> 1,
								'data'			=> datarray($otherdata,"convert")
							)); 
							$this->Session->setFlash(translater("success","success"));
						}else{
							$this->Session->setFlash(translater("remp_false","danger"));
						}
							$this->redirect("admin/user/");
				}else{
					$this->Session->setFlash(translater("remp_false","danger"));
					$this->redirect("admin/user/add");
				}
			}
			$this->set($d);
		}else{$this->redirect("admin/users");}
	}
*/

	######### Edit User ########################

		function edituser($id){

			$this->layout = 'cms';
			$d['title_for_layout'] = 'edit User';
			$d['rightmenu'] = array("categ"=>"users","pg"=>"edit");

			$this->loadModel('User');
			$d['user'] = findUserData($id);
			if(!empty($d['user'])){

				//edituser
				if(isset($_POST['edituser'])){
					$verifData = true;
					$verifForm = $this->loadForm(array(
							'NotEmpty' => array(
								'password' => $this->request->data->password,
							),
							'Text' => array(
								'nom' => $this->request->data->nom,
								'prenom' => $this->request->data->prenom,
							))
					);

					if($verifForm){
						$adduser = new stdClass();
						$adduser->nom = protect($this->request->data->nom);
						$adduser->prenom = protect($this->request->data->prenom);
						$adduser->email = protect($this->request->data->email);
						$adduser->password = md5(protect($this->request->data->password));
						$adduser->active = (!empty($this->request->data->active))? '1' : '0' ;
						$adduser->role = (!empty($this->request->data->role))? $this->request->data->role : '0' ;
						$adduser->username = (!empty($this->request->data->username))? protect($this->request->data->username): pseudo($adduser->nom,$adduser->prenom);

						if ((usedb("username",$adduser->username,"User") == true)OR((is_arabic($adduser->nom)==true)OR(is_arabic($adduser->prenom)==true))) {
							$adduser->username = pseudo($adduser->nom,$adduser->prenom);
						}
						if (usedb("email",$adduser->email,"User") == true) {
							$verifData = false;
							$this->Session->setFlash(translater("used_email","danger"));
						}
						########################## Uplaod Picture ################################
						if (!empty($_FILES['image']['name'])) {

							$dir = SRC.DS."upload/users/profil/".$adduser->username;
							if (!file_exists($dir)) {mkdir($dir,0777); }
							$up = UploadImage("image",$dir);
							if (!empty($up["data"])) {
								$adduser->img = URL."/assets/upload/users/profil/".$adduser->username."/".$up['data']['newname'];
							}

						}else{
							$adduser->img	= URL."/assets/upload/img/demoUpload.jpg";
						}
						#########################################################################

						if($verifData){
							$this->User->add($adduser);
							$this->Session->setFlash(translater("success","success"));
							$this->redirect("admin/user/");
						}else{
							$this->Session->setFlash(translater("remp_false","danger"));
							$this->redirect("admin/user/add");
						}


					}else{
						$this->Session->setFlash(translater("remp_false","danger"));
						$this->redirect("admin/user/add");
					}

				}
			}else{
 					$this->redirect("admin/users");
			}

			$this->set($d);
		}

			
//  		function edituser($id){
//  			$this->layout = 'cms';
//			$d['thisongl'] =  array("cat"=>"users","pg"=>"edit");
//			//die(debug(userdata($id)));
//			if (!empty(userdata($id))AND($_SESSION['User']->role == 2)) {
//				$this->loadModel('User');
//				$datauser = userdata($id);
//				$d['datauser'] = $datauser;
//
//				if (isset($_POST['upuser'])) {
//					if ((!empty($_POST['nom']))AND(!empty($_POST['prenom']))AND(!empty($_POST['email']))AND(!empty($_POST['password']))AND(!empty($_POST['username']))) {
//
//						$isok 		 = true;
//						$nom 		 = protect($this->request->data->nom);
//						$prenom 	 = protect($this->request->data->prenom);
//						$email 		 = protect($this->request->data->email);
//						$password 	 = (!empty($_POST["password"])) ? protect($this->request->data->password) : userdata($_SESSION["User"]->id)->cache['password'] ;
//						$role 		 = (!empty($_POST["role"])) ? protect($this->request->data->role) : 0 ;
//						$active 	 = (!empty($_POST["active"])) ? protect($this->request->data->active) : 0 ;
//						$description = $this->request->data->description;
//						$otherdata	 = $datauser->cache;
//						$info		 = $datauser->info;
//						$otherdata["cle"] = $password;
//
//						$info["website"] 	= protect($this->request->data->website);
//						$info["facebook"] 	= protect($this->request->data->facebook);
//						$info["twitter"] 	= protect($this->request->data->twitter);
//						$info["googleplus"] = protect($this->request->data->googleplus);
//						$info["youtube"] 	= protect($this->request->data->youtube);
//						$info["github"] 	= protect($this->request->data->github);
//						$info["vimeo"] 		= protect($this->request->data->vimeo);
//						$info["linkedin"] 	= protect($this->request->data->linkedin);
//						$info["instagram"] 	= protect($this->request->data->instagram);
//						$info["flickr"] 	= protect($this->request->data->flickr);
//						$info["skype"] 		= protect($this->request->data->skype);
//						$info["tumblr"] 	= protect($this->request->data->tumblr);
//						$info["gender"] 	= protect($this->request->data->gender);
//						$info["birthday"] 	= protect($this->request->data->birthday_y).'-'.protect($this->request->data->birthday_d).'-'.protect($this->request->data->birthday_m);
//
//
//						################################################################ pseudo
//						if (!empty($_POST["username"])) {
//						 	$username 	 = protect($this->request->data->username);
//						 }else{
//						 	$username = $datauser->username;
//						 }
//	 					if ((empty($username))OR((usedb("username",$username,"User") == true)&&($username != $datauser->username))OR((is_arabic($nom)==true)OR(is_arabic($prenom)==true))) {
//	 						$username = pseudo($nom,$prenom);
//	 					}
//	 					########################################################################
//
//						########################################################### Upload image
//							if (!empty($_FILES['file']['name'])) {
//
//									$dir = SRC.DS."upload/users/profil/".$username;
//									if (!file_exists($dir)) {mkdir($dir,0777); }
//									$up = UploadImage("file",$dir);
//									if (!empty($up["data"])) {
//										$img = URL."/assets/upload/users/profil/".$username."/".$up['data']['newname'];
//									}
//
//							}else{
//								$img = $datauser->img;
//							}
//						######################################################## End Upload image
//
//						$otherdata   = datarray($otherdata,"convert");
//						$info   	 = datarray($info,"convert");
//
//	 						if ($isok == true) {
//								$this->User->update($d["datauser"]->id,array(
//									'nom' 			=> $nom,
//									'prenom' 		=> $prenom,
//									'username' 		=> $username,
//									'email' 		=> $email,
//									'password' 		=> md5($password),
//									'description'	=> $description,
//									'img' 			=> $img,
//									'role' 			=> $role,
//									'ref' 			=> 1,
//									'active' 		=> $active,
//									'info' 			=> $info,
//									'data'			=> $otherdata
//								));
//								$this->Session->setFlash(translater("success","success"));
//								$this->redirect("admin/users");
//							}else{
//								$this->Session->setFlash(translater("remp_false","danger"));
//								$this->redirect("admin/user/edit/".$id);
//							}
//
//					}else{
//						$this->Session->setFlash(translater("remp_false","danger"));
//						$this->redirect("admin/user/edit/".$id);
//					}
//				}
//
//			}else{$this->redirect("admin/users");}
//			$this->set($d);
//	}

####################################################################################
	######### Inbox (contact) ########################
			
  	function inbox(){
			$this->layout = 'cms';
			$d['title_for_layout'] = 'Inbox';  
			$d['rightmenu'] = array("categ"=>"inbox","pg"=>"list"); 
			//$d['datatab'] = 4; 
			//$this->loadModel('User');  
			//$d['users'] = userdata();

			$this->set($d);
  	}


####################################################################################
	########## delete data (tab,id,red)

	function deleteData($id){
		$tab = $_GET['tab'];
		$red = $_GET['red'];
		if (!empty($tab)&&!empty($id)&&!empty($red)) {
			if ($tab == "user") {
				$user = userdata($id);
				if (!empty($user)) { 
					$this->loadModel('User');
					$this->User->delete($user->id); 
				}
				
			}elseif ($tab == "bloqueuser") { 
				$user = userdata($id);
				if (!empty($user)) { 
					$this->loadModel('User');
					$this->User->update($user->id, array(
						'active' => 0 ,
					));
				}
			}elseif ($tab == "activeuser") { 
				$user = userdata($id);
				if (!empty($user)) { 
					$this->loadModel('User');
					$this->User->update($user->id, array(
						'active' => 1 ,
					));
				}
			}
			
			$this->redirect($red);
		}else{
			$this->redirect("");
		}

	}


	

} 
