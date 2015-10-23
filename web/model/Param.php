<?php
	class Param extends Model
	{
		 
	}

	 
$model = array(  
######################################################################################
# 	type Exemple : INT,VARCHAR,TEXT,DATE,TIME,DATETIME,BOOLEAN,...
######################################################################################
# @ params.id is default 
# db : param 
 
# @ params.title 
#########################
	"title" 	=> array(
		"type" 	=> "VARCHAR",
		"size" 	=> "255" 
	),
# @ params.value
#########################
	"value" => array(
		"type" 	=> "TEXT" 
	), 
# @ params.type /// 
#########################
  "type" => array(
    "type"  => "VARCHAR" 
  ), 
# @ params.data
#########################
	"data" => array(
		"type" 	=> "TEXT" 
	), 
######################################################################################

);