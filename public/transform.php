<?php 

require_once '../lib/template.php';
$sScript = dirname(__FILE__) . $_SERVER['PATH_INFO'];
if(substr($sScript, -1) == "/") $sScript .= "index";

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

function showcopyright(){
	$nYear = date("Y");
	if($nYear != 2013){
		echo "2013-";
	}
	echo $nYear;
}


?>
