<?php


	if(isset($_GET["lang"])){
			$file = ROOT.'/vendor/lib/lang/'.$_GET["lang"].'/translate.yml';
			if (file_exists($file)) { 
					$lang = new Session();
					$lang->write('Lang',$_GET["lang"]);
			}
	}
#######################################################################
	######################ACTIVATION SESSION LANG #################

	if(empty($_SESSION['Lang'])){
		$lang = new Session();
		$lang->write('Lang',SiteLangue);
	}


######################################################################
###################################################################################################################
########### Translater : 
	####### Time :  translater("$1","time","$2"); /// $1 : jour/moin & $2 : val in $1 array (or empty = null)
###############################################################################################################
	
	function translater($txt,$type=null,$val=null){
			if (isset($_SESSION["Lang"])) {
				$langSite = $_SESSION["Lang"];
			}else{ 
				$langSite = SiteLangue;
					$lang = new Session();
					$lang->write('Lang',$langSite);
			}
			$app_yml = new AppClassYML(); 
			if (!empty($type)) {
				$alert = array("danger","success","warning","info");
				$dic = ROOT.'/vendor/lib/lang/'.$_SESSION["Lang"].'/'.$type.'.yml';
				if (in_array($type, $alert)) {
					$trans = $app_yml->load("alert","lib","lang/".$langSite);  
					$trans = (!empty($trans[$type][$txt])) ? $trans[$type][$txt] : $txt ;
					$div = "<div style='padding:1%; '><div class='alert alert-dismissable alert-".$type." alert-dismissible fade in'><button  type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>×</span></button>";
					$trans = $div."<p>".$trans."</p></div></div>";
				}elseif (file_exists($dic)) { 
						$trans = $app_yml->load($type,"lib","lang/".$langSite); 
						if (!empty($val)) {
							$trans = (!empty($trans[$txt][$val])) ? $trans[$txt][$val] : "" ; 
						}else{ 
							$trans = (!empty($trans[$txt])) ? $trans[$txt] : array() ; 
						} 
				} 

			}else{
				$trans = $app_yml->load("translate","lib","lang/".$langSite); 
				$trans = (!empty($trans[$txt])) ? $trans[$txt] : "" ;
			} 
			return $trans;
	}

?>