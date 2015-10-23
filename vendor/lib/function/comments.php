<?php  
	//Send Comment
 
	if (isset($_POST["sendComm"])) {  
		if ((!empty($_SESSION['PgVue']))&&(!empty($_SESSION['User']))&&(!empty($_POST["commCont"]))) {
			//`id`, `user`, `idpost`, `typepost`, `content`, `date`, `likes`, `parent`, `online`
 
			$parent = (!empty($_POST['parent'])) ? protect($_POST['parent']) : 0 ;
			$content = protect($_POST['commCont']);
			$model   = $_SESSION['PgVue']['model'];
			$id      = $_SESSION['PgVue']['id'];
			$control = new Controller; 
			$control->loadModel("Comment");
			$control->loadModel($model);
			$data = $control->$model->findFirst(array('conditions' => array('id' => $id ))); 
			if (!empty($data)) {
				$control->Comment->add(array(
							'user' 		=> $_SESSION["User"]->id,  
							'idpost' 	=> $id, 
							'typepost' 	=> $model,
							'content' 	=> $content,  
							'parent' 	=> $parent, 
							'online' 	=> 1, 
							'date' 		=> date("Y-m-j h:i:s")
						)); 
			$thiscomm = $control->Comment->findFirst( array('conditions' => array(
								'user' 		=> $_SESSION["User"]->id,  
								'idpost' 	=> $id, 
								'typepost' 	=> $model,
								'content' 	=> $content,
								'date' 		=> date("Y-m-j h:i:s")
						))); 
				if ($parent == 0) {
				 	$control->redirect(ThisUrl2LOAD().'#comment_'.$thiscomm->id);
				}else{
					$control->redirect(ThisUrl2LOAD().'?comm_p='.$parent.'#souCmm'.$parent);
				}
			}
		}
	}

	function GetCommentRelated($id,$model,$parent=null){

			$control = new Controller; 
			$control->loadModel("Comment"); 
			if (!empty($parent)) {
				$data = $control->Comment->find(array(
							'conditions' => array('online'=> 1 , 'typepost' => $model , 'idpost' => $id , 'parent' => $parent),
							'order' => 'date',
							'ordersens' => 'DESC' 

						)); 
			}else{
				$data = $control->Comment->find(array(
							'conditions' => array('online'=> 1 , 'typepost' => $model , 'idpost' => $id , 'parent' => 0),
							'order' => 'date',
							'ordersens' => 'DESC' 

						)); 
			}
			return $data;
	}

	if (!empty($_GET["comm_p"])) {
		$comment = $_GET["comm_p"];
		echo "<style>#souCmm".$comment."{ display:block!important;}</style>";
	}


	function NumSouComment($idcomment){ 
		$control = new Controller; 
		$control->loadModel("Comment"); 

		$data = $control->Comment->find(array(
							'conditions' => array('parent' => $idcomment)

						));
		return count($data);
	}

