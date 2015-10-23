<?php
	//post num with cond

	function CountData($cond,$model){ 
			$control = new Controller;
			$control->loadModel($model);
			$num = $control->$model->findCount($cond);  
				
		return $num; 
	}

	function FindDataUser($iduser,$model){ 
			$control = new Controller;
			$control->loadModel($model);
			$num = $control->$model->find(array(
						'conditions' => array('online'=> 1 , 'iduser'=>$iduser),
						'order' => 'date',
						'ordersens' => 'DESC'

					));  
				
		return $num; 
	}

?>