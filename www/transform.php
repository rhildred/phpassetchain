<?php 
$sScript = array_pop(explode("/", $_SERVER['REQUEST_URI']));
if(file_exists($sScript . ".js.html")){
	$sContents = file_get_contents($sScript  . ".js.html" );
	$aContents = preg_split("/(<%)/m", $sContents, -1, PREG_SPLIT_DELIM_CAPTURE);
	foreach($aContents as $n=>$sChunk){
		if($sChunk == "<%"){
			$aRest = explode("%>", $aContents[$n+1]);
			$sRest = <<< EOF
<?php
EOF;
			$sRest .= preg_replace("/^=/", " echo ", $aRest[0]);
			$aContents[$n] = $sRest . "?>";
			$aContents[$n+1] = $aRest[1];
		}
	
	}
	file_put_contents($sScript . ".php", implode("", $aContents) );
	
	include $sScript . ".php";
	
}elseif (file_exists($sScript . ".phtml")){
	$Viewbag = new stdClass();
	$Viewbag->bInLayout = false;
	$Viewbag->sScript = $sScript;
	ob_start();
	include $sScript . ".phtml";
	ob_end_clean();
	$sFName = $sScript . "." . date("Y") . ".html";
	file_put_contents($sFName, $Viewbag->sOut);
	include $sFName;
}


function layout($sLayout){
	global $Viewbag;
	if(!$Viewbag->bInLayout){
		$Viewbag->bInLayout = true;
		$Viewbag->sPage = str_replace('.php','',basename($_SERVER['PHP_SELF']));
		include_once $sLayout;
		//don't want to output anything from sScript the first time
		$Viewbag->sOut = ob_get_contents();
	}
}

function renderBody(){
	global $Viewbag;
	include($Viewbag->sScript . ".phtml");
}

?>
