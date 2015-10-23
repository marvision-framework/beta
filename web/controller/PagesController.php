<?php

	class PagesController extends Controller
	{
		function test(){ 
			$this->layout = 'default';
			$d['thisongl'] = 'test';
			
			//die(debug($result_yml));
			$this->set($d);
		} 


		function home(){
			$this->layout = 'home';
			$d['thisongl'] = 'home';   

			$this->set($d);
		}
 
		 


	}
?>