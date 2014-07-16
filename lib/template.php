<?php
$Viewbag = new stdClass();
$Viewbag->bInLayout = false;

function layout($sLayout){
	global $Viewbag;
	if(!$Viewbag->bInLayout){
		$Viewbag->bInLayout = true;
		//don't want to output anything from sScript the first time
		if(isset($Viewbag->sScript)){
			$Viewbag->sPage = str_replace('.phtml','',basename($Viewbag->sScript));
			include_once dirname($Viewbag->sScript) . '/' . $sLayout;
			$Viewbag->sOut = ob_get_contents();
		}else{
			$Viewbag->sPage = str_replace('.phtml','',basename($_SERVER['PHP_SELF']));
			include_once $sLayout;
			exit;
		}
	}
}

function renderBody(){
	global $Viewbag;
	if(isset($Viewbag->sScript)){
		include($Viewbag->sScript . ".phtml");
	}else{
		include($Viewbag->sPage . ".phtml");
	}
}

if(!function_exists("showcopyright")) {
	function showcopyright(){
		$nYear = date("Y");
		if($nYear != 2013){
			echo "2013-";
		}
		echo $nYear;
	}
}
?>