/************* System like ******************************/
	# add like  

		if (!empty($_GET['likeComment'])) {
				//securite
				#idcomment&iduser&date
				$idcomment = protect($_GET['likeComment']);
				$control = new Controller; 
				$control->loadModel("Comment"); 
				$data = $control->Comment->findFirst(array('conditions' => array('id' => $idcomment ))); 
				if ((!empty($data))&&(!empty($_SESSION['User']))&&(YouLikedThis($idcomment) == false)) {
					$like = datarray($data->likes,"deconvert");
					$like[date("Y-m-j h:i:s")] = $_SESSION['User']->id;
					$Notif[$_SESSION['User']->id] = 0;
					$control->Comment->update($idcomment,array(
									'likes' => datarray($like,"convert")
								)); 
					$control->Comment->update($idcomment,array(
									'LikeNotif' => 0
								)); 
					if ($data->parent == 0) {
					 	$control->redirect(ThisUrl2LOAD().'#comment_'.$idcomment);
					}else{
						$control->redirect(ThisUrl2LOAD().'?comm_p='.$data->parent.'#souCmm'.$data->parent);
					}
				} 
			}
	# dislike 
		if (!empty($_GET['dislikeComment'])) {
				//securite
				#idcomment&iduser&date
				$idcomment = protect($_GET['dislikeComment']);
				$control = new Controller; 
				$control->loadModel("Comment"); 
				$data = $control->Comment->findFirst(array('conditions' => array('id' => $idcomment ))); 
				if ((!empty($data))&&(!empty($_SESSION['User']))&&(YouLikedThis($idcomment) == true)) {
					$like = datarray($data->likes,"deconvert");
					foreach ($like as $key => $val) {
						if ((!empty($_SESSION['User']))&&($val["user"] == $_SESSION["User"]->id)) {
								//
							}else{
								$list[$val["date"]] = $val["user"]; 
							}
					}
					$control->Comment->update($idcomment,array(
									'likes' => datarray($list,"convert")
								)); 
					$control->Comment->update($idcomment,array(
									'LikeNotif' => 0
								)); 
					if ($data->parent == 0) {
					 	$control->redirect(ThisUrl2LOAD().'#comment_'.$idcomment);
					}else{
						$control->redirect(ThisUrl2LOAD().'?comm_p='.$data->parent.'#souCmm'.$data->parent);
					}
				} 
			}
	# delete 
		if (!empty($_GET['DeleteComment'])) {
				//securite
				#idcomment&iduser&date
				$idcomment = protect($_GET['DeleteComment']);
				$control = new Controller; 
				$control->loadModel("Comment"); 
				$data = $control->Comment->findFirst(array('conditions' => array('id' => $idcomment ))); 
				$model = $data->typepost;
				$control->loadModel($model); 
				$post = $control->$model->findFirst(array('conditions' => array('id' => $data->idpost ))); 
				if (!empty($post->iduser)) {
					$auteur = $post->iduser;
				}else{
					$auteur = $post->user;
				}
				if ($data->parent != 0) {
					$parentComm = $control->Comment->findFirst(array('conditions' => array('id' => $data->parent ))); 
					$userparent = $parentComm->user;
				}else{
					$userparent = $data->user;
				}
				if ((!empty($data))&&(!empty($_SESSION['User']))&&(($data->user == $_SESSION['User']->id)OR($userparent == $_SESSION['User']->id)OR($_SESSION['User']->id == $auteur))) {
					if ($data->parent == 0) {
						$relatedComment = $control->Comment->find(array(
									'conditions' => array('parent' => $idcomment) 
								)); 
						foreach ($relatedComment as $key => $r_comm) {
							$control->Comment->delete($r_comm->id,"id"); 
						}
					}
					$control->Comment->delete($idcomment,"id"); 
					$control->redirect(ThisUrl2LOAD().'#comment');
				} 
			}
	# find like OR count like
		function FindCommLike($idcomment,$out=null){ 
			$control = new Controller; 
			$control->loadModel("Comment"); 
			$comment = $control->Comment->findFirst(array(
					'conditions' => array('id' => $idcomment) 
				));
			if (!empty($comment->likes)) {
				$likes = datarray($comment->likes,"deconvert");
				$list = array();
				$i = 0;
				foreach ($likes as $date => $user) {
					$list[$i]['user'] = $user;
					$list[$i]['date'] = $date;
					$i++;
				}
				$count = count($likes);

				if (!empty($out)) {
					if ($out == "count") {
						return $count;
					}
				}else{
					return $list;
				}
			}else{
				return false;
			}
		}
	# list user add like

		function FindCommLikeUser($idcomment){ 
			$alluser = FindCommLike($idcomment);
				$txt = "<i class='ion ion-ios-person'></i> ";
				if (!empty($alluser)) {  
					if (count($alluser) == 1) {
						if (!empty($_SESSION['User'])&&($_SESSION['User']->id == $alluser[0]['user'])) {
							$txt .= "<a href='".URL."/".$_SESSION['User']->username."'>".translater("you")."</a> ".translater("like_this");
						}else{
							$txt .= "<a href='".URL."/".userdata($alluser[0]['user'])->username."'>".userdata($alluser[0]['user'])->infullname."</a> ".translater("like_this");
						}
					}elseif (count($alluser) == 2) {
						 	$k = 0;
						foreach ($alluser as $key => $data) {
							if ((!empty($_SESSION['User']))&&($data["user"] == $_SESSION["User"]->id)) {
								$me = true;
							}else{
								$autre[$k] = $data;
								$k++;
							}
						}
						if (!empty($me)) {
							$txt .= "<a href='".URL."/".$_SESSION['User']->username."'>".translater("you")."</a> ".translater("and")." <a href='".URL."/".userdata($autre[0]['user'])->username."'>".userdata($autre[0]['user'])->infullname."</a> ".translater("slike_this");
						}else{
							$txt .= "<a href='".URL."/".userdata($autre[0]['user'])->username."'>".userdata($autre[0]['user'])->infullname."</a> ".translater("and")." <a href='".URL."/".userdata($autre[1]['user'])->username."'>".userdata($autre[1]['user'])->infullname."</a> ".translater("slike_this");
						}
					}elseif (count($alluser) == 3) {
							$k = 0;	
						foreach ($alluser as $key => $data) {
							if ((!empty($_SESSION['User']))&&($data["user"] == $_SESSION["User"]->id)) {
								$me = true;
							}else{
								$autre[$k] = $data;
								$k++;
							}
						}
						
						if (!empty($me)) {
							$txt .= "<a href='".URL."/".$_SESSION['User']->username."'>".translater("you")."</a> , <a href='".URL."/".userdata($autre[0]['user'])->username."'>".userdata($autre[0]['user'])->infullname."</a> ".translater("and")." <a href='".URL."/".userdata($autre[1]['user'])->username."'>".userdata($autre[1]['user'])->infullname."</a> ".translater("slike_this");
						}else{
							$txt .= "<a href='".URL."/".userdata($autre[0]['user'])->username."'>".userdata($autre[0]['user'])->infullname."</a> , <a href='".URL."/".userdata($autre[1]['user'])->username."'>".userdata($autre[1]['user'])->infullname."</a>  ".translater("and")." <a href='".URL."/".userdata($autre[2]['user'])->username."'>".userdata($autre[2]['user'])->infullname."</a> ".translater("slike_this");
						}
					}else{
							$k = 0;	
							$n = count($alluser) - 2;
						foreach ($alluser as $key => $data) {
							if ((!empty($_SESSION['User']))&&($data["user"] == $_SESSION["User"]->id)) {
								$me = true;
							}else{
								$autre[$k] = $data;
								$k++; 
							}
						}
						
						if (!empty($me)) {
							$txt .= "<a href='".URL."/".$_SESSION['User']->username."'>".translater("you")."</a> , <a href='".URL."/".userdata($autre[0]['user'])->username."'>".userdata($autre[0]['user'])->infullname."</a> ".translater("and")." <a href='javascript:;' onclick='OpenthisList(".$idcomment.");'>".$n." ".translater("moreperson")."</a> ".translater("slike_this");
						}else{
							$txt .= "<a href='".URL."/".userdata($autre[0]['user'])->username."'>".userdata($autre[0]['user'])->infullname."</a> , <a href='".URL."/".userdata($autre[1]['user'])->username."'>".userdata($autre[1]['user'])->infullname."</a>  ".translater("and")." <a href='javascript:;' onclick='OpenthisList(".$idcomment.");'>".$n." ".translater("moreperson")."</a> ".translater("slike_this");
						}

					} 
					return $txt;
				}
		}

		function YouLikedThis($idcomment){ 
			$alluser = FindCommLike($idcomment);
			if (!empty($alluser)) {
				foreach ($alluser as $key => $data) {
					if ((!empty($_SESSION['User']))&&($data["user"] == $_SESSION["User"]->id)) {
						$result = true;
					}else{
						$result = false;
					}
				}
				return $result;
			}
		}

?>