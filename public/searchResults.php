<?php
require_once '../lib/template.php';
$Viewbag->sTitle = "Rich rocks!";
$Viewbag->q = $_GET["q"];
layout("_layout.phtml");
?>
<?php


$pageURL = (@$_SERVER["HTTPS"] == "on") ? "https://" : "http://";
if ($_SERVER["SERVER_PORT"] != "80")
{
    $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
}
else
{
    $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
}

$sPage = str_replace("searchResults?q=", "api/Stems/", $pageURL);
renderPartial($sPage, "_article.php");
?>
