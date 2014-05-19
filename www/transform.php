<?php 
$sScript = array_pop(explode("/", $_SERVER['REQUEST_URI']));
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
?>
