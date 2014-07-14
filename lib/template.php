<?php
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