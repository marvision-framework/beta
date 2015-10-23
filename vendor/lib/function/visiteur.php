<?php

	function get_ip() {

			//Just get the headers if we can or else use the SERVER global
			if ( function_exists( 'apache_request_headers' ) ) {

				$headers = apache_request_headers();

			} else {

				$headers = $_SERVER;

			}

			//Get the forwarded IP if it exists
			if ( array_key_exists( 'X-Forwarded-For', $headers ) && filter_var( $headers['X-Forwarded-For'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 ) ) {

				$the_ip = $headers['X-Forwarded-For'];

			} elseif ( array_key_exists( 'HTTP_X_FORWARDED_FOR', $headers ) && filter_var( $headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 )
			) {

				$the_ip = $headers['HTTP_X_FORWARDED_FOR'];

			} else {
				
				$the_ip = filter_var( $_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4 );

			}

			return $the_ip;

		}

		function get_Curl() { 
				$the_url = $_SERVER['REQUEST_URI'];
				return $the_url;

			}

		function get_Nav($u_agent){
		    //$u_agent = $_SERVER['HTTP_USER_AGENT'];
		    $bname = 'Unknown';
		    $platform = 'Unknown';
		    $version= "";

		    //First get the platform?
		    if (preg_match('/linux/i', $u_agent)) {
		        $platform = 'linux';
		    }
		    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
		        $platform = 'mac';
		    }
		    elseif (preg_match('/windows|win32/i', $u_agent)) {
		        $platform = 'windows';
		    }

		    // Next get the name of the useragent yes seperately and for good reason
		    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
		    {
		        $bname = 'Internet Explorer';
		        $ub = "IE";
		    }
		    elseif(preg_match('/Firefox/i',$u_agent))
		    {
		        $bname = 'Mozilla Firefox';
		        $ub = "Firefox";
		    }
		    elseif(preg_match('/Chrome/i',$u_agent))
		    {
		        $bname = 'Google Chrome';
		        $ub = "Chrome";
		    }
		    elseif(preg_match('/Safari/i',$u_agent))
		    {
		        $bname = 'Apple Safari';
		        $ub = "Safari";
		    }
		    elseif(preg_match('/Opera/i',$u_agent))
		    {
		        $bname = 'Opera';
		        $ub = "Opera";
		    }
		    elseif(preg_match('/Netscape/i',$u_agent))
		    {
		        $bname = 'Netscape';
		        $ub = "Netscape";
		    }

		    // finally get the correct version number
		    $known = array('Version', $ub, 'other');
		    $pattern = '#(?<browser>' . join('|', $known) .
		    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
		    if (!preg_match_all($pattern, $u_agent, $matches)) {
		        // we have no matching number just continue
		    }

		    // see how many we have
		    $i = count($matches['browser']);
		    if ($i != 1) {
		        //we will have two since we are not using 'other' argument yet
		        //see if version is before or after the name
		        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
		            $version= $matches['version'][0];
		        }
		        else {
		            $version= $matches['version'][1];
		        }
		    }
		    else {
		        $version= $matches['version'][0];
		    }

		    // check if we have a number
		    if ($version==null || $version=="") {$version="?";}

		    return array(
		        'userAgent' => $u_agent,
		        'fullname'  => $bname,
		        'name'      => $ub,
		        'version'   => $version,
		        'platform'  => $platform,
		        'pattern'    => $pattern
		    );
		}

	function get_Os($a){
		//$a=$_SERVER['HTTP_USER_AGENT'];
		$a=str_replace('+',' ',$a);
		if (preg_match('#windows\snt\s5\.1#i',$a))return('Microsoft Windows XP');
		if (preg_match('#linux\sx86_64#i',$a))return('Linux (64 bits)');
		if (preg_match('#linux#i',$a))return('Linux');
		if (preg_match('#libwww-fm#i',$a))return('Linux');
		if (preg_match('#freebsd#i',$a))return('FreeBSD');
		if (preg_match('#mac\sos\sx#i',$a))return('Mac OS X');
		if (preg_match('#windows\snt\s6\.1#i',$a))return('Microsoft Windows 7');
		if (preg_match('#haiku#i',$a))return('Haiku');
		if (preg_match('#windows\snt\s6\.0;\swow64#i',$a))return('Microsoft Windows Vista (64bits)');
		if (preg_match('#windows\snt\s6\.0;\swin64#i',$a))return('Microsoft Windows Vista (64bits)');
		if (preg_match('#windows\snt\s6\.0#i',$a))return('Microsoft Windows Vista');
		if (preg_match('#sunos#i',$a))return('Open Solaris');
		if (preg_match('#android#i',$a))return('Android');
		if (preg_match('#windows\s95#i',$a))return('Microsoft Windows 95');
		if (preg_match('#windows\snt\s5\.0#i',$a))return('Microsoft Windows 2000');
		if (preg_match('#windows\snt\s5\.3#i',$a))return('Microsoft Windows Server 2003');
		if (preg_match('#windows\snt#i',$a))return('Microsoft Windows NT');
		if (preg_match('#windows\s98#i',$a))return('Microsoft Windows 98');
		if (preg_match('#windows\sce#i',$a))return('Microsoft Windows Mobile');
		if (preg_match('#windows\sphone\sos[\s\/]([0-9v]{1,7}(?:\.[0-9a-z]{1,7}){0,7})#i',$a,$c))return('Microsoft Windows Phone version '.$c[1]);
		if (preg_match('#mac_powerpc#i',$a))return('Mac OS X');if (preg_match('#macintosh#i',$a))return('Macintosh');
		if (preg_match('#cygwin_nt#i',$a))return('Microsoft Windows 2000');
		if (preg_match('#os\/2#i',$a))return('Microsoft OS/2');
		if (preg_match('#symb(?:ian)#i',$a,$c))return('Symbian OS');
		if (preg_match('#symbian-crystal[\s\/]([0-9v]{1,7}(?:\.[0-9a-z]{1,7}){0,7})#i',$a,$c))return('Symbian OS version '.$c[1]);
		if (preg_match('#offbyone;\swindows\s2000#i',$a))return('Microsoft Windows XP');
		if (preg_match('#windows\s2000#i',$a))return('Microsoft Windows 2000');
		if (preg_match('#nintendo\swii#i',$a))return('Nintendo Wii');
		if (preg_match('#playstation\sportable#i',$a))return('PlayStation Portable');
		if (preg_match('#iphone\sos\s[\s\/]([0-9v]{1,7}(?:[\._][0-9a-z]{1,7}){0,7})#i',$a,$c))return('iPhone OS version '.$c[1]);
		if (preg_match('#nokia\s?([^\/]+)#i',$a,$c))return('Nokia'.$c[1]);
		if (preg_match('#najdi\.si#i',$a))return('Najdi.si');
		if (preg_match('#beos#i',$a))return('BeOS');
		if (preg_match('#fedora#i',$a))return('Fedora');
		if (preg_match('#openvms#i',$a))return('Open Virtual Memory System');
		if (preg_match('#openbsd#i',$a))return('OpenBSD');
		if (preg_match('#ask\.com#i',$a))return('Ask.com');
		if (preg_match('#tinybrowser\.com#i',$a))return('Tiny');
		if (preg_match('#whoisde\.de#i',$a))return('Whoisde.de');
		if (preg_match('#heritrix#i',$a))return('Heritrix (Internet Archive) bot');
		if (preg_match('#Amigaos#i',$a))return('AmigaOS');
		if (preg_match('#depspid\.net#i',$a))return('DepSpid');
		if (preg_match('#dejavu\.org#i',$a))return('Emulateur de navigateur');
		if (preg_match('#psp\s#i',$a))return('PlayStation Portable');
		if (preg_match('#\spsp#i',$a))return('PlayStation Portable');
		if (preg_match('#sonyericsson\s?([^\/]+)#i',$a,$c))return('Sony Ericsson '.$c[1]);
		if (preg_match('#windows\s7#i',$a))return('Microsoft Windows 7');
		if (preg_match('#windows\s8#i',$a))return('Microsoft Windows 8');
		if (preg_match('#windows\s9#i',$a))return('Microsoft Windows 9');
		if (preg_match('#windows\sme#i',$a))return('Microsoft Windows Millenium');
		if (preg_match('#nt\s5\.1#i',$a))return('Microsoft Windows XP');
		if (preg_match('#winnt#i',$a))return('Microsoft Windows NT');
		if (preg_match('#win98#i',$a))return('Microsoft Windows 98');
		if (preg_match('#win95#i',$a))return('Microsoft Windows 95');
		if (preg_match('#netbsd#i',$a))return('NetBSD basé sur UNIX');
		if (preg_match('#irix64#i',$a))return('Irix (64bits) basé sur UNIX');
		if (preg_match('#irix#i',$a))return('Irix basé sur UNIX');
		if (preg_match('#cerberian#i',$a))return('Cerberian');
		if (preg_match('#win\s9x\s4.0#i',$a))return('Microsoft Windows 95');
		if (preg_match('#win\s9x\s4.90#i',$a))return('Microsoft Windows Millennium');
		if (preg_match('#win\s9x\s4.1#i',$a))return('Microsoft Windows 98');
		if (preg_match('#windows\s3\.1#i',$a))return('Microsoft Windows 3.1');
		if (preg_match('#j2me#i',$a))return('Java 2 Platform');
		if (preg_match('#playstation\s?3#i',$a))return('PlayStation 3');
		if (preg_match('#blackberry#i',$a))return('BlackBerry OS');
		if (preg_match('#iphone#i',$a))return('iPhone');
		if (preg_match('#windows#i',$a))return('Microsoft Windows');
		return 'OS non identifié';
		}

		function get_city($ip=null) {
			if (empty($ip)) {
				$ip = get_ip();
			}
		    	//$ip = get_ip();
		 //check, if the provided ip is valid
		               if(!filter_var($ip, FILTER_VALIDATE_IP))
		               {
		                       throw new InvalidArgumentException("IP is not valid");
		               }

		               //contact ip-server
		               $response=@file_get_contents('http://www.netip.de/search?query='.$ip);
		              
		               if (!empty($response)) {
			               	//Array containing all regex-patterns necessary to extract ip-geoinfo from page
			               $patterns=array();
			               $patterns["host"] = '#Name: (.*?)&nbsp;#i';
			               $patterns["domain"] = '#Domain: (.*?)&nbsp;#i';
			               $patterns["country"] = '#Country: (.*?)&nbsp;#i';
			               
			               $patterns["region"] = '#State/Region: (.*?)<br#i';
			               $patterns["city"] = '#City: (.*?)<br#i';

			               //Array where results will be stored
			               $ipInfo=array();

			               //check response from ipserver for above patterns
			               foreach ($patterns as $key => $pattern){
			                       //store the result in array
			                       $ipInfo[$key] = preg_match($pattern,$response,$value) && !empty($value[1]) ? $value[1] : 'not found';
			               }
			               
			               if (!empty($ipInfo["country"])) {
			               	$ipInfo["flag"] = datarray($ipInfo["country"],"auto"," - ")[0];//strtolower()#min
			               }
			               //die(var_dump($ipInfo));
		               }else{
		               		
			               $ipInfo["host"] = "-";
			               $ipInfo["domain"] = "-";
			               $ipInfo["country"] =  "-";
			               $ipInfo["region"] =  "-";
			               $ipInfo["city"] =  "-";
		               }
		               
		               if ($ipInfo["host"] == "localhost") { 
			               //$ipInfo["host"] = "-";
			               $ipInfo["domain"] = "172.0.0.1";
			               $ipInfo["country"] =  "Tunisia";
			               $ipInfo["region"] =  "Mahdia";
			               $ipInfo["city"] =  "Rejiche";
			               $ipInfo["flag"] =  "TN";
		               }
		               return $ipInfo;
		        
		}

