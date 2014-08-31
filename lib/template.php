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
		if(file_exists($Viewbag->sPage)){
			include($Viewbag->sPage);
		}else{
			include($Viewbag->sPage . ".phtml");
		}

	}
}

require_once(dirname(__FILE__) . '/php-markdown-lib/Michelf/MarkdownExtra.inc.php');

function renderMarkdown($sFname){
	echo \Michelf\MarkdownExtra::defaultTransform(file_get_contents($sFname));
}

function renderPartial($oCollection, $sPartial)
{
	global $Viewbag;
	if(!is_array($oCollection)){
		$oCollection = json_decode(file_get_contents($oCollection));
	}
	foreach($oCollection as $oModel){
		$Viewbag->model = $oModel;
		include $sPartial;
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
