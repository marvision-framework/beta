<?php 

	$debut = microtime(true);
	$hostdomain = "";//your domain here
	$siteName = "";//your Web site Name here
	$siteLangue = "fr";

	
if (isset($_SERVER['HTTP_CLIENT_IP']) || isset($_SERVER['HTTP_X_FORWARDED_FOR']) || !(in_array(@$_SERVER['REMOTE_ADDR'], array('127.0.0.1', 'fe80::1', '::1')) || php_sapi_name() === 'cli-server'))
{ 
	define('HOST', 'domain');
	define('BASE_SRC', $hostdomain."/assets"); 
	define('BASE_URL', $hostdomain."/"); 
	define('URL', $hostdomain); 
}else{
	 
	define('HOST', 'local');
	define('BASE_SRC', dirname($_SERVER['SCRIPT_NAME'])."/assets"); 
	define('BASE_URL', dirname(dirname($_SERVER['SCRIPT_NAME']))); 
	define('URL', dirname($_SERVER['SCRIPT_NAME'])); 
}

	define('SiteLangue', $siteLangue);//site lang " / " 
	define('SiteName', $siteName);//site name " / " 
	define('DS', DIRECTORY_SEPARATOR);//separateur " / " 
	define ('APP',dirname(__FILE__));//root constant de app
	define ('ROOT',dirname(APP));//root constant de site
	define ('SRC',ROOT.'/assets');//url de fiche src  
	define ('WEB',ROOT.'/web');//url de fiche web  
	define ('APP_config',APP.'/config');//url de fiche app/config  
	define ('VENDOR',ROOT.'/vendor');//url de fiche core 
	define ('CORE',ROOT.'/vendor/core');//url de fiche core 
	define ('WEBROOT',WEB.'/view/core');//url de fiche core  

	define ('BOOT',BASE_SRC.'/_BOOT');//url de fiche core 
	define ('SRC_WEB',BASE_SRC.'/_WEB');//url de fiche src web 
?>
