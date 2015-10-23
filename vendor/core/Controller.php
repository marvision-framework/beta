<?php

	class Controller
	{
		public $errors = array();//
		public $request;//oblet request
		private $vars = array(); //var à passeer àla vue
		public $layout = 'default';//layout etulise
		private $rendered = false;//si le rendu a ete fait ou nn ?

		function __construct($request = null){

			$this->Session = new Session();
			if($request){
					$this->request = $request; //stock la req dans l'instance
					require_once APP_config.'/security.php';
				}
				
		}

		public function render($view){
			if ($this->rendered) { return false;}
			extract($this->vars);
			if (strpos($view, '/') === 0) {
				$view = WEB.'/view'.$view.'.php';
			}else{
				$view = WEB.'/view'.DS.$this->request->controller.DS.$view.'.php';
			}
			ob_start();
			require($view);
			$content_for_layout = ob_get_clean();
			unset($_SESSION['Errors']);
			require WEB.'/view/layout'.DS.$this->layout.'.php';
			$this->rendered = true;
		}
		
		public function set($key,$value=null){
			if(is_array($key)){
				$this->vars += $key;
			}else{
				$this->vars[$key] = $value;
			}
		}

		//charger la model
		function loadModel($name){
			if (!isset($this->$name)) {
				$file = WEB.'/model'.DS.$name.'.php';
				require_once($file);
				$this->$name = new $name();
				if (isset($this->Form)) {
					$this->$name->Form = $this->Form;
				}
			}

		}
		//charger la model
		function loadForm($verif){
			$form = new Form();
			$num = 0;
			foreach($verif as $function => $value){
				$errors[$function] = $form->$function($value);
				debug($errors[$function]);
				$num = count($errors[$function]);
			}
			$this->Session->write('Errors',$errors);
			return ($num != 0)? false:true;

		}

		//** appeller un conntroller depuis un vue 
		function request($controller,$action){
			$controller .= 'Controller';
			require_once WEB.'/controller'.DS.$controller.'.php';
			$c = new $controller();
			return $c->$action();
		}

		//** redirect
		function redirect($url,$code = null){
			if ($code == 301) {
				//header("HTTP/1.1 301 Moved Permanently");
			} 
			//header("Location: ".Router::url($url)); 
			if (headers_sent()) {
				    die('<script language="Javascript"> document.location.replace("'.Router::url($url).'");  </script>');
				}else{
				    exit(header("Location: ".Router::url($url)));
				}
				
		}

		// gerer les erreurs 404

		function e404($message){
			//header("HTTP/1.0 404 NOT Found");
			$this->set('message',$message);
			$this->render('/errors/404');
			die();
		}


	}
?>