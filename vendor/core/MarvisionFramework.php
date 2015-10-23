<?php

	##### die default views

#### no database
	function MFVNoDatabase($data=null){
	 $divDEF = "<center>Impossible de se connecter à la base de donnée</center>";
		return die($divDEF);
	}