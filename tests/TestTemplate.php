<?php
require_once(dirname(__FILE__) . '/simpletest/autorun.php');

class TestOfTemplates extends UnitTestCase {
    function TestURLRewriting() {
    	$sTest = file_get_contents("http://localhost/~rhildred/razor/www/urlRewrite");
    	$this->assertEqual($sTest, "Rich was here");
    }
    function TestHtmlInstead() {
    	$sTest = file_get_contents("http://localhost/~rhildred/razor/www/htmlFile");
    	$this->assertEqual($sTest, "Rich was here");
    }
    function TestCompiler() {
    	$sTest = file_get_contents("http://localhost/~rhildred/razor/www/newFile");
    	$this->assertEqual($sTest, "Rich was here");
    }
}
?>
