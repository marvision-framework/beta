<?php

	function UploadNPP(){ 
		//verif
		//upload
		//alert
		if (isset($_POST["UploadNPP"])) {
				$control = new Controller; 
				$control->loadModel("User");
				$path = $_FILES['file']['tmp_name'];
				$type = $_FILES['file']['type'];
				$size = $_FILES['file']['size'];
				if ((!empty($_FILES['file']['tmp_name']))AND(is_image($path) == true)AND($type=="image/jpeg")AND(!empty($_POST["image-data"]))AND($size < 5242880)) {	//5mb
					$dir = SRC.DS."upload/users/profil/".$_SESSION["User"]->username;
					if (!file_exists($dir)) {mkdir($dir,0777); }
					$url = $_POST["image-data"];
					//$img = basename($url).".jpg";
					$img = date('ymj')."img_".date("his").".jpg";
					file_put_contents($dir."/".$img, file_get_contents($url));
					$newimg = URL."/assets/upload/users/profil/".$_SESSION["User"]->username."/".$img;
					$control->User->update($_SESSION["User"]->id,array(
						'img' 			=> $newimg
					)); 
					$newSession = userdata($_SESSION["User"]->id);
					$control->Session->write('User',$newSession);
					$control->Session->setFlash(translater("success","success")); 

				}else{
					$control->Session->setFlash(translater("remp_false","danger")); 
				}
					$control->redirect($_SESSION['User']->username);
		}

	}

	function AddStatut($user){
		if (isset($_POST['addstatut'])) {
		if ((!empty($user->id))AND(!empty($_SESSION['User']))) {
			if ($_SESSION['User']->id == $user->id) {
				if ((RoleActeur('User'))OR(RoleActeur('Admin'))OR(RoleActeur('WM'))) {
							$control = new Controller; 
							$control->loadModel("Statut");
							$statut = protect($_POST['statut']);
							$online = protect($_POST['online']); 
						if (!empty($statut)) {  
							$control->Statut->add(array(
								'type' 		=> "statut",  
								'user' 		=> $_SESSION["User"]->id, 
								'online' 	=> $online,
								'date' 		=> date("Y-m-j h:i:s"), 
								'content' 	=> $statut
							)); 

							$control->Session->setFlash(translater("success","success")); 
							$control->redirect($_SESSION['User']->username.'#statut');

						}
					}
				}
			}
		}
	}

	function AddForum($user){
		if (isset($_POST['addforum'])) {
		if ((!empty($user->id))AND(!empty($_SESSION['User']))) {
			if ($_SESSION['User']->id == $user->id) {
				if ((RoleActeur('UserVerif'))OR(RoleActeur('Admin'))OR(RoleActeur('WM'))) {
							$control = new Controller; 
							$control->loadModel("Forum");
							$title 		= protect($_POST['title']);
							$content 	= protect($_POST['description']); 
							$tags 		= no_space_txt(protect($_POST['tags'])); 
						if (!empty($title)&&!empty($content)&&!empty($tags)) { 
							$VerifTag = ""; 
							foreach (toarray($tags) as $key => $tag) {
							 	if (verifTags(Remp_SpCaract($tag)) == true) {
							 		$VerifTag = $VerifTag."".Remp_SpCaract($tag).","; 
							 	}
							 }  
							$question = array('title' => $title,'content' => $content );
							$data = datarray($question,"convert");
							$control->Forum->add(array(
								'type' 		=> 0,  
								'user' 		=> $_SESSION["User"]->id, 
								'online' 	=> 0,
								'date' 		=> date("Y-m-j h:i:s"), 
								'data' 		=> $data, //content question+title
								'tags' 		=> $VerifTag
							)); 

							$control->Session->setFlash(translater("success","success")); 
							$control->redirect($_SESSION['User']->username.'#question');

						}else{

							$control->Session->setFlash(translater("remp_false","danger")); 
							$control->redirect($_SESSION['User']->username.'#question');
						}
					}
				}
			}
		}
	}

	function DeleteUserPost($user){
		if (isset($_POST['DelData'])) {  
		if ((!empty($user->id))AND(!empty($_SESSION['User']))) { 
			if ($_SESSION['User']->id == $user->id) { 
				if ((RoleActeur('User'))OR(RoleActeur('Admin'))OR(RoleActeur('WM'))) { 
							$model 		= protect($_POST['mod']);
							$id 		= protect($_POST['num']);
						if (!empty($model)&&!empty($id)) { 
							$control = new Controller;  
							$control->loadModel($model); 
							$control->loadModel("Comment"); 
							
							$data = $control->$model->findFirst(array(
								 'conditions' => array('id' => $id )));
							if ((!empty($data))&&($data->user == $_SESSION["User"]->id)) { 								# delete
								//statut
								if ($model == "Statut") { 
									# delete all comments typepost = statut et idpost = $id 
									$allcomments = $control->Comment->find(array(
														'conditions' => array( 
															"typepost" 	=> "statut",
															"idpost" 	=> $data->id
														))); 
									foreach ($allcomments as $key => $comment) {
										$control->Comment->delete($comment->id); 
									} 
									# delete statut
									$control->$model->delete($data->id);  
								}
							}

							$control->Session->setFlash(translater("success","success"));  
							$control->redirect($_SESSION['User']->username);

						}
					}
				}
			}
		}
	}
?>