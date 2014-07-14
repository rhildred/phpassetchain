<?php
require_once(dirname(__FILE__) . '/simpletest/autorun.php');

class TestOfTemplates extends UnitTestCase {
    function TestURLRewriting() {
    	$sTest = file_get_contents("http://localhost/~rhildred/phpassetchain/www/urlRewrite");
    	$this->assertEqual($sTest, "Rich was here");
    }
    function TestHtmlInstead() {
    	$sTest = file_get_contents("http://localhost/~rhildred/phpassetchain/www/htmlFile");
    	$this->assertEqual($sTest, "Rich was here");
    }
    function TestCompiler() {
    	$sTest = file_get_contents("http://localhost/~rhildred/phpassetchain/www/newFile");
    	$this->assertEqual($sTest, "Rich was here");
    }
    function TestYear() {
    	$sTest = file_get_contents("http://localhost/~rhildred/phpassetchain/www/YearTest");
    	$this->assertEqual($sTest, "The Year is 2014");
    }
    function TestTemplate() {
    	$sTest = file_get_contents("http://localhost/~rhildred/phpassetchain/www/templated");
    	$this->assertEqual($sTest, "Rich was here, \nSo There!");
    }
}
?>