########################################################################################################

	function AutoVerifSESSION($force=null){ 

		$nowTMP = date("YmjHi"); 
		$control = new Controller;
		$control->loadModel("User"); 
		///UserData
		if (!empty($_SESSION['User'])) { 
			if (!empty($force)OR($_SESSION['User']->tmp < ($nowTMP - 1))) { 
				//force get data
				$data = $control->User->findFirst(array('conditions' => array('id'=> $_SESSION['User']->id)));
				if (!empty($data)) {
					//force set data
					$control->User->update($data->id,array(
											'connect' 	=> 1,
											'tmp' => $nowTMP,
											'pg' => datarray($_SESSION['User']->rss,"convert")
										));
					$data->connect = 1;
					$data->tmp = $nowTMP;
					$data->pg = datarray($_SESSION['User']->rss,"convert");
					$_SESSION["User"] = userdata($data);
					

				}else{
					$control->redirect('logout');
				}
			}
 
		}
	}

##############################################################################################

	function AutoVerifData(){
		# UserData
		//connectOrDesconnect
		$nowTMP = date("YmjHi"); 
		$control = new Controller;
		$control->loadModel("User"); 
		foreach (findAllUser() as $key => $Oneuser) {
			if ((($Oneuser->tmp + 10) < $nowTMP)&&($Oneuser->connect == 1)) {
				# is off line
				$control->User->update($Oneuser->id,array(
										'connect' 	=> 0,
										'last_logout' => DateNow(),
									));  
			}
		}
	}

#######################################################################################################

?>